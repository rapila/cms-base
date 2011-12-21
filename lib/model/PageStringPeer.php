<?php

	// include base peer class
	require_once 'model/om/BasePageStringPeer.php';
	
	// include object class
	include_once 'model/PageString.php';


/**
 * @package model
 */ 
class PageStringPeer extends BasePageStringPeer {

	public static function initializeRootPageString($sPagestring, $iPageId, $sLanguageId) {
		$sPageString = new PageString();
		$sPageString->setPageId($iPageId);
		$sPageString->setLanguageId($sLanguageId);
		$sPageString->setPageTitle($sPagestring);
		$sPageString->setIsInactive(false);
		$sPageString->save();
		return $sPageString;
	}
}

