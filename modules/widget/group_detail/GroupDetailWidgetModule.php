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
		return GroupPeer::retrieveByPK($this->iGroupId)->toArray();
	}
	
	public function saveData($aGroupData) {
		if($this->iGroupId === null) {
			$oGroup = new Group();
		} else {
			$oGroup = GroupPeer::retrieveByPK($this->iGroupId);
		}
		$oGroup->setName($aGroupData['name']);
		return $oGroup->save();
	}
}