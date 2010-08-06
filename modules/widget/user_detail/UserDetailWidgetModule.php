<?php
/**
 * @package modules.widget
 */
class UserDetailWidgetModule extends PersistentWidgetModule {
	private $iUserId = null;
	
	public function setUserId($iUserId) {
		$this->iUserId = $iUserId;
	}
	
	public function getUserData() {
		$oUser = UserPeer::retrieveByPK($this->iUserId);
		$aResult = $oUser->toArray();
		$aResult['FullName'] = $oUser->getFullName();
		$aResult['ActiveUserGroupIds'] = $oUser->getActiveUserGroupIds(true);
		$aResult['CreatedInfo'] = $oUser->getCreatedAt(DetailWidgetModule::DATE_FORMAT).' / '.($oUser->getUserRelatedByCreatedBy() == null ? "" : $oUser->getUserRelatedByCreatedBy()->getUserName());
		$aResult['UpdatedInfo'] = $oUser->getUpdatedAt(DetailWidgetModule::DATE_FORMAT).' / '.($oUser->getUserRelatedByUpdatedBy() == null ? "" : $oUser->getUserRelatedByUpdatedBy()->getUserName());
		return $aResult;
	}

	private function validate($aUserData, $oUser) {
		$oFlash = Flash::getFlash();
		$oFlash->setArrayToCheck($aUserData);
		$oFlash->checkForValue('username');
		$oFlash->checkForValue('first_name');
		$oFlash->checkForValue('last_name');
		$oFlash->checkForEmail('email');
		if($oUser->isNew() || $aUserData['username'] !== $oUser->getUserName()) {
			if(UserPeer::getUserByUserName($aUserData['username']) !== null) {
				$oFlash->addMessage('user_name_exists');
			}
		}
		if(($aUserData['password']) !== '') { 
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
			$oUser = UserPeer::retrieveByPK($this->iUserId);
		}
		
		$this->validate($aUserData, $oUser);
		if(!Flash::noErrors()) {
			throw new ValidationException();
		}
		
		if(!Session::getSession()->getUser()->mayEditUser($oUser)) {
			throw new NotPermittedException('may_edit_user');
		}		 
		
		$oUser->setUserName($aUserData['username']);
		$oUser->setFirstName($aUserData['first_name']);
		$oUser->setLastName($aUserData['last_name']);
		$oUser->setEmail($aUserData['email']);
		$oUser->setLanguageId($aUserData['language_id']); 
		if(!$oUser->isSessionUser()) { 
			$oUser->setIsBackendLoginEnabled(isset($aUserData['is_admin']) || isset($aUserData['is_backend_login_enabled'])); 
		}
		
		//Password
		if($aUserData['password'] !== '') {
			$oUser->setPassword($aUserData['password']);
			$oUser->setPasswordRecoverHint(null);
		}
		
		//This also means the user’s an admin because non-admins can only edit themselves
		if(!$oUser->isSessionUser()) {
			//Admin & inactive flags
			$oUser->setIsInactive(isset($aUserData['is_inactive']));
			$oUser->setIsAdmin(isset($aUserData['is_admin']));
			
			//Groups
			foreach($oUser->getUserGroupsRelatedByUserId() as $oUserGroup) {
				$oUserGroup->delete();
			}
			$aRequestedGroups = isset($aUserData['group_ids']) ? $aUserData['group_ids'] : array();
			foreach($aRequestedGroups as $iGroupId) {
				$oUserGroup = new UserGroup();
				$oUserGroup->setGroupId($iGroupId);
				$oUser->addUserGroupRelatedByUserId($oUserGroup);
			}
		}
		
		return $oUser->save();
	}
}