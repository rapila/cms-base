<?php
/**
 * @package modules.widget
 */
class LanguageInputWidgetModule extends PersistentWidgetModule {

	var $sSelectedLanguageId;

	public function __construct($sWidgetId = null) {
		parent::__construct($sWidgetId);
		$this->setSetting('is_monolingual', self::isMonolingual());
	}
	
	public function getLanguages($bUseAdminLanguages = false, $bDisplayInOriginalLanguage = false) {
		if($bUseAdminLanguages) {
			$aLanguages = self::getAdminLanguages($bDisplayInOriginalLanguage);
			$aResult = array();
			foreach($aLanguages as $sLanguageId => $sLanguageName) {
				$aResult[] = array('id' => $sLanguageId, 'language_name' => $sLanguageName);
			}
			return $aResult;
		} else {
			return WidgetJsonFileModule::jsonBaseObjects(LanguageQuery::create()->orderById()->find(), array('id', 'language_name'));
		}
	}
	
	public static function getAdminLanguages($bDisplayOriginalLanguage = false) {
		// display registered languages instead of found and possibly incomplete ones
		$aLanguages = array();
		$aRegisteredLanguages = Settings::getSetting('admin', 'registered_user_languages', array());
		foreach($aRegisteredLanguages as $sLanguageId) {
			$aLanguages[$sLanguageId] = self::getLanguageName($sLanguageId, $bDisplayOriginalLanguage ? $sLanguageId : null);
		}
		return $aLanguages;
	}

	public function isMonolingual() {
		return LanguageQuery::create()->count() <= 1;
	}
	
	const STATIC_STRING_NAMESPACE = 'language';
	public static function getLanguageName($sOfLanguageId, $sInLanguageId = null) {
		return StringPeer::getString(self::STATIC_STRING_NAMESPACE.".".$sOfLanguageId, $sInLanguageId, $sOfLanguageId);
	}
	
	public function setSessionLanguage($sLanguage) {
		Session::getSession()->setLanguage($sLanguage);
	}
	
	public function setContentLanguage($sLanguage) {
		AdminManager::setContentLanguage($sLanguage);
	}
	
	public function setSelectedLanguageId($sSelectedLanguageId) {
		if($sSelectedLanguageId === '') {
			$sSelectedLanguageId = null;
		}
		$this->sSelectedLanguageId = $sSelectedLanguageId;
	}
	
	public function getSelectedLanguageId() {
		return $this->sSelectedLanguageId;
	}
	
	public function getElementType() {
		return 'select';
	}

}