<?php

require_once 'model/om/BaseGroup.php';


/**
 * @package		 model
 */
class Group extends BaseGroup {
	public function may($oPage, $sRightName) {
		foreach($this->getRoles() as $oRole) {
			if($oRole->may($oPage, $sRightName)) {
				return true;
			}
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
  
	public function getRoles($bReturnNamesOnly = false) {
		$aResult = array();
    $aGroupRoles = $bReturnNamesOnly ? $this->getGroupRoles() : $this->getGroupRolesJoinRole();
		foreach($aGroupRoles as $oGroupRole) {
			if($bReturnNamesOnly) {
				$aResult[] = $oGroupRole->getRoleKey();
			} else {
				$aResult[] = $oGroupRole->getRole();
			}
		}
		return $aResult;
	}
	
	public function getRolesInfo() {
	  $aRoles = self::getRoles(true);
	  if(count($aRoles) > 0) {
	    return implode(', ', $aRoles);
	  }
	  return null;
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

