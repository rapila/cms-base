<?php

require_once 'model/om/BasePageProperty.php';


/**
 * Skeleton subclass for representing a row from the 'page_properties' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
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
} // PageProperty
