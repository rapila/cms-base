<?php
/**
 * @package modules.widget
 */
class LanguageDetailWidgetModule extends PersistentWidgetModule {
	private $sLanguageId = null;
	
	public function setLanguageId($sLanguageId) {
		$this->sLanguageId = $sLanguageId;
	}
	
	public function getLanguageData() {
		$oLanguage = LanguagePeer::retrieveByPK($this->sLanguageId);
		$aResult = $oLanguage->toArray();
		$aResult['LanguageName'] = $oLanguage->getLanguageName();
		return $aResult;
	}
	
	public function saveData($aLanguageData) {
		if($aLanguageData !== $this->sLanguageId) {
			$this->sLanguageId = $aLanguageData['language_id'];
		}
		$oLanguage = LanguagePeer::retrieveByPK($this->sLanguageId);
		if($oLanguage === null) {
			$oLanguage = new Language();
			$oLanguage->setId($aLanguageData['language_id']);
		}
		$oLanguage->setIsActive(isset($aLanguageData['is_active']));
		return $oLanguage->save();
	}
}