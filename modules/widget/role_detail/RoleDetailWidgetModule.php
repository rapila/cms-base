<?php
/**
 * @package modules.widget
 */
class RoleDetailWidgetModule extends PersistentWidgetModule {
	private $sRoleId = null;
	
	public function setRoleId($sRoleId) {
		$this->sRoleId = $sRoleId;
	}
	
	public function roleData() {
		$oRole = RoleQuery::create()->findPk($this->sRoleId);
		$aResult = $oRole->toArray();
		$aResult['CreatedInfo'] = Util::formatCreatedInfo($oRole);
		$aResult['UpdatedInfo'] = Util::formatUpdatedInfo($oRole);
		$aResult['rights'] = array();
		$aResult['RoleIsUsed'] = self::roleIsUsed($oRole);
		foreach($oRole->getRightsJoinPage() as $oRight) {
			$aResult["rights"][$oRight->getId()] = $oRight->toArray();
		}
		$this->getModulesAndRequiredRights();
		return $aResult;
	}
	
	private static function roleIsUsed($oRole) {
		if($oRole->isNew()) {
			return false;
		}
		$iCountRolesUsed = UserRoleQuery::create()->filterByRole($oRole)->joinUserRelatedByUserId()->count();
		$iCountRolesInGroupsUsed = UserGroupQuery::create()->filterByRole($oRole)->joinUserRelatedByUserId()->count();
		return ($iCountRolesUsed + $iCountRolesInGroupsUsed) > 0;
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
			if($oCheckRole = RoleQuery::create()->filterByRoleKey($aRoleData['role_key'])->findOne()) {
				if(!Util::equals($oCheckRole, $oRole)) {
					$oFlash->addMessage('role_key_exists');
				}
			}
		}
		$oFlash->finishReporting();
	}
	
	public function saveData($aRoleData) {
		$oRole = null;
		if($this->sRoleId === null) {
			$oRole = new Role();
		} else {
			$oRole = RoleQuery::create()->findPk($this->sRoleId);
			// If the role_key has changed and the new key does not exist yet, delete the current role and create a new one
			if($oRole->getRoleKey() !== $aRoleData['role_key']) {
				if(RoleQuery::create()->filterByRoleKey($aRoleData['role_key'])->count() === 0) {
					$oRole->delete();
					$oRole = new Role();
				}
			}
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
		$oRole->save();
		return array('id' => $oRole->getRoleKey());
	}
}