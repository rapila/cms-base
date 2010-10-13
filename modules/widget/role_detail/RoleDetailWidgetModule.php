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
		$oRole = RolePeer::retrieveByPK($this->sRoleId);
		$aResult = $oRole->toArray();
		$aResult['CreatedInfo'] = Util::formatCreatedAtForAdmin($oRole).' / '.Util::getCreatedByIfSet($oRole);
		$aResult['UpdatedInfo'] = Util::formatUpdatedAtForAdmin($oRole).' / '.Util::getUpdatedByIfSet($oRole);
		foreach($oRole->getRightsJoinPage() as $oRight) {
			$aResult["rights"][$oRight->getId()] = $oRight->toArray();
		}
		return $aResult;
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