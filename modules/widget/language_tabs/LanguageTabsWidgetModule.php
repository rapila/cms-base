<?php
/**
 * @package modules.widget
 */
class LanguageTabsWidgetModule extends WidgetModule {
	public function getLanguages() {
		$aResult = array();
		foreach(LanguageQuery::create()->orderBySort()->find() as $oLanguage) {
			$aResult[$oLanguage->getId()] = $oLanguage->getLanguageName();
		} 
		asort($aResult);
		return $aResult;
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
