<?php

class LocalizedException extends Exception {

	private $sMessageKey;
	private $sExceptionType;
	private $aMessageParameters;

	public function __construct($sMessageKey, $aMessageParameters = null, $sExceptionType = null, $iCode = 0, $sDefaultLanguageId = null) {
		$this->sMessageKey = $sMessageKey;
		if($sExceptionType === null) {
			$sExceptionType = get_class($this);
		}
		$this->sExceptionType = $sExceptionType;
		if($aMessageParameters === null) {
			$aMessageParameters = array();
		}
		$aMessageParameters['exception_type'] = $sExceptionType;
		$this->aMessageParameters = $aMessageParameters;
		parent::__construct(TranslationPeer::getString($sMessageKey, $sDefaultLanguageId, null, $aMessageParameters), $iCode);
	}

	public function getLocalizedMessage($sLanguageId = null) {
		return TranslationPeer::getString($this->sMessageKey, $sLanguageId, null, $this->aMessageParameters);
	}

	public function getMessageParameters() {
		return $this->aMessageParameters;
	}

	public function getMessageKey() {
		return $this->sMessageKey;
	}

	public function getExceptionType() {
		return $this->sExceptionType;
	}
}