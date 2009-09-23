<?php

require_once 'model/om/BaseReference.php';


/**
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
  
}

