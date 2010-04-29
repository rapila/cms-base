<?php

require_once 'model/om/BaseGroup.php';


/**
 * @package		 model
 */
class Group extends BaseGroup {

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
		if($oRight->getPage() !== null && $oPage->getId() === $oRight->getPage()->getid()) {
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
	
	public function addUser($oUser) {
		if($this->containsUser($oUser)) {
			return;
		}
		$oUserGroup = new UserGroup();
		$oUserGroup->setUser($oUser);
		$this->addUserGroup($oUserGroup);
	}
	
	public function getUsers() {
		$aResult = array();
		foreach($this->getUserGroupsJoinUser() as $oGroupUser) {
			$aResult[] = $oGroupUser->getUser();
		}
		return $aResult;
	}
	
	public function getUserCount() {
		return $this->countUserGroups();
	}
	
	public function containsUser($oUser) {
		if($oUser instanceof User) {
			$oUser = $oUser->getId();
		}
		$oCriteria = new Criteria();
		$oCriteria->add(UserGroupPeer::USER_ID, $oUser);
		return $this->countUserGroups($oCriteria) > 0;
	}

	public function getUserLinkData() {
		$aArray = array();
		$aArray[] = $this->getUserCount().' '.StringPeer::getString('user');
		$aArray[] = LinkUtil::link(array('users'), 'AdminManager', array('group_id' => $this->getId()));
		return $aArray;
	}


}

