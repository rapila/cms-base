<?php

require_once 'model/om/BaseTag.php';

/**
 * @package model
 */	
class Tag extends BaseTag {
  public function getAllCorrespondingDataEntries($sType=null) {
    $aResults = array();
    foreach($this->getTagInstances() as $oTagInstance) {
      $oDataEntry = $oTagInstance->getCorrespondingDataEntry();
      if($oDataEntry === null || ($sType !== null && $sType !== get_class($oDataEntry))) {
        continue;
      }
      $aResults[] = $oDataEntry;
    }
    return $aResults;
  }
  
  public function setName($sNewName) {
    $sNewName = Util::normalize($sNewName);
    parent::setName($sNewName);
  }
  
  public function reloadInstances() {
    $this->collTagInstances=null;
  }
} // Tag
