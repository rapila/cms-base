<?php

require_once 'model/om/BaseLanguage.php';


/**
 * @package model
 */ 
class Language extends BaseLanguage {
	public function getLanguageName($sLanguageId = null) {
		return LanguagePeer::getLanguageName($this->getId(), $sLanguageId);
	}
	
	public function getName() {
		return $this->getLanguageName();
	}

	public function getIsDefault() {
		return Settings::getSetting("session_default", Session::SESSION_LANGUAGE_KEY, null) === $this->getId();
	}

	public function getIsDefaultEdit() {
		return Settings::getSetting("session_default", AdminManager::CONTENT_LANGUAGE_SESSION_KEY, null) === $this->getId();
	}

	public static function languagesExist() {
		return self::doCount(new Criteria()) > 0;
	}
}