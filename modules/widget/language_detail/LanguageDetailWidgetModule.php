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
		$sLanguageKey = LanguagePeer::STATIC_STRING_NAMESPACE.'.'.$this->sLanguageId;
		if(StringPeer::staticStringExists($sLanguageKey, $this->sLanguageId) === false) {
			$sMessage = StringPeer::getString('widget.check_static_strings', AdminManager::getContentLanguage(), 'Please check strings', $aParameters= array('string_key' => $sLanguageKey));
			$aResult['LanguageStringMissing'] = $sMessage;
		}
		return $aResult;
	}
	
	private function validate($aLanguageData) {
		$oFlash = Flash::getFlash();
		$oFlash->setArrayToCheck($aLanguageData);
		$oFlash->checkForLength('language_id', 2, 2, 'language_id_required');
		$oFlash->finishReporting();
	}

	
	public function saveData($aLanguageData) {
		// string key is changed if a existing Language string_key is changed
		if($aLanguageData['language_id'] !== $this->sLanguageId) {
			$this->sLanguageId = $aLanguageData['language_id'];
		}
		$oLanguage = LanguagePeer::retrieveByPK($this->sLanguageId);
		if($oLanguage === null) {
			$oLanguage = new Language();
			$oLanguage->setId($aLanguageData['language_id']);
		}
		$this->validate($aLanguageData);
		if(!Flash::noErrors()) {
			throw new ValidationException();
		}

		$oLanguage->setIsActive(isset($aLanguageData['is_active']));
		return $oLanguage->save();
	}
}