<?php

require_once 'model/om/BaseString.php';


/**
 * Skeleton subclass for representing a row from the 'strings' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package model
 */	
class String extends BaseString {
  
  private $sIdMethodName = 'getStringKey';

  public function getIdMethodName() {
    return $this->sIdMethodName;
  } 
  
  public function getOriginalText() {
    return parent::getText();
  }
  
  // alias required in BackendModule
  // public function getId() {
  //   return $this->getLanguageId();
  // }
} // String
