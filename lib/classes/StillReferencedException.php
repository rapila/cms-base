<?php
class StillReferencedException extends LocalizedException {

	public function __construct($oReferencedObject, $sDefaultLanguageId = null) {
		$aMessageParameters = array();
		foreach($oReferencedObject->getReferees() as $oReferee) {
			$oFrom = $oReferee->getFrom();
			$aFrom = array();
			$aFrom["model"] = $oReferee->getFromModelName();
			$aFrom["name"] = Util::descriptionForObject($oFrom, $sDefaultLanguageId);
			if(!$oFrom instanceof LanguageObject) {
				$aFrom["name"] = $aFrom["model"].': '.$aFrom["name"];
			}

			if(method_exists($oFrom, 'getAdminWidget')) {
				$oWidget = $oFrom->getAdminWidget();
				$aFrom["admin_widget"] = array($oWidget->getModuleName(), $oWidget->getSessionKey());
			} elseif(method_exists($oFrom, 'getAdminLink')) {
				$aFrom["admin_link"] = LinkUtil::link($oFrom->getAdminLink(), 'AdminManager');
			}

			$aMessageParameters['references'][] = $aFrom;
		}
		$aMessageParameters['to'] = Util::nameForObject($oReferencedObject);
		parent::__construct('wns.still_referenced.message', $aMessageParameters, null, 0, $sDefaultLanguageId);
	}
}