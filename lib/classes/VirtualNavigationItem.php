<?php

class VirtualNavigationItem extends NavigationItem {
	private $sName;
	private $sTitle;
	private $sLinkText;
	private $mData;
	private $sType;
	
	public function __construct($sType, $sName, $sTitle, $sLinkText = null, $mData = null) {
		$this->sType = $sType;
		$this->sName = (string) $sName;
		$this->sTitle = $sTitle;
		$this->sLinkText = ($sLinkText === null ? $sTitle : $sLinkText);
		$this->mData = $mData;
		parent::__construct(null);
	}
	
	public function getChildrenImpl($sLanguageId, $bIncludeDisabled, $bIncludeInvisible) {
		return array();
	}
	
	public function hasChildrenImpl($sLanguageId, $bIncludeDisabled, $bIncludeInvisible) {
		return false;
	}
	
	public function isCurrent() {
		return FrontendManager::$CURRENT_NAVIGATION_ITEM === $this;
	}
	
	public function getData() {
	    return $this->mData;
	}
	
	public function getType() {
	    return $this->sType;
	}
	
	public function getTitle($sLanguageId = null) {
		return $this->sTitle;
	}
	
	public function getLinkText($sLanguageId = null) {
		return $this->sLinkText;
	}
	
	public function getDescription($sLanguageId = null) {
		return null;
	}
	
	public function getName() {
		return $this->sName;
	}
	
	public function isProtected() {
		return false;
	}
	
	public function isVisible() {
		return true;
	}

	public function isEnabled() {
		return true;
	}
	
	public function isFolder() {
		return false;
	}
	
	public function isVirtual() {
		return true;
	}
	
}