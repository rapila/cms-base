<?php

class NotPermittedException extends LocalizedException {
	public function __construct($sMessageKey, $aMessageParameters = null) {
		parent::__construct('rights.missing.'.$sMessageKey, $aMessageParameters, 'LocalizedException');
	}
}
