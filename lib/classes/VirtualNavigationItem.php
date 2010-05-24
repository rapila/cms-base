<?php

class VirtualNavigationItem extends NavigationItem {
	private $sName;
	private $sTitle;
	private $sLinkText;
	
	public function __construct($sName, $sTitle, $sLinkText = null) {
		$this->sName = $sName;
		$this->sTitle = $sTitle;
		$this->sLinkText = ($sLinkText === null ? $sTitle : $sLinkText);
		parent::__construct(null);
	}
	
	public function getChildrenImpl($sLanguageId, $bIncludeDisabled, $bIncludeInvisible) {
		return array();
	}
	
	public function hasChildrenImpl($sLanguageId, $bIncludeDisabled, $bIncludeInvisible) {
		return false;
	}
	
	/**
	* @todo
	*/
	public function isCurrent() {
		return FrontendManager::$CURRENT_NAVIGATION_ITEM === $this;
	}
	
	public function getTitle($sLanguageId = null) {
		return $this->sTitle;
	}
	
	public function getLinkText($sLanguageId = null) {
		return $this->sLinkText;
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