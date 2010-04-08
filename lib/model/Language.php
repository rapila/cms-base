<?php

require_once 'model/om/BaseLanguage.php';


/**
 * @package model
 */	
class Language extends BaseLanguage {
  public function getLanguageName($sLanguageId = null) {
    return StringPeer::getString("language.".$this->getId(), $sLanguageId, $this->getId());
  }
  
  public function getName() {
    return $this->getLanguageName();
  }

	public function getIsDefault() {
		return Settings::getSetting("session_default", Session::SESSION_LANGUAGE_KEY, null) === $this->getId();
	}
}