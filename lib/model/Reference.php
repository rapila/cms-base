<?php

require_once 'model/om/BaseReference.php';


/**
 * Skeleton subclass for representing a row from the 'references' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    model
 */
class Reference extends BaseReference {
  public function getFromIdObjectId() {
    $aFromIdExploded = $this->getFromIdExploded();
    return (int) $aFromIdExploded[0];
  }
  public function getFromIdLanguageId() {
    $aFromIdExploded = $this->getFromIdExploded();
    return $aFromIdExploded[1];
  }
  
  private function getFromIdExploded() {
    return explode('_', $this->getFromId());
  }
} // Reference
