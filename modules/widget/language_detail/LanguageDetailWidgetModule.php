<?php
/**
 * @package modules.widget
 */
class LanguageDetailWidgetModule extends PersistentWidgetModule {
	private $sLanguageId = null;
	
	public function setLanguageId($sLanguageId) {
		$this->sLanguageId = $sLanguageId;
	}
	
	public function languageData() {
		$oLanguage = LanguageQuery::create()->findPk($this->sLanguageId);
		$aResult = $oLanguage->toArray();
		$aResult['LanguageName'] = $oLanguage->getLanguageName();
		$aResult['CreatedInfo'] = Util::formatCreatedInfo($oLanguage);
		$aResult['UpdatedInfo'] = Util::formatUpdatedInfo($oLanguage);
		$sLanguageKey = LanguagePeer::STATIC_STRING_NAMESPACE.'.'.$this->sLanguageId;

    // check existence of translation string in its own language
		if(TranslationPeer::getString($sLanguageKey, $this->sLanguageId, '') === '') {
			$sMessage = TranslationPeer::getString('wns.check_static_strings', AdminManager::getContentLanguage(), 'Please check strings', $aParameters= array('string_key' => $sLanguageKey));
			$aResult['LanguageStringMissing'] = $sMessage;
		}
		return $aResult;
	}
	
	private function validate($aLanguageData, $oLanguage) {
		$oFlash = Flash::getFlash();
		$oFlash->setArrayToCheck($aLanguageData);
		$oFlash->checkForLength('language_id', 2, 5, 'language_id_required');
		if($oFlash->checkForValue('path_prefix', 'path_prefix_required')) {
			$oFlash->checkForValue('path_prefix', 'path_prefix_unique');
		}
		if(LanguageQuery::create()->filterByPathPrefix($aLanguageData['path_prefix'])->filterById($aLanguageData['language_id'], Criteria::NOT_EQUAL)->count() > 0) {
			$oFlash->addMessage('path_prefix_unique');
		}
		$oFlash->finishReporting();
	}

	public function saveData($aLanguageData) {
		// string key is changed if a existing Language string_key is changed
		if($aLanguageData['language_id'] !== $this->sLanguageId) {
			$this->sLanguageId = $aLanguageData['language_id'];
		}
		$oLanguage = LanguageQuery::create()->findPk($this->sLanguageId);
		if($oLanguage === null) {
			$oLanguage = new Language();
			$oLanguage->setId($aLanguageData['language_id']);
		}
		$this->validate($aLanguageData, $oLanguage);
		if(!Flash::noErrors()) {
			throw new ValidationException();
		}
		$oLanguage->setIsActive($aLanguageData['is_active']);
		$oLanguage->setPathPrefix($aLanguageData['path_prefix']);
		return $oLanguage->save();
	}
}
