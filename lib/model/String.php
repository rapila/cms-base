<?php

require_once 'model/om/BaseString.php';

/**
 * @package model
 */ 
class String extends BaseString {
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
			$oString = StringQuery::create()->findPk(array($sLanguageId, $this->getStringKey()));
			if($oString) {
				return $oString->getTextTruncated($iLength);
			}
		}
		return null;
	}
	
	public function getLanguagesAvailable() {
		return implode(', ', StringQuery::create()->filterByStringKey($this->getStringKey())->orderByLanguageId()->select('LanguageId')->find()->toArray());
	}
}
