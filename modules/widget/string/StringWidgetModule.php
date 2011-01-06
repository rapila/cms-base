<?php
/**
 * @package modules.widget
 */
class StringWidgetModule extends WidgetModule {

	public function getString($sKey, $aParams = array(), $sLanguageId = null, $sDefaultValue = null) {
		$mResult = StringPeer::getString($sKey, $sLanguageId, $sDefaultValue, $aParams, true, Template::NO_HTML_ESCAPE);
		$bIsTemplate = ($mResult instanceof Template);
		return array('is_template' => $bIsTemplate, 'string' => $bIsTemplate ? $mResult->render() : $mResult);
	}
	
	public static function isSingleton() {
		return true;
	}
}