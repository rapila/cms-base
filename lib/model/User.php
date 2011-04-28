<?php

require_once 'model/om/BaseUser.php';


/**
 * @package model
 */ 
class User extends BaseUser {
	
	public static $ALL_ROLES = null;

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

	public function may($mPage, $sRightName) {
		if($this->getIsAdmin()) {
			return true;
		}
		
		foreach($this->allRoles() as $oRole) {
			if($oRole->may($mPage, $sRightName)) {
				return true;
			}
		}
		return false;
	}
	
	public function mayEditPageDetails($mPage) {
		return $this->may($mPage, 'edit_page_details');
	}

	public function mayEditPageContents($mPage) {
		return $this->may($mPage, 'edit_page_contents');
	}

	public function mayEditPageStructure($mPage) {
		return $this->may($mPage, 'edit_page_structure');
	}

	public function mayCreateChildren($mPage) {
		return $this->may($mPage, 'create_children');
	}

	public function mayDelete($mPage) {
		return $this->may($mPage, 'delete');
	}

	public function mayViewPage($mPage) {
		return $this->may($mPage, 'view_page');
	}
	
	public function mayUseAdminModule($sAdminModuleName, $bCheckEnabled = true) {
		return $this->mayUseModuleOfTypeAndName('admin', $sAdminModuleName, $bCheckEnabled);
	}
	
	public function mayUseModuleOfTypeAndName($sModuleType, $sModuleName, $bCheckEnabled = true) {
		//Case 1: Module is disabled (this check is not mandatory): deny
		if($bCheckEnabled && !Module::isModuleEnabled($sModuleType, $sModuleName)) {
			return false;
		}
		//Case 2: User is admin: allow
		if($this->getIsAdmin()) {
			return true;
		}
		$aModuleInfo = Module::getModuleInfoByTypeAndName($sModuleType, $sModuleName);
		//Case 3: Access to module is unrestricted: allow
		if(!isset($aModuleInfo['allowed_roles']) || !is_array($aModuleInfo['allowed_roles'])) {
			return true;
		}
		$aRoleKeys = $aModuleInfo['allowed_roles'];
		//Case 4: Access to module is restricted to admins: deny (because the user is not one of them)
		if(count($aRoleKeys) === 0) {
			return false;
		}
		//Case 5: Access is restricted to certain roles: allow if in role
		$aUserRoles = $this->allRoles();
		foreach($aRoleKeys as $sRoleKey) {
			if(isset($aUserRoles[$sRoleKey])) {
				return true;
			}
		}
		//Case 6: User is not in allowed roles
		return false;
	}
	
	public function getAdminSettings($sSection, $mDefaultResult = array()) {
		if($this->getBackendSettings() !== null) {
			$aSections = unserialize(stream_get_contents($this->getBackendSettings()));
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
			$aSections = unserialize(stream_get_contents($this->getBackendSettings()));
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
	
	public function allRoles() {
		if(self::$ALL_ROLES === null) {
			self::$ALL_ROLES = array();
			foreach($this->getRoles() as $oRole) {
				self::$ALL_ROLES[$oRole->getRoleKey()] = $oRole;
			}
			foreach($this->getGroups() as $oGroup) {
				foreach($oGroup->getRoles() as $oRole) {
					self::$ALL_ROLES[$oRole->getRoleKey()] = $oRole;
				}
			}
		}
		return self::$ALL_ROLES;
	}
	
	public function mayEditUser($oUser = null) {
		if($oUser === null) {
			return Session::getSession()->getUser()->getIsAdmin();
		}
		return $oUser->isSessionUser() || Session::getSession()->getUser()->getIsAdmin();
	}
	
	public function getMissingRights($mPage, $bInheritedOnly = false) {
		$aResult = null;
		foreach($this->allRoles() as $oRole) {
			if($aResult === null) {
				$aResult = $oGroup->getMissingRights($mPage, $bInheritedOnly);
			} else {
				$aResult = array_diff($aResult, $oGroup->getMissingRights($mPage, $bInheritedOnly));
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
		return $this->getRoles(true);
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
	
	public function hasRole($mRole) {
		if($mRole instanceof Role) {
			$mRole = $mRole->getRoleKey();
		}
		$aRoles = $this->allRoles();
		return isset($aRoles[$mRole]);
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
