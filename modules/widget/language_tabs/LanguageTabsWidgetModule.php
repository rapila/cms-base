<?php
/**
 * @package modules.widget
 */
class LanguageTabsWidgetModule extends WidgetModule {

	public function getLanguages() {
	  return LanguagePeer::getLanguagesAssoc();
	}
	
	public function updateContentLanguage($sLanguageId) {
	  AdminManager::setContentLanguage($sLanguageId);
	}
	
	public function getElementType() {
	  return 'div';
	}
	
	
}