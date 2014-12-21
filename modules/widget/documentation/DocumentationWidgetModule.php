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
		// Remove the language if it is a preferred documentation language, so it's ignored in the fallback
		$iIndex = array_search($sUserLanguage, $aPreferredDocumentationLanguages);
		if($iIndex !== false) {
			unset($aPreferredDocumentationLanguages[$iIndex]);
		}

		// Is documentation, not part
		$bIsMain = false;
		// Documentation key variable to check loose parts (static documentations)
		$sMainKey = null;
		foreach($aMetaData as $sKey => $aLanguageData) {
			// Insert special part if there is no documentation part after a main documentation entry
			// implying that the documentation has a tutorial video
			if(strpos($sKey, '/') === false) {
				if($bIsMain) {
					self::format($sKey.'youtube_video', null);
				}
				$sMainKey = $sKey;
			}
			// Remove loose documentation parts
			if(!StringUtil::startsWith($sKey, $sMainKey)) {
				continue;
			}
			$bIsMain = strpos($sKey, '/') === false;

			// Get preferred user language documentation(_part)
			if(isset($aLanguageData[$sUserLanguage])) {
				self::format($sKey, $aLanguageData[$sUserLanguage]);
				continue;
			}

			// Fallback if documentation doesn't exist in preferred user language
			foreach($aPreferredDocumentationLanguages as $sLanguage) {
				if(isset($aLanguageData[$sLanguage])) {
					self::format($sKey, $aLanguageData[$sLanguage]);
					break;
				}
			}
		}
		// Remove documentations without parts
		foreach(self::$COUNT_PARTS as $sName => $iCount) {
			if($iCount === 0) {
				unset(self::$COUNT_PARTS[$sName]);
			}
		}
		return self::$METADATA;
	}

  /**
	 * loadSupportTab()
	 * configure support tab in your site/config/config.yml like this
	 * documentation:
	 *   support_info:
	 *     heading: 'Support SchulCMS'
	 *     link_text: 'Support und Vorgehen'
	 *     link: 'http://www.schulcms.ch/support'
	 * @return object
	 */
	public function loadSupportTab() {
		$aSupportInfo = Settings::getSetting('documentation', 'support_info', null);
		$oSupport = new StdClass();
		if($aSupportInfo) {
			$oSupport->heading = $aSupportInfo['heading'];
			$oSupport->link_text = $aSupportInfo['link_text'];
			$oSupport->link = $aSupportInfo['link'];
		}
		return $oSupport;
	}

	private function format($sKey, $aLanguageData) {
		$oData = new StdClass();
		if($aLanguageData === null) {
			$oData->is_main = false;
		} else if($aLanguageData['url'] !== null && $aLanguageData['title'] !== null)  {
			$oData->title = $aLanguageData['title'];
			$oData->url = $aLanguageData['url'];
			$oData->is_main = strpos($sKey, '/') === false;
		} else {
			return;
		}
		self::register($sKey, $oData);
	}

	private function register($sKey, $oData) {
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