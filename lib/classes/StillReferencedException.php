<?php
class StillReferencedException extends LocalizedException {

	public function __construct($oReferencedObject, $sDefaultLanguageId = null) {
		$aMessageParameters = array();
		foreach($oReferencedObject->getReferees() as $oReferee) {
			$oFrom = $oReferee->getFrom();
			$aFrom = array();
			$aFrom["name"] = Util::descriptionForObject($oFrom, $sDefaultLanguageId);
			$aFrom["model"] = $oReferee->getFromModelName();
			$aMessageParameters['references'][] = $aFrom;
		}
		$aMessageParameters['to'] = Util::nameForObject($oReferencedObject);
		parent::__construct('wns.still_referenced.message', $aMessageParameters, null, 0, $sDefaultLanguageId);
	}
}