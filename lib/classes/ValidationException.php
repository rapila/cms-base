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
				$aParameters[$sMessageKey] = $oFlash->getMessage($sMessageKey)->render();
			}
		}
		parent::__construct('validation', $aParameters, get_class($this));
	}
}