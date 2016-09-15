<?php

require_once 'model/om/BaseTranslation.php';

/**
 * @package model
 */ 
class Translation extends BaseTranslation {
	public function getOriginalText() {
		return parent::getText();
	}
	
	public function getTextTruncated($iLength=70) {
		return StringUtil::truncate($this->getText(), $iLength);
	}
	
	public function getTextTruncatedCurrent($iLength=70) {
		$sLanguageId = AdminManager::getContentLanguage();
		if($this->getLanguageId() === $sLanguageId) {
			return $this->getTextTruncated($iLength);
		} else {
			$oString = TranslationQuery::create()->findPk(array($sLanguageId, $this->getStringKey()));
			if($oString) {
				return $oString->getTextTruncated($iLength);
			}
		}
		return null;
	}
	
	public function getLanguagesAvailable() {
		return implode(', ', TranslationQuery::create()->filterByStringKey($this->getStringKey())->orderByLanguageId()->select('LanguageId')->find()->toArray());
	}
}