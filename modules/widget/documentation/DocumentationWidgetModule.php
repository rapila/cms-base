<?php
class DocumentationWidgetModule extends PersistentWidgetModule {

	private static $METADATA = array();
	private static $PARENT_KEY;
	private static $COUNT_PARTS = array();

	public function __construct($sSessionKey = null) {
		parent::__construct($sSessionKey);
	}

	public function loadDocumentations() {
		$aMetaData = DocumentationProviderTypeModule::completeMetaData();
		$aPreferredDocumentationLanguages = array('de', 'en');
		$sUserLanguage = Session::getSession()->getUser()->getLanguageId();
		// remove the language if it is a preferred documentation language, so it's ignored in the fallback
		$iIndex = array_search($sUserLanguage, $aPreferredDocumentationLanguages);
		if($iIndex !== false) {
			unset($aPreferredDocumentationLanguages[$iIndex]);
		}
		foreach($aMetaData as $sKey => $aLanguageData) {
			// get preferred user language documentation(_part)
			if(isset($aLanguageData[$sUserLanguage])) {
				self::format($sKey, $aLanguageData[$sUserLanguage]);
				continue;
			}
			// fallback if documentation doesn't exist in preferred user language
			foreach($aPreferredDocumentationLanguages as $sLanguage) {
				if(isset($aLanguageData[$sLanguage])) {
					self::format($sKey, $aLanguageData[$sLanguage]);
					break;
				}
			}
		}
		// remove documentations without parts
		foreach(self::$COUNT_PARTS as $sName => $iCount) {
			if($iCount === 0) {
				unset(self::$COUNT_PARTS[$sName]);
			}
		}
		ErrorHandler::log('$METADATA', self::$METADATA);
		return self::$METADATA;
	}

	private function format($sKey, $aLanguageData) {
		if($aLanguageData['url'] == null || $aLanguageData['title'] == null) {
			return;
		}
		$oData = new StdClass();
		$oData->title = $aLanguageData['title'];
		$oData->url = $aLanguageData['url'];
		$oData->is_main = strpos($sKey, '/') === false;
		if($oData->is_main) {
			self::$PARENT_KEY = $sKey;
			self::$COUNT_PARTS[self::$PARENT_KEY] = 0;
			$oData->parent = null;
		} else {
			self::$COUNT_PARTS[self::$PARENT_KEY]++;
			$oData->parent = self::$PARENT_KEY;
		}
		self::$METADATA[$sKey] = $oData;
	}
}