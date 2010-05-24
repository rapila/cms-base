<?php

class PageNavigationItem extends NavigationItem {
	private $oMe;
	private $oCurrentPage;
	
	private $bIsCurrent;
	
	public function __construct(Page $oMe, Page $oCurrentPage, $oParent = null) {
		parent::__construct($oParent);
		$this->oMe = $oMe;
		$this->oCurrentPage = $oCurrentPage;
		$this->bIsCurrent = $this->oMe->getId() === $this->oCurrentPage->getId();
	}
	
	protected function getChildrenImpl($sLanguageId, $bIncludeDisabled, $bIncludeInvisible) {
		$aResult = array();
		foreach($this->oMe->getChildrenWith($sLanguageId, $bIncludeDisabled, $bIncludeInvisible) as $oPage) {
			$aResult[$oPage->getName()] = new PageNavigationItem($oPage, $this->oCurrentPage, $this);
		}
		return $aResult;
	}
	
	public function isRoot() {
		return $this->oMe->isRoot();
	}
	
	public function isCurrent() {
		return $this->bIsCurrent;
	}
	
	public function isActive() {
		return $this->oMe->getLeftValue() <= $this->oCurrentPage->getLeftValue() && $this->oMe->getRightValue() >= $this->oCurrentPage->getRightValue();
	}
	
	public function isSiblingOfCurrent() {
		if($this->isRoot()) {
			return false;
		}
		if($this->oMe->getLevel() !== $this->oCurrentPage->getLevel()) {
			return false;
		}
		return $this->oMe->getParent()->getId() === $this->oCurrentPage->getParent()->getId();
	}
	
	public function getTitle($sLanguageId = null) {
		return $this->oMe->getActivePageString($sLanguageId)->getPageTitle();
	}
	
	public function getLinkText($sLanguageId = null) {
		return $this->oMe->getActivePageString($sLanguageId)->getLinkText();
	}
	
	public function getName() {
		return $this->oMe->getName();
	}
	
	public function getLink() {
		return $this->oMe->getFullPathArray();
	}
	
	public function isProtected() {
		return $this->oMe->getIsProtected();
	}
	
	public function isAccessible() {
		if(!$this->isProtected()) {
			return true;
		}
		return Session::getSession()->isAuthenticated() && Session::getSession()->getUser()->mayViewPage($this->oMe);
	}
	
	public function isVisible() {
		return !$this->oMe->getIsHidden();
	}
	
	public function isEnabled() {
		return !$this->oMe->getIsInactive();
	}
	
	public function isFolder() {
		return $this->oMe->getIsFolder();
	}
	
	public function isVirtual() {
		return false;
	}
	
	public function hasChildren($sLanguageId = null, $bIncludeDisabled = false, $bIncludeInvisible = false) {
		return $this->oMe->hasChildrenWith($sLanguageId, $bIncludeInvisible, $bIncludeInvisible);
	}
	
}