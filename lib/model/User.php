<?php

require_once 'model/om/BaseUser.php';


/**
 * Skeleton subclass for representing a row from the 'users' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package model
 */	
class User extends BaseUser {

  public function getFullName() {
    return $this->getFirstName(). ' '.$this->getLastName();
  }
  
  public function getInitials() {
    return strtolower(substr($this->getFirstName(),0,1).substr($this->getLastName(),0,1));
  }

  public function may($oPage, $sRightName) {
    if($this->getIsAdmin()) {
      return true;
    }
    foreach($this->getGroups() as $oGroup) {
      if($oGroup->may($oPage, $sRightName)) {
        return true;
      }
    }
    return false;
  }
  
  public function isSessionUser() {
    return $this->getId() === Session::getSession()->getUserId();
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
  
  public function getGroups() {
    $aResult = array();
    foreach($this->getUserGroupsJoinGroup() as $oGroupUser) {
      $aResult[] = $oGroupUser->getGroup();
    }
    return $aResult;
  }
  
  public function mayEditUser($oUser = null) {
    if($oUser === null) {
      return Session::getSession()->getUser()->getIsAdmin();
    }
    return $oUser->isSessionUser() || Session::getSession()->getUser()->getIsAdmin();
  }
  
  public function getMissingRights($oPage, $bInheritedOnly = false) {
    $aResult = null;
    foreach($this->getGroups() as $oGroup) {
      if($aResult === null) {
        $aResult = $oGroup->getMissingRights($oPage, $bInheritedOnly);
      } else {
        $aResult = array_diff($aResult, $oGroup->getMissingRights($oPage, $bInheritedOnly));
      }
    }
    return $aResult;
  }
  
  public function getActiveUserGroupIds() {
    $aResult = array();
    foreach($this->getUserGroups() as $oUserGroup) {
      $aResult[] = $oUserGroup->getGroupId();
    }
    return $aResult;
  }
} // User
