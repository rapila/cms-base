<?php

require_once 'model/om/BaseUser.php';


/**
 * @package model
 */
class User extends BaseUser {

	public static $ALL_ROLES = null;

	private static $CACHED_ADMIN_SETTINGS = null;
	private static $ADMIN_SETTINGS_SET = array();

	const IS_BACKEND_LOGIN_ENABLED = 'user-backend';
	const IS_ADMIN_LOGIN_ENABLED = 'user-admin_area';
	const IS_FRONTEND_USER = 'user-frontend';
	const IS_ADMIN_USER = 'user-admin';

	public function getFullName() {
		return implode(' ', $this->getFullNameArray());
	}

	public function getFullNameInverted($sSeparator=', ') {
		return implode(', ', array_reverse($this->getFullNameArray()));
	}

	public function getFullNameArray() {
		$aResult = array();
		if($this->getFirstName()) {
			$aResult[] = $this->getFirstName();
		}
		if($this->getLastName()) {
			$aResult[] = $this->getLastName();
		}
		// Use user name if no other names set
		if(count($aResult) === 0) {
			$aResult[] = $this->getUsername();
		}
		return $aResult;
	}

	public function getInitials() {
		return implode('', array_map(function($sNamePart) {
			return strtolower(substr($sNamePart,0,1));
		}, $this->getFullNameArray()));
	}

	public function getUserKind() {
		if($this->getIsAdmin()) {
			return self::IS_ADMIN_USER;
		}
		if(!$this->getIsBackendLoginEnabled()) {
			return self::IS_FRONTEND_USER;
		}
		if($this->getIsAdminLoginEnabled()) {
			return self::IS_ADMIN_LOGIN_ENABLED;
		}
		return self::IS_BACKEND_LOGIN_ENABLED;
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
		//Case 6: Access is restricted to certain rights: allow if roles with page_rights grant limited access
		if($sModuleName === 'pages') {
			foreach($aUserRoles as $oRole) {
				if($oRole->countRights() > 0) {
					return true;
				}
			}
		}
		//Case 7: User is not in allowed roles
		return false;
	}

	public function getAdminSettings($sSection, $mDefaultResult = array()) {
		if(self::$CACHED_ADMIN_SETTINGS === null) {
			self::$CACHED_ADMIN_SETTINGS = $this->allAdminSettings();
		}
		if(!isset(self::$CACHED_ADMIN_SETTINGS[$sSection])) {
			self::$CACHED_ADMIN_SETTINGS[$sSection] = Settings::getSetting(null, $sSection, $mDefaultResult, 'user_defaults');
		}
		return self::$CACHED_ADMIN_SETTINGS[$sSection];
	}

	public function setAdminSettings($sSection, $mValue) {
		if(self::$CACHED_ADMIN_SETTINGS === null) {
			self::$CACHED_ADMIN_SETTINGS = $this->allAdminSettings();
		}
		self::$CACHED_ADMIN_SETTINGS[$sSection] = $mValue;
		self::$ADMIN_SETTINGS_SET[$sSection] = true;
		$aToSave = array();
		foreach(self::$ADMIN_SETTINGS_SET as $sSetSection => $bTrue) {
			$aToSave[$sSetSection] = self::$CACHED_ADMIN_SETTINGS[$sSetSection];
		}
		parent::setBackendSettings(serialize($aToSave));
	}

	public function resetBackendSettings() {
		return parent::setBackendSettings(null);
	}

	public function getBackendSettings() {
		// Never call getBackendSettings directly!
		return null;
	}

	public function setBackendSettings($mSettings) {
		throw new Exception('Never call setBackendSettings directly!');
	}

	private function allAdminSettings() {
		$mSettings = parent::getBackendSettings();
		if($mSettings === null) {
			return array();
		}
		if(is_resource($mSettings)) {
			$mSettings = stream_get_contents($mSettings);
		}
		return unserialize($mSettings);
	}

	public function getTimezone($bAsObject = false) {
		$sTimezone = parent::getTimezone();
		if($sTimezone === null) {
			$sTimezone = Settings::getSetting('general', 'timezone', 'Europe/Zurich');
		}
		if($bAsObject) {
			return new DateTimeZone($sTimezone);
		}
		return $sTimezone;
	}

	public function dateInUserTimezone(DateTime $oDate) {
		$oResult = clone $oDate;
		$oDate->setTimezone($this->getTimezone(true));
		return $oDate;
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

	public function addRole($sRoleName) {
		$aRoles = func_get_args();
		foreach($aRoles as $mRole) {
			if(!($mRole instanceof Role)) {
				$mRole = RoleQuery::create()->createOrFindPk($mRole);
			}
			UserRoleQuery::create()->createOrFind($this, $mRole);
		}
	}

	public function addGroup($mGroup) {
		if(!($mGroup instanceof Group)) {
			$mGroup = GroupQuery::create()->createOrFindByName($mGroup);
		}
		if(!$this->hasGroup($mGroup)) {
			$oUserGroup = new UserGroup();
			$oUserGroup->setUserRelatedByUserId($this);
			$oUserGroup->setGroup($mGroup);
		}
		return $mGroup;
	}

	public function mayEditUser($oUser = null) {
		return UserPeer::mayOperateOn($this, $oUser, 'update');
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
		foreach($this->getUserGroupsRelatedByUserId() as $oUserGroup) {
			if($oUserGroup->getGroupId() === $mGroup) {
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

	public function forcePasswordReset() {
		$this->setDigestHA1(null);
		return parent::setPassword('*');
	}

	public function getLanguageName() {
		return TranslationPeer::getString('language.'.$this->getLanguageId(), null, $this->getLanguageId());
	}
}
