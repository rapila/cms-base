<?php
/**
 * @package modules.widget
 */
class UserDetailWidgetModule extends PersistentWidgetModule {
	private $iUserId = null;

	public function setUserId($iUserId) {
		$this->iUserId = $iUserId;
	}

	public function userData() {
		$oUser = UserQuery::create()->findPk($this->iUserId);
		if(Session::getSession()->getUser()->mayEditUser($oUser)) {
			$aResult = $oUser->toArray();
			$aResult['FullName'] = $oUser->getFullName();

			$aResult['IsSessionUser'] = $oUser->isSessionUser();
			if($aResult['IsSessionUser'] === false) {
				$aResult['ActiveUserGroupIds'] = $oUser->getActiveUserGroupIds(true);
				$aResult['ActiveUserRoleKeys'] = $oUser->getActiveUserRoleKeys();
			}
			$aResult['CreatedInfo'] = Util::formatCreatedInfo($oUser);
			$aResult['UpdatedInfo'] = Util::formatUpdatedInfo($oUser);
			$aResult['IsSessionUser'] = $oUser->isSessionUser();
			return $aResult;
		}
	}

	public function resetSettings() {
		$oUser = UserQuery::create()->findPk($this->iUserId);
		if($oUser) {
			$oUser->resetBackendSettings();
			$oUser->save();
			return $this->iUserId;
		}
		return false;
	}

	private function validate($aUserData, $oUser) {
		$oFlash = Flash::getFlash();
		$oFlash->setArrayToCheck($aUserData);
		$oFlash->checkForValue('username', 'username_required');
		$oFlash->checkForValue('first_name', 'first_name_required');
		$oFlash->checkForValue('last_name', 'last_name_required');
		$oFlash->checkForEmail('email', 'valid_email');
		if($oUser->isNew() || $aUserData['username'] !== $oUser->getUsername()) {
			$oCheckedUser = UserPeer::getUserByUsername($aUserData['username']);
			if($oCheckedUser !== null && $oCheckedUser->getId() !== $oUser->getId()) {
				$oFlash->addMessage('username_exists');
			}
		}
		if(($aUserData['password']) !== '') {
			if($oUser->isSessionUser() && $oUser->getPassword() != null) {
				if($aUserData['old_password'] == '') {
					$oFlash->addMessage('old_password_required');
				} else {
					if(!PasswordHash::comparePassword($aUserData['old_password'], $oUser->getPassword())) {
						$oFlash->addMessage('old_password_invalid');
					}
				}
		}
			if($aUserData['password'] !== $aUserData['password_confirm']) {
				$oFlash->addMessage('password_confirm');
			}
			PasswordHash::checkPasswordValidity($aUserData['password'], $oFlash);
		} else if($oUser->isNew()) {
			$oFlash->addMessage('password_new');
		}
		$oFlash->finishReporting();
	}

	public function saveData($aUserData) {
		if($this->iUserId === null) {
			$oUser = new User();
		} else {
			$oUser = UserQuery::create()->findPk($this->iUserId);
		}

		$this->validate($aUserData, $oUser);
		if(!Flash::noErrors()) {
			throw new ValidationException();
		}

		$oUser->setUsername($aUserData['username']);
		$oUser->setFirstName($aUserData['first_name']);
		$oUser->setLastName($aUserData['last_name']);
		$oUser->setEmail($aUserData['email']);
		$oUser->setLanguageId($aUserData['language_id']); 

		//Password
		if($aUserData['password'] !== '') {
			$oUser->setPassword($aUserData['password']);
			$oUser->setPasswordRecoverHint(null);
		}

		//This also means the user’s an admin (or has the role “users”) because non-admins can only edit themselves
		if(!$oUser->isSessionUser()) {
			//Only admins may give or take admin rights, having the role “users” does not suffice
			if(Session::user()->getIsAdmin()) {
					$oUser->setIsAdmin($aUserData['is_admin']);
			}
			//Admin & inactive flags
			$oUser->setIsBackendLoginEnabled($oUser->getIsAdmin() || $aUserData['is_admin_login_enabled'] || $aUserData['is_backend_login_enabled']);
			$oUser->setIsAdminLoginEnabled($oUser->getIsAdmin() || $aUserData['is_admin_login_enabled']);
			$oUser->setIsInactive($aUserData['is_inactive']);

			//Groups
			foreach($oUser->getUserGroupsRelatedByUserId() as $oUserGroup) {
				$oUserGroup->delete();
			}
			$aRequestedGroups = isset($aUserData['group_ids']) ? $aUserData['group_ids'] : array();
			foreach($aRequestedGroups as $iGroupId) {
				if($iGroupId === false) {
					continue;
				}
				$oUserGroup = new UserGroup();
				$oUserGroup->setGroupId($iGroupId);
				$oUser->addUserGroupRelatedByUserId($oUserGroup);
			}
			//Roles
			foreach($oUser->getUserRolesRelatedByUserId() as $oUserRole) {
				$oUserRole->delete();
			}
			$aRequestedRoles = isset($aUserData['role_keys']) ? !is_array($aUserData['role_keys']) ? array($aUserData['role_keys']) : $aUserData['role_keys'] : array();
			foreach($aRequestedRoles as $sRoleKey) {
				if($sRoleKey === false) {
					continue;
				}
				$oUserRole = new UserRole();
				$oUserRole->setRoleKey($sRoleKey);
				$oUser->addUserRoleRelatedByUserId($oUserRole);
			}
		} else {
			//Set the new session language for the currently logged-in user
			Session::getSession()->setLanguage($oUser->getLanguageId());
		}

		return $oUser->save();
	}

	public function suggestPassword() {
		return PasswordHash::generatePassword();
	}
}
