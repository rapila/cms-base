<?php

class ValidationException extends LocalizedException {
	public function __construct($oFlash = null) {
		$aParameters = array();
		if($oFlash === null) {
			$oFlash = Flash::getFlash();
		}
		if(is_array($oFlash)) {
			$aParameters = $oFlash;
		} else {
			$oFlash->finishReporting();
			foreach($oFlash->getMessages() as $sMessageKey) {
				$aParameters[$sMessageKey] = $oFlash->getMessageProperties($sMessageKey);
			}
		}
		parent::__construct('wns.exception_validation', $aParameters, get_class($this));
	}
}