<?php
class DocumentationDisplayWidgetModule extends WidgetModule {
	public function __construct() {

	}

	public function partFor($sDocumentationPartKey) {
		$oResult = new stdClass();
		$aData = DocumentationProviderTypeModule::dataForPart($sDocumentationPartKey, Session::language());
		if(!$aData) {
			throw new LocalizedException("wns.documentation.unknown", array('key' => $sDocumentationPartKey, 'language' => Session::language()));
		}
		$oResult->title = $aData['title'];
		$oResult->content = $aData['content'];
		$oResult->url = $aData['url'];
		return $oResult;
	}
	
	public static function needsLogin() {
		// Documentaion does not need login (no private information in documentation parts)
		return false;
	}
}