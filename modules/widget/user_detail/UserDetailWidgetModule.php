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
	
	public function saveData($aUserData) {
		if($this->iUserId === null) {
			$oUser = new User();
		} else {
			$oUser = UserPeer::retrieveByPK($this->iUserId);
		}
		foreach($oUser->getUserGroupsRelatedByUserId() as $oUserGroup) {
			$oUserGroup->delete();
		}
		if(isset($aUserData['group_ids'])) {
			foreach($aUserData['group_ids'] as $iGroupId) {
				$oUserGroup = new UserGroup();
				$oUserGroup->setGroupId($iGroupId);
				$oUser->addUserGroupRelatedByUserId($oUserGroup);
			}
		}
		$oUser->setUsername($aUserData['username']);
		$oUser->setFirstName($aUserData['first_name']);
		$oUser->setLastName($aUserData['last_name']);
		$oUser->setEmail($aUserData['email']);
		$oUser->setLanguageId(@$aUserData['language_id']);
		$oUser->setIsAdmin(isset($aUserData['is_admin']));
		$oUser->setIsBackendLoginEnabled(isset($aUserData['is_backend_login_enabled']));
		$oUser->setIsInactive(isset($aUserData['is_inactive']));
		return $oUser->save();
	}
}