<?php
/**
 * @package modules.widget
 */
class GroupDetailWidgetModule extends PersistentWidgetModule {

	private $iGroupId = null;
	
	public function setGroupId($iGroupId) {
		$this->iGroupId = $iGroupId;
	}
	
	public function groupData() {
		$oGroup = GroupQuery::create()->findPk($this->iGroupId);
		$aResult = $oGroup->toArray();
		$aResult['CreatedInfo'] = Util::formatCreatedInfo($oGroup);
		$aResult['UpdatedInfo'] = Util::formatUpdatedInfo($oGroup);
		$aResult['Roles'] = $oGroup->getRoles(true);
		return $aResult;
	}
	
	public function addRole($sRoleKey) {
		if($this->iGroupId === null) {
			return false;
		}
		$oGroupRole = new GroupRole();
		$oGroupRole->setRoleKey($sRoleKey);
		$oGroupRole->setGroupId($this->iGroupId);
		return $oGroupRole->save();
	}
	
	public function saveData($aGroupData) {
		if($this->iGroupId === null) {
			$oGroup = new Group();
		} else {
			$oGroup = GroupQuery::create()->findPk($this->iGroupId);
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