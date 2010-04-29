<?php

class LocalizedException extends Exception {
	
	private $sMessageKey;
	
	public function __construct($sMessageKey, $aMessageParameters = null, $iCode = 0, $sDefaultLanguageId = null) {
		$this->sMessageKey = $sMessageKey;
		parent::__construct(StringPeer::getString($sMessageKey, $sDefaultLanguageId, null, $aMessageParameters), $iCode);
	}
	
	public function getLocalizedMessage($sLanguageId = null) {
		return StringPeer::getString($this->sMessageKey, $sLanguageId);
	}
}