<?php
/**
 * @package modules.widget
 */
class LanguageTabsWidgetModule extends WidgetModule {
	public function getLanguages() {
	  return LanguagePeer::getLanguagesAssoc(false, true);
	}
	
	public function updateContentLanguage($sLanguageId) {
		AdminManager::setContentLanguage($sLanguageId);
		return $sLanguageId;
	}
	
	public function getContentLanguage() {
		return AdminManager::getContentLanguage();
	}

	public function getElementType() {
	  return 'div';
	}
	
	
}
