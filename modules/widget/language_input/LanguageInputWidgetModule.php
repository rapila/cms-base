<?php
/**
 * @package modules.widget
 */
class LanguageInputWidgetModule extends WidgetModule {
	
	public function getLanguages() {
		return WidgetJsonFileModule::jsonBaseObjects(LanguagePeer::getLanguages(false, null), array('id', 'language_name'));
	}
	
	public function setSessionLanguage($sLanguage) {
		Session::getSession()->setLanguage($sLanguage);
	}
	
	public function setContentLanguage($sLanguage) {
		AdminManager::setContentLanguage($sLanguage);
	}
}