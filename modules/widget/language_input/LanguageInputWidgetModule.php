<?php
/**
 * @package modules.widget
 */
class LanguageInputWidgetModule extends WidgetModule {

	var $sSelectedLanguageId;

	public function __construct($sWidgetId) {
		parent::__construct($sWidgetId);
		$this->addResourceParameter(ResourceIncluder::RESOURCE_TYPE_JS, 'is_monolingual', LanguagePeer::doCount(new Criteria()) <= 1);
	}

	public function getLanguages($bUseAdminLanguages = false) {
		if($bUseAdminLanguages) {
			$aLanguages = LanguagePeer::getAdminLanguages();
			$aResult = array();
			foreach($aLanguages as $sLanguageId => $sLanguageName) {
				$aResult[] = array('id' => $sLanguageId, 'language_name' => $sLanguageName);
			}
			return $aResult;
		} else {
			return WidgetJsonFileModule::jsonBaseObjects(LanguagePeer::getLanguages(false, null), array('id', 'language_name'));
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