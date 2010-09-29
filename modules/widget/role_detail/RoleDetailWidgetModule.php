<?php
/**
 * @package modules.widget
 */
class RoleDetailWidgetModule extends PersistentWidgetModule {

	private $iRoleId = null;
	
	public function setRoleId($iRoleId) {
		$this->iRoleId = $iRoleId;
	}
	
	public function getRoleData() {
		return RolePeer::retrieveByPK($this->iRoleId)->toArray();
	}
	
	public function saveData($aRoleData) {
		if($this->iRoleId === null) {
			$oRole = new Role();
		} else {
			$oRole = RolePeer::retrieveByPK($this->iRoleId);
		}
		$oRole->setRoleKey($aRoleData['role_key']);
		$oRole->setDescription($aRoleData['description']);
		return $oRole->save();
	}
}