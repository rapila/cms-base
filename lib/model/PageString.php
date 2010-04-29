<?php

require_once 'model/om/BasePageString.php';


/**
 * @package model
 */ 
class PageString extends BasePageString {
	public function getPageTitle() {
		return $this->getLongTitle();
	}
	
	public function getLinkText() {
		return $this->getTitle() === null ? $this->getPageTitle() : $this->getTitle();
	}
	
	public function getLinkTextOnly() {
		return $this->getTitle();
	}
}

