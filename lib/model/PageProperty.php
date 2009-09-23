<?php

require_once 'model/om/BasePageProperty.php';


/**
 * @package model
 */ 
class PageProperty extends BasePageProperty {
  public $bIsTemp = false;
  
  public function save($con = null) {
    if($this->bIsTemp) {
      return 0;
    }
    return parent::save($con);
  }
  
}

