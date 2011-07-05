<?php
/**
 * @package modules.widget
 */
class StringWidgetModule extends WidgetModule {

	public function getString($sKey, $aParams = array(), $sLanguageId = null, $sDefaultValue = null) {
		return StringPeer::getString($sKey, $sLanguageId, $sDefaultValue, $aParams, false);
	}
	
	public function getStringAsHTML($sKey, $aParams = array(), $sLanguageId = null, $sDefaultValue = null) {
		$mResult = StringPeer::getString($sKey, $sLanguageId, $sDefaultValue, $aParams, true);
		$oTemplate = new Template(TemplateIdentifier::constructIdentifier('result'), null, true);
		$oTemplate->replaceIdentifier('result', $mResult);
		return $oTemplate->render();
	}
	
	public static function isSingleton() {
		return true;
	}
}