<?php

/**
 * @package    propel.generator.model
 */
class Role extends BaseRole {

	public function may($oPage, $sRightName, $bInheritedOnly = false) {
		$sRightName = "getMay".StringUtil::camelize($sRightName, true);
		$aRights = $this->getRights();
		foreach($aRights as $oRight) {
			if($bInheritedOnly && !$oRight->getIsInherited()) {
				continue;
			}
			if($this->rightFits($oRight, $oPage, $sRightName)) {
				return true;
			}
		}
		return false;
	}
	/**
	* @todo bug #0000108
	* here the PagesBackendModule quickFix would throw the error
	*/
	private function rightFits($oRight, $oPage, $sMethodName) {
		if($oRight->getPage() !== null && $oPage->getId() === $oRight->getPage()->getId()) {
			return call_user_func(array($oRight, $sMethodName));
		}
		if($oRight->getIsInherited() && $oPage->getParent() !== null) {
			return $this->rightFits($oRight, $oPage->getParent(), $sMethodName);
		}
		return false;
	}

	public function mayEditPageDetails($oPage) {
		return $this->may($oPage, 'edit_page_details');
	}

	public function mayEditPageContents($oPage) {
		return $this->may($oPage, 'edit_page_contents');
	}

	public function mayCreateChildren($oPage) {
		return $this->may($oPage, 'create_children');
	}

	public function mayDelete($oPage) {
		return $this->may($oPage, 'delete');
	}

	public function mayViewPage($oPage) {
		return $this->may($oPage, 'view_page');
	}

	public function getMissingRights($oPage, $bInheritedOnly = false) {
		$oRightMethods = get_class_methods("Right");
		$aResult = array();
		foreach($oRightMethods as $iKey => $sRightMethodName) {
			if(!StringUtil::startsWith($sRightMethodName, 'getMay')) {
				continue;
			}
			$sRightName = substr($sRightMethodName, strlen('getMay'));
			if(!$this->may($oPage, $sRightName, $bInheritedOnly)) {
				$aResult[] = $sRightName;
			}
		}
		return $aResult;
	}
	
	public function getUserWithRoleCount() {
		return $this->countUserRoles();
	}
	
} // Role
