<?php

require_once 'model/om/BasePageString.php';


/**
 * @package model
 */ 
class PageString extends BasePageString {
	public function getLinkText() {
		return parent::getLinkText() === null ? $this->getPageTitle() : parent::getLinkText();
	}
	
	public function getLinkTextOnly() {
		return parent::getLinkText();
	}
	
	public function hasLanguageObjectsFilled($sLanguageId) {
		$oCriteria = new Criteria();
		$oCriteria->addJoin(ContentObjectPeer::ID, LanguageObjectPeer::OBJECT_ID);
		$oCriteria->add(LanguageObjectPeer::LANGUAGE_ID, $sLanguageId);
		return $this->getPage()->countContentObjects($oCriteria) > 0;
	}
}
