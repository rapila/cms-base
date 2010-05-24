<?php

abstract class NavigationItem {
	protected $oParent;
	protected $aCustomChildren;
	protected $aChildren;
	
	public function __construct($oParent) {
		$this->oParent = $oParent;
		$this->aChildren = array();
		$this->aCustomChildren = null;
	}
	
	public function getLevel() {
		if($this->isRoot()) {
			return 0;
		}
		return $this->oParent->getLevel()+1;
	}
	
	protected abstract function getChildrenImpl($sLanguageId, $bIncludeDisabled, $bIncludeInvisible);
	protected abstract function hasChildrenImpl($sLanguageId, $bIncludeDisabled, $bIncludeInvisible);
	
	private function prepareChildren() {
		if($this->aCustomChildren === null) {
			$this->aCustomChildren = array();
			FilterModule::getFilters()->handleNavigationItemChildrenRequested($this);
		}
	}
	
	public function getChildren($sLanguageId = null, $bIncludeDisabled = false, $bIncludeInvisible = false) {
		$sKey = "{$sLanguageId}_{$bIncludeDisabled}_{$bIncludeInvisible}";
		if(!isset($this->aChildren[$sKey])) {
			$this->aChildren[$sKey] = $this->getChildrenImpl($sLanguageId, $bIncludeDisabled, $bIncludeInvisible);
		}
		$this->prepareChildren();
		return array_merge($this->aCustomChildren, $this->aChildren[$sKey]);
	}
	
	public function hasChildren($sLanguageId = null, $bIncludeDisabled = false, $bIncludeInvisible = false) {
		$this->prepareChildren();
		if($this->hasCustomChildren()) {
			return true;
		}
		return $this->hasChildrenImpl($sLanguageId, $bIncludeDisabled, $bIncludeInvisible);
	}
	
	private function hasCustomChildren() {
		return count($this->aCustomChildren) > 0;
	}
	
	public function isRoot() {
		return $this->oParent === null;
	}
	
	public abstract function isCurrent();
	public function isActive() {
		return $this->getCurrent() !== null;
	}
	
	public function isSiblingOfCurrent() {
		if($this->isActive()) {
			return false;
		}
		$oCurrent = $this->getCurrent();
		if($oCurrent === null) {
			return false;
		}
		return $this->oParent->isActive() && $oCurrent->getLevel() === $this->getLevel();
	}
	
	public function isSiblingOfActive() {
		if($this->isRoot()) {
			return false;
		}
		return !$this->isActive() && !$this->oParent->isCurrent() && $this->oParent->isActive();
	}
	
	public function isChildOfCurrent() {
		if($this->isRoot()) {
			return false;
		}
		return $this->oParent->isCurrent();
	}
	
	public function isDescendantOfCurrent() {
		if($this->isRoot()) {
			return false;
		}
		if($this->oParent->isCurrent()) {
			return true;
		}
		return $this->oParent->isDescendantOfCurrent();
	}
	
	public abstract function getTitle($sLanguageId = null);
	public abstract function getLinkText($sLanguageId = null);
	public abstract function getName();
	
	public function getLink() {
		if($this->isRoot()) {
			return array();
		}
		return array_merge($this->oParent->getLink(), array($this->getName()));
	}
	
	public function getParent() {
		return $this->oParent;
	}
	
	public function getFirstChild($sLanguageId = null, $bIncludeDisabled = false, $bIncludeInvisible = false) {
		foreach($this->getChildren($sLanguageId, $bIncludeDisabled, $bIncludeInvisible) as $oChild) {
			if($oChild->isFolder()) {
				return $oChild->getFirstChild();
			}
			return $oChild;
		}
		return null;
	}
	
	public abstract function isProtected();
	public function isAccessible() {
		if(!$this->isProtected()) {
			return true;
		}
		return Session::getSession()->isAuthenticated();
	}
	public abstract function isVisible();
	public abstract function isEnabled();
	public abstract function isFolder();
	public abstract function isVirtual();
	
	public function addChild(NavigationItem $oChild) {
		$this->prepareChildren();
		$oChild->oParent = $this;
		$this->aCustomChildren[$oChild->getName()] = $oChild;
	}
	
	public function namedChild($sName, $sLanguageId = null, $bIncludeDisabled = false, $bIncludeInvisible = false) {
		$aChildren = $this->getChildren($sLanguageId, $bIncludeDisabled, $bIncludeInvisible);
		if(isset($aChildren[$sName])) {
			return $aChildren[$sName];
		}
		return null;
	}
	
	public function getCurrent() {
		if($this->isCurrent()) {
			return $this;
		}
		foreach($this->getChildren(null, true, true) as $oChild) {
			if($oChild->isActive()) {
				return $oChild->getCurrent();
			}
		}
		return null;
	}
}