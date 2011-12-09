<?php


/**
 * @package		 propel.generator.model
 */
class Role extends BaseRole {

	public function may($mPage, $sRightName, $bInheritedOnly = false) {
		$sRightName = "getMay".StringUtil::camelize($sRightName, true);
		$aRights = $this->getRights();
		foreach($aRights as $oRight) {
			if($bInheritedOnly && !$oRight->getIsInherited()) {
				continue;
			}
			if($oRight->rightFits($mPage, $sRightName)) {
				return true;
			}
		}
		return false;
	}

	public function mayEditPageDetails($mPage) {
		return $this->may($mPage, 'edit_page_details');
	}

	public function mayEditPageContents($mPage) {
		return $this->may($mPage, 'edit_page_contents');
	}

	public function mayEditPageStructure($mPage) {
		return $this->may($mPage, 'edit_page_structure');
	}
	
	public function mayCreateChildren($mPage) {
		return $this->may($mPage, 'create_children');
	}

	public function mayDelete($mPage) {
		return $this->may($mPage, 'delete');
	}

	public function mayViewPage($mPage) {
		return $this->may($mPage, 'view_page');
	}

	public function getMissingRights($mPage, $bInheritedOnly = false) {
		$oRightMethods = get_class_methods("Right");
		$aResult = array();
		foreach($oRightMethods as $iKey => $sRightMethodName) {
			if(!StringUtil::startsWith($sRightMethodName, 'getMay')) {
				continue;
			}
			$sRightName = substr($sRightMethodName, strlen('getMay'));
			if(!$this->may($mPage, $sRightName, $bInheritedOnly)) {
				$aResult[] = $sRightName;
			}
		}
		return $aResult;
	}
	
	public function getUserWithRoleCount() {
		return $this->countUserRoles();
	}
	
	public function getGroupWithRoleCount() {
		return $this->countGroupRoles();
	}
	
} // Role
