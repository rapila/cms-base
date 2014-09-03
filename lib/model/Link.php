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

	public function getIsExternallyManaged() {
		if($this->getLinkCategory()) {
			return $this->getLinkCategory()->getIsExternallyManaged();
		}
		return false;
	}

	public function shouldBeIncludedInList($sLanguageId, $oPage) {
		return $this->getLanguageId() === null || $this->getLanguageId() === $sLanguageId;
	}

	public function getNameTruncated($iLength = 40) {
		return StringUtil::truncate($this->getName(), $iLength);
	}

	public function getDescriptionTruncated($iLength = 40) {
		return StringUtil::truncate($this->getDescription(), $iLength);
	}

	public function hasTags() {
		return $this->getHasTags();
	}

	public function getHasTags() {
		return TagQuery::create()->filterByTagged($this)->count() > 0;
	}

	public function renderListItem($oTemplate) {
		$oTemplate->replaceIdentifier("id", $this->getId());
		$oTemplate->replaceIdentifier("name", $this->getName());
		$oTemplate->replaceIdentifier("link_text", $this->getName());
		$oTemplate->replaceIdentifier("title", $this->getName());
		$oTemplate->replaceIdentifier("description", $this->getDescription());
		$oTemplate->replaceIdentifier("url", $this->getUrl());
		$aUrl = explode('://', $this->getUrl());
		if(isset($aUrl[1])) {
			$sUrlWithoutProtocol = $aUrl[1];
		} else {
			$sUrlWithoutProtocol = $this->getUrl();
		}
		$oTemplate->replaceIdentifier("url_without_protocol", $sUrlWithoutProtocol);
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
