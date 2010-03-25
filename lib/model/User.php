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

	public function may($oPage, $sRightName) {
		if($this->getIsAdmin()) {
			return true;
		}
		foreach($this->getGroups() as $oGroup) {
			if($oGroup->may($oPage, $sRightName)) {
				return true;
			}
		}
		return false;
	}
	
	public function isFirstAdministrator() {
		return (UserPeer::doCount(new Criteria()) === 1) 
						&& $this->getIsAdmin() 
						&& !$this->getIsInactive()
						&& $this->getIsBackendLoginEnabled();
	}
	
	public function requiresUserName() {
		return trim($this->getFullName()) !== null;
	}
	
	public function isSessionUser() {
		return $this->getId() === Session::getSession()->getUserId();
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
	
	public function mayUseBackendModule($sBackendModuleName, $bCheckEnabled = true) {
		//Case 1: Module is disabled (this check is not mandatory): deny
		if($bCheckEnabled && !Module::isModuleEnabled('backend', $sBackendModuleName)) {
			return false;
		}
		//Case 2: User is allowed: allow
		if($this->getIsAdmin()) {
			return true;
		}
		$aModuleInfo = Module::getModuleInfoByTypeAndName('backend', $sBackendModuleName);
		$aGroupIds = isset($aModuleInfo['allowed_groups']) ? $aModuleInfo['allowed_groups'] : array();
		//Cases 3 and 4: No groups defined
		if(count($aGroupIds) === 0) {
			//Case 3: Access to module is unrestricted: allow
			//Case 4: Access to module is restricted to admins: deny (because the user is not one of them)
			return !(@$aModuleInfo['admin_required']);
		}
		//Case 5: Access is restricted to certain groups: allow if in group
		foreach($this->getUserGroups() as $oUserGroup) {
			if(in_array($oUserGroup->getGroupId(), $aGroupIds)) {
				return true;
			}
		}
		//Case 6: User is not in allowed groups
		return false;
	}
	
	public function getBackendSettingsValue() {
		if($this->getBackendSettings() !== null) {
			return unserialize($this->getBackendSettings());
		}
		$aResult = array();
		foreach(SettingsBackendModule::$AVAILABLE_SECTIONS as $sSectionName) {
			$aResult[$sSectionName] = Settings::getSetting('modules', $sSectionName, array(), 'backend');
		}
		//FIXME: Move to where the function is called (should not be here).
		if(isset($aResult['direct_links'])) {
			foreach(SettingsBackendModule::$FIXED_MODULE_NAMES as $sExcludedModule) {
				if(isset($aResult['direct_links'][$sExcludedModule])) {
					unset($aResult['direct_links'][$sExcludedModule]);
				}
			}			 
		}
		return $aResult;
	}
	
	public function getGroups() {
		$aResult = array();
		foreach($this->getUserGroupsJoinGroup() as $oGroupUser) {
			$aResult[] = $oGroupUser->getGroup();
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
	
	public function getActiveUserGroupIds() {
		$aResult = array();
		foreach($this->getUserGroups() as $oUserGroup) {
			$aResult[] = $oUserGroup->getGroupId();
		}
		return $aResult;
	}
	
	public function hasGroup($iGroupId) {
		foreach($this->getGroups() as $oGroup) {
			if($oGroup->getId() === $iGroupId) {
				return true;
			}
		}
		return false;
	}

	public function save($oConnection=null) {
    $this->setUpdatedAt(date('c'));
    if($this->isNew()) {
      if(Session::getSession()->isAuthenticated()) {
        $this->setCreatedBy(Session::getSession()->getUserId());
      }
      $this->setCreatedAt(date('c'));
    }
		parent::save($oConnection);
	}
	
}

