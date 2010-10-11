<?php
/**
 * @package modules.widget
 */
class RoleDetailWidgetModule extends PersistentWidgetModule {

	private $sRoleId = null;
	
	public function setRoleId($sRoleId) {
		$this->sRoleId = $sRoleId;
	}
	
	public function getRoleData() {
		return RolePeer::retrieveByPK($this->sRoleId)->toArray();
	}
	
	private function validate($aRoleData) {
		$oFlash = Flash::getFlash();
		$oFlash->setArrayToCheck($aRoleData);
		$oFlash->checkForValue('role_key', 'role_key_required');
		$oFlash->finishReporting();
	}

	
	public function saveData($aRoleData) {
		if($this->sRoleId === null) {
			$oRole = new Role();
		} else {
			$oRole = RolePeer::retrieveByPK($this->sRoleId);
		}
		$this->validate($aRoleData);
		if(!Flash::noErrors()) {
			throw new ValidationException();
		}
		$oRole->setRoleKey($aRoleData['role_key']);
		$oRole->setDescription($aRoleData['description']);
		return $oRole->save();
	}
}