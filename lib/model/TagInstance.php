<?php

require_once 'model/om/BaseTagInstance.php';


/**
 * @package model
 */	
class TagInstance extends BaseTagInstance {
  public function getCorrespondingDataEntry() { 
    if($this->getModelName() != '') {
      $sModelPeerName = $this->getModelName()."Peer";
      if(!@class_exists($sModelPeerName)) {
        return null;
      }
      return call_user_func(array($sModelPeerName, 'retrieveByPk'), $this->getTaggedItemId());
    }
    return null;
  }
  
  public function getTagName() {
    return $this->getTag()->getName();
  }
  
  //Returns the OBJECT's name. call getTagName() to get the tag name
  public function getName() {
    $oDataEntry = $this->getCorrespondingDataEntry();
    if($oDataEntry === null) {
      return $this->getTaggedItemId();
    }
    return Util::nameForObject($oDataEntry);
  }
  
  public function save($oConnection = null) {
    if($this->isNew()) {
      $this->setCreatedBy(Session::getSession()->getUserId());
    }
    return parent::save($oConnection);
  }
  
  public function delete($oConnection = null) {
    $oTag = $this->getTag();
    if(count($oTag->getTagInstances()) === 1) {
      $oTag->delete();
    }
    $mReturn = parent::delete($oConnection);
    $oTag->reloadInstances();
    return $mReturn;
  }
  
}

