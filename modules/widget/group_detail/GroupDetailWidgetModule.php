<?php
/**
 * @package modules.widget
 */
class GroupDetailWidgetModule extends PersistentWidgetModule {

	private $iGroupId = null;
	
	public function setGroupId($iGroupId) {
		$this->iGroupId = $iGroupId;
	}
	
	public function getGroupData() {
		$oGroup = GroupPeer::retrieveByPK($this->iGroupId);
		$aResult = $oGroup->toArray();
		$aResult['CreatedInfo'] = Util::formatCreatedInfo($oGroup);
		$aResult['UpdatedInfo'] = Util::formatUpdatedInfo($oGroup);
		$aResult['Roles'] = $oGroup->getRoles(true);
		return $aResult;
	}
	
	public function saveData($aGroupData) {
		if($this->iGroupId === null) {
			$oGroup = new Group();
		} else {
			$oGroup = GroupPeer::retrieveByPK($this->iGroupId);
		}
		$oGroup->setName($aGroupData['name']);

		foreach($oGroup->getGroupRoles() as $oGroupRole) {
			$oGroupRole->delete();
		}
		foreach($aGroupData['roles'] as $sRoleKey) {
			$oGroupRole = new GroupRole();
			$oGroupRole->setRoleKey($sRoleKey);
			$oGroup->addGroupRole($oGroupRole);
		}

		return $oGroup->save();
	}
}