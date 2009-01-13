<?php

require_once 'model/om/BasePageString.php';


/**
 * Skeleton subclass for representing a row from the 'page_strings' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package model
 */	
class PageString extends BasePageString {
  public function getPageTitle() {
    return $this->getLongTitle();
  }
  
  public function getLinkText() {
    return $this->getTitle() === null ? $this->getPageTitle() : $this->getTitle();
  }
  
  public function getLinkTextOnly() {
    return $this->getTitle();
  }
} // PageString
