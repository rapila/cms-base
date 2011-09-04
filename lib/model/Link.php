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
	
	public function shouldBeIncludedInList($sLanguageId, $oPage) {
		return $this->getLanguageId() === null || $this->getLanguageId() === $sLanguageId;
	}
	
	public function renderListItem($oTemplate) {
		$oTemplate->replaceIdentifier("id", $this->getId());
		$oTemplate->replaceIdentifier("name", $this->getName());
		$oTemplate->replaceIdentifier("link_text", $this->getName());
		$oTemplate->replaceIdentifier("title", $this->getName());
		$oTemplate->replaceIdentifier("description", $this->getDescription());
		$oTemplate->replaceIdentifier("url", $this->getUrl());
		$oTemplate->replaceIdentifier('link_category_id', $this->getLinkCategoryId());
		$oTemplate->replaceIdentifier('category_id', $this->getLinkCategoryId());
		if($this->getLinkCategory() !== null) {
			$oTemplate->replaceIdentifier('link_category', $this->getLinkCategory()->getName());
			$oTemplate->replaceIdentifier('category', $this->getLinkCategory()->getName());
		}
	}
	
	public function getLanguageName() {
	  if($this->getLanguageId()) {
	    return StringPeer::getString('language.'.$this->getLanguageId());
	  }
	}

}
