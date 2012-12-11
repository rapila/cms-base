<?php
/**
 * @package modules.widget
 */
class LanguageInputWidgetModule extends PersistentWidgetModule {

	var $sSelectedLanguageId;

	public function __construct($sWidgetId = null) {
		parent::__construct($sWidgetId);
		$this->setSetting('is_monolingual', LanguagePeer::isMonolingual());
	}

	public function getLanguages($bUseAdminLanguages = false, $bDisplayInOriginalLanguage = false) {
		if($bUseAdminLanguages) {
			$aLanguages = LanguagePeer::getAdminLanguages($bDisplayInOriginalLanguage);
			$aResult = array();
			foreach($aLanguages as $sLanguageId => $sLanguageName) {
				$aResult[] = array('id' => $sLanguageId, 'language_name' => $sLanguageName);
			}
			return $aResult;
		} else {
			return WidgetJsonFileModule::jsonBaseObjects(LanguageQuery::create()->orderById()->find(), array('id', 'language_name'));
		}
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