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
  
  public function getFrom() {
    $sClassName = "{$this->getFromModelName()}Peer";
    return call_user_func(array($sClassName, 'retrieveByPk'), $this->getFromId());
  }
  
  public function getTo() {
    $sClassName = "{$this->getToModelName()}Peer";
    return call_user_func(array($sClassName, 'retrieveByPk'), $this->getToId());
  }
  
} // Reference
