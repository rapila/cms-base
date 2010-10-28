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
	
	private function validate($aRoleData, $oRole) {
		$oFlash = Flash::getFlash();
		$oFlash->setArrayToCheck($aRoleData);
		if($oFlash->checkForValue('role_key', 'role_key_required')) {
			if($oRole->getRoleKey() !== $aRoleData['role_key'] && RoleQuery::create()->filterByRoleKey($aRoleData['role_key'])->count() > 0) {
				$oFlash->addMessage('role_key_exists');
			}
		}
		$oFlash->finishReporting();
	}
	
	public function saveData($aRoleData) {
		// ErrorHandler::log($aRoleData);
		$oRole = null;
		if($this->sRoleId === null) {
			$oRole = new Role();
		} else {
			$oRole = RolePeer::retrieveByPK($this->sRoleId);
		}
		$this->validate($aRoleData, $oRole);
		if(!Flash::noErrors()) {
			throw new ValidationException();
		}
		$oRole->setRoleKey($aRoleData['role_key']);
		$oRole->setDescription($aRoleData['description']);
		if(isset($aRoleData['page_id'])) {
			if(!$oRole->isNew()) {
				RightQuery::create()->filterByRole($oRole)->delete();
			}
			$aRights = array();
			foreach($aRoleData['page_id'] as $iCounter => $sPageId) {
				$sRightKey = $sPageId.($aRoleData['is_inherited'][$iCounter] ? "_inherited" : "_uninherited");
				if(isset($aRights[$sRightKey])) {
					$oRight = $aRights[$sRightKey];
					$oRight->setMayEditPageContents($oRight->getMayEditPageContents() || $aRoleData['may_edit_page_contents'][$iCounter]);
					$oRight->setMayEditPageDetails($oRight->getMayEditPageDetails() || $aRoleData['may_edit_page_details'][$iCounter]);
					$oRight->setMayDelete($oRight->getMayDelete() || $aRoleData['may_delete'][$iCounter]);
					$oRight->setMayCreateChildren($oRight->getMayCreateChildren() || $aRoleData['may_create_children'][$iCounter]);
					$oRight->setMayViewPage($oRight->getMayViewPage() || $aRoleData['may_view_page'][$iCounter]);
				} else {
					$oRight = new Right();
					$oRight->setPageId($sPageId);
					$oRight->setRole($oRole);
					$oRight->setIsInherited($aRoleData['is_inherited'][$iCounter]);
					
					$oRight->setMayEditPageContents($aRoleData['may_edit_page_contents'][$iCounter]);
					$oRight->setMayEditPageDetails($aRoleData['may_edit_page_details'][$iCounter]);
					$oRight->setMayDelete($aRoleData['may_delete'][$iCounter]);
					$oRight->setMayCreateChildren($aRoleData['may_create_children'][$iCounter]);
					$oRight->setMayViewPage($aRoleData['may_view_page'][$iCounter]);
					
					$aRights[$sRightKey] = $oRight;
				}
			}
			foreach($aRights as $oRight) {
				$oRight->save();
			}
		}
		return $oRole->save();
	}
}