<?php

require_once 'model/om/BaseUser.php';


/**
 * @package model
 */ 
class User extends BaseUser {

	public function getFullName() {
		return $this->getFirstName(). ' '.$this->getLastName();
	}
	
	public function getInitials() {
		return strtolower(substr($this->getFirstName(),0,1).substr($this->getLastName(),0,1));
	}

	public function getUserKind() {
		return $this->getIsBackendLoginEnabled();
	}
	
	public function isFirstAdministrator() {
		return (UserPeer::doCount(new Criteria()) === 1) 
						&& $this->getIsAdmin() 
						&& !$this->getIsInactive()
						&& $this->getIsBackendLoginEnabled();
	}
	
	public function requiresUserName() {
		return trim($this->getFullName()) === '';
	}
	
	public function isSessionUser() {
		return $this->getId() === Session::getSession()->getUserId();
	}

	public function may($oPage, $sRightName) {
		if($this->getIsAdmin()) {
			return true;
		}
		//Aquire alls roles the user is in (direct as well as group roles)
		
		//FIXME: possible optimization: get all roles using getRoles(false) and getGroups() foreach getRoles() and consolidate
		foreach($this->getRoles() as $oRole) {
			if($oRole->may($oPage, $sRightName)) {
				return true;
			}
		}
		foreach($this->getGroups() as $oGroup) {
			if($oGroup->may($oPage, $sRightName)) {
				return true;
			}
		}
		return false;
	}
	
	public function mayEditPageDetails($oPage) {
		return $this->may($oPage, 'edit_page_details');
	}

	public function mayEditPageContents($oPage) {
		return $this->may($oPage, 'edit_page_contents');
	}

	public function mayCreateChildren($oPage) {
		return $this->may($oPage, 'create_children');
	}

	public function mayDelete($oPage) {
		return $this->may($oPage, 'delete');
	}

	public function mayViewPage($oPage) {
		return $this->may($oPage, 'view_page');
	}
	
	public function mayUseAdmimModule($sAdminModuleName, $bCheckEnabled = true) {
		//Case 1: Module is disabled (this check is not mandatory): deny
		if($bCheckEnabled && !Module::isModuleEnabled('admin', $sAdminModuleName)) {
			return false;
		}
		//Case 2: User is admin: allow
		if($this->getIsAdmin()) {
			return true;
		}
		$aModuleInfo = Module::getModuleInfoByTypeAndName('admin', $sAdminModuleName);
		$aGroupIds = isset($aModuleInfo['allowed_roles']) ? $aModuleInfo['allowed_roles'] : array();
		//Cases 3 and 4: No groups defined
		if(count($aGroupIds) === 0) {
			//Case 3: Access to module is unrestricted: allow
			//Case 4: Access to module is restricted to admins: deny (because the user is not one of them)
			return !(@$aModuleInfo['admin_required']);
		}
		//Case 5: Access is restricted to certain groups: allow if in group
		if(in_array($this->getRoles(true), $aGroupIds)) {
			return true;
		}
		foreach($this->getGroups() as $oGroup) {
		  if(in_array($oGroup->getRoles(true), $aGroupIds)) {
		    return true;
	    }
		}
		//Case 6: User is not in allowed groups
		return false;
	}
	
  public function getAdminSettings($sSection, $mDefaultResult = array()) {
		if($this->getBackendSettings() !== null) {
			$aSections = unserialize($this->getBackendSettings());
			if(isset($aSections[$sSection])) {
        return $aSections[$sSection];
			}
		}
    // @todo check users permission for module
    $mDefaultResult = Settings::getSetting(null, $sSection, $mDefaultResult, 'user_defaults');
    return $mDefaultResult;
	}
	
	public function setAdminSettings($sSection, $mValue) {
		$aSections = array();
	  if($this->getBackendSettings() !== null) {
			$aSections = unserialize($this->getBackendSettings());
	  }
    $aSections[$sSection] = $mValue;
    $this->setBackendSettings(serialize($aSections));
	}
	
	public function getGroups($bReturnNamesOnly = false) {
		$aResult = array();
		foreach($this->getUserGroupsRelatedByUserIdJoinGroup() as $oGroupUser) {
			if(!$bReturnNamesOnly) {
				$aResult[] = $oGroupUser->getGroup();
			} else {
				$aResult[] = $oGroupUser->getGroup()->getName();
			}
		}
		return $aResult;
	}
	
	public function getRoles($bReturnNamesOnly = false) {
		$aResult = array();
    $aUserRoles = $bReturnNamesOnly ? $this->getUserRolesRelatedByUserId() : $this->getUserRolesRelatedByUserIdJoinRole();
		foreach($aUserRoles as $oUserRole) {
			if($bReturnNamesOnly) {
				$aResult[] = $oUserRole->getRoleKey();
			} else {
				$aResult[] = $oUserRole->getRole();
			}
		}
		return $aResult;
	}
	
	public function mayEditUser($oUser = null) {
		if($oUser === null) {
			return Session::getSession()->getUser()->getIsAdmin();
		}
		return $oUser->isSessionUser() || Session::getSession()->getUser()->getIsAdmin();
	}
	
	public function getMissingRights($oPage, $bInheritedOnly = false) {
		$aResult = null;
		foreach($this->getGroups() as $oGroup) {
			if($aResult === null) {
				$aResult = $oGroup->getMissingRights($oPage, $bInheritedOnly);
			} else {
				$aResult = array_diff($aResult, $oGroup->getMissingRights($oPage, $bInheritedOnly));
			}
		}
		return $aResult;
	}
	
	public function getActiveUserGroupIds($bAsString = false) {
		$aResult = array();
		foreach($this->getUserGroupsRelatedByUserId() as $oUserGroup) {
			$aResult[] = $bAsString ? (string) $oUserGroup->getGroupId() : $oUserGroup->getGroupId();
		}
		return $aResult;
	}	
	
	public function getActiveUserRoleKeys() {
		$aResult = array();
		foreach($this->getUserRolesRelatedByUserId() as $oUserRole) {
			$aResult[] = $oUserRole->getRoleKey();
		}
		return $aResult;
	}

	public function hasGroup($mGroup) {
		if($mGroup instanceof Group) {
			$mGroup = $mGroup->getId();
		}
		foreach($this->getGroups() as $oGroup) {
			if($oGroup->getId() === $mGroup) {
				return true;
			}
		}
		return false;
	}
	
	public function setPassword($sPassword, $cPasswordHashMethod = null) {
		if(Settings::getSetting('security', 'generate_digest_secrets', false) === true) {
			$this->setDigestHA1(md5($this->getUsername().':'.Session::getRealm().':'.$sPassword));
		} else {
			$this->setDigestHA1(null);
		}
		if($cPasswordHashMethod === null) {
			$cPasswordHashMethod = array('PasswordHash', 'hashPassword');
		}
		if($cPasswordHashMethod !== false) {
			$sPassword = call_user_func($cPasswordHashMethod, $sPassword);
		}
		return parent::setPassword($sPassword);
	}
}
