<?php

class UserError Extends LocalizedException {
	
	public function __construct($sMessageKey, $aMessageParameters = null, $sExceptionType = null, $iCode = 0, $sDefaultLanguageId = null) {
		parent::__construct($sMessageKey, $aMessageParameters, $sExceptionType, $iCode, $sDefaultLanguageId);
	}
}