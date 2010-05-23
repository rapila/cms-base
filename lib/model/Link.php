<?php

require_once 'model/om/BaseLink.php';

/**
 * @package model
 */ 
class Link extends BaseLink {
	public function getCategoryName() {
		if($this->getLinkCategory()) {
			return $this->getLinkCategory()->getName();
		}
		return null;
	}

}