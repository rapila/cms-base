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
}
