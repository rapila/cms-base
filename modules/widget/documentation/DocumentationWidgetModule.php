<?php
class DocumentationWidgetModule extends PersistentWidgetModule {

	private $aDocumentations = array();
	
	const UNBOUND = '_unbound';

	public function __construct($sSessionKey = null) {
		parent::__construct($sSessionKey);
	}
	
	private function getDocumentations($sPreferredLanguageId) {
		$aMetaData = DocumentationProviderTypeModule::completeMetaData();
		$aPreferredDocumentationLanguages = array_unique(array($sPreferredLanguageId, 'de', 'en'));

		$cFormat = function ($aLanguageData) use ($aPreferredDocumentationLanguages) {
			$oResult = new stdClass();
			foreach($aPreferredDocumentationLanguages as $sLanguageId) {
				if(isset($aLanguageData[$sLanguageId])) {
					$oResult->title = $aLanguageData[$sLanguageId]['title'];
					$oResult->url = $aLanguageData[$sLanguageId]['url'];
				}
			}
			return $oResult;
		};

		// A list of all documentation heads, by key. Documentation heads are all the documentations whose keys do not contain a slash
		$aDocumentations = array();

		// Try to figure out how many documentations (and which ones) there are
		foreach($aMetaData as $sKey => $aLanguageData) {
			if(strpos($sKey, '/') !== false) {
				continue;
			}
			$aDocumentations[$sKey] = $cFormat($aLanguageData);
			$aDocumentations[$sKey]->parts = array();
		}

		// Add keys to documentations
		foreach($aMetaData as $sKey => $aLanguageData) {
			if(strpos($sKey, '/') === false) {
				continue;
			}
			$sDocumentationKey = explode('/', $sKey);
			$sPartKey = implode('/', array_slice($sDocumentationKey, 1));
			$sDocumentationKey = $sDocumentationKey[0];
			if(isset($aDocumentations[$sDocumentationKey])) {
				$aDocumentations[$sDocumentationKey]->parts[$sPartKey] = $cFormat($aLanguageData);
			} else {
				// If there are no documentations with this key, just pretend it’s a documentation in itself
				$aDocumentations[$sKey] = $cFormat($aLanguageData);
				$aDocumentations[$sKey]->parts = array();
			}
		}

		$aEmptyDocumentations = array();
		foreach($aDocumentations as $sKey => $oDocumentation) {
			if(count($oDocumentation->parts) === 0) {
				$aEmptyDocumentations[$sKey] = $oDocumentation;
				unset($aDocumentations[$sKey]);
			}
		}

		usort($aDocumentations, function($a, $b) {
			return strnatcasecmp($a->title, $b->title);
		});

		if(count($aEmptyDocumentations) > 0) {
			$oOthers = new stdClass();
			$oOthers->title = StringPeer::getString('wns.others', $sPreferredLanguageId, 'Weiteres');
			$oOthers->url = null;
			$oOthers->parts = $aEmptyDocumentations;
			$aDocumentations[] = $oOthers;
		}

		return $aDocumentations;
	}

	public function loadDocumentations() {
		$sUserLanguage = Session::getSession()->getUser()->getLanguageId();
		if(!isset($this->aDocumentations[$sUserLanguage])) {
			$this->aDocumentations[$sUserLanguage] = $this->getDocumentations($sUserLanguage);
		}
		return $this->aDocumentations[$sUserLanguage];
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
		return Settings::getSetting('documentation', 'support_info', array());
	}
}
