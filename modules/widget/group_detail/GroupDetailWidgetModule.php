<?php
/**
 * @package modules.widget
 */
class GroupDetailWidgetModule extends PersistentWidgetModule {

	private $iGroupId = null;
	private static $ROLES = array();
	
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
			self::$ROLES[] = $sRoleKey;
			return;
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
		if($oGroup->isNew() && count(self::$ROLES) > 0) {
			foreach(self::$ROLES as $sRoleKey) {
				$oGroupRole = new GroupRole();
				$oGroupRole->setRoleKey($sRoleKey);
				$oGroup->addGroupRole($oGroupRole);
			}
		} else {
			foreach($oGroup->getGroupRoles() as $oGroupRole) {
				$oGroupRole->delete();
			}
			foreach($aGroupData['roles'] as $sRoleKey) {
				$oGroupRole = new GroupRole();
				$oGroupRole->setRoleKey($sRoleKey);
				$oGroup->addGroupRole($oGroupRole);
			}
		}

		return $oGroup->save();
	}
}