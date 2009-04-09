<?php

require_once 'model/om/BaseString.php';

/**
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
} // String
