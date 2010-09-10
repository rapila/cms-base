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
	
	public function getLanguagesAvailable() {
	  $aLanguages[] = $this->getLanguageId();
	  $aAvailableLanguages = StringPeer::getStringsByStringKey($this->getStringKey());
    foreach(StringPeer::getStringsByStringKey($this->getStringKey(),$this->getLanguageId()) as $oString) {
      $aLanguages[] = $oString->getLanguageId();
    }
	  return implode(', ', $aLanguages);
	}
}
