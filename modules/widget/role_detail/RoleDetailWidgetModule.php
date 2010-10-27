<?php
/**
 * @package modules.widget
 */
class RoleDetailWidgetModule extends PersistentWidgetModule {

	private $sRoleId = null;
	private $oRole = null;
	
	public function setRoleId($sRoleId) {
		$this->sRoleId = $sRoleId;
	}
	
	public function getRoleData() {
		$oRole = RolePeer::retrieveByPK($this->sRoleId);
		$aResult = $oRole->toArray();
		$aResult['CreatedInfo'] = Util::formatCreatedAtForAdmin($oRole).' / '.Util::getCreatedByIfSet($oRole);
		$aResult['UpdatedInfo'] = Util::formatUpdatedAtForAdmin($oRole).' / '.Util::getUpdatedByIfSet($oRole);
		$aResult['rights'] = array();
		foreach($oRole->getRightsJoinPage() as $oRight) {
			$aResult["rights"][$oRight->getId()] = $oRight->toArray();
		}
		$this->getModulesAndRequiredRights();
		return $aResult;
	}
	
	public function getModulesAndRequiredRights() {
		$aResult = array();
		foreach($aAllEnabledModules = Module::listModulesByType('admin') as $sModuleName => $aAdminModule) {
			if(isset($aAdminModule['module_info']) && isset($aAdminModule['module_info']['allowed_roles'])) {
				$aResult[$sModuleName] = $aAdminModule['module_info']['allowed_roles'];
			}
		}
	}
	
	private function validate($aRoleData) {
		$oFlash = Flash::getFlash();
		$oFlash->setArrayToCheck($aRoleData);
		$oFlash->checkForValue('role_key', 'role_key_required');
		$oFlash->finishReporting();
	}
	

	public function saveData($aRoleData) {
		// ErrorHandler::log($aRoleData);
		if($this->sRoleId === null) {
			$this->oRole = new Role();
		} else {
			$this->oRole = RolePeer::retrieveByPK($this->sRoleId);
		}
		$this->validate($aRoleData);
		if(!Flash::noErrors()) {
			throw new ValidationException();
		}
		$this->oRole->setRoleKey($aRoleData['role_key']);
		$this->oRole->setDescription($aRoleData['description']);
		if(isset($aRoleData['page_id_'])) {
			$oRight = new Right();
			$oRight->setRoleKey($this->oRole->getRoleKey());
			$this->updateRights($oRight, $aRoleData);
		}
		foreach($this->oRole->getRightsJoinPage() as $oRight) {
			if(isset($aRoleData['page_id_'.$oRight->getId()]) && $aRoleData['page_id_'.$oRight->getId()] != null) {
				$this->updateRights($oRight, $aRoleData);			
			} else {
				$oRight->delete();
			}
		}
		return $this->oRole->save();
	}
	
	private function updateRights($oRight, $aRoleData) {
		$mRightId = $oRight->isNew() ? '' : $oRight->getId();
		$oRight->setIsInherited(isset($aRoleData['is_inherited_'.$mRightId]));
		$oRight->setPageId($aRoleData['page_id_'.$mRightId]);
		if($oRight->isNew() 
			&& RightPeer::rightWithUniqueValueExists($oRight->getPageId(), $oRight->getRoleKey(), $oRight->getIsInherited())) {
				return false;
		}
		$oRight->setMayEditPageContents(isset($aRoleData['may_edit_page_contents_'.$mRightId]));
		$oRight->setMayEditPageDetails(isset($aRoleData['may_edit_page_details_'.$mRightId]));
		$oRight->setMayDelete(isset($aRoleData['may_delete_'.$mRightId]));
		$oRight->setMayCreateChildren(isset($aRoleData['may_create_children_'.$mRightId]));
		$oRight->setMayViewPage(isset($aRoleData['may_view_page_'.$mRightId]));
		$this->oRole->addRight($oRight);
	}
}