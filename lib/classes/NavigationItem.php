<?php

abstract class NavigationItem {
	protected $oParent;
	protected $aCustomChildren;
	protected $aChildren;
	
	public function __construct($oParent) {
		$this->oParent = $oParent;
		$this->aCustomChildren = array();
		$this->aChildren = array();
	}
	
	protected abstract function getChildrenImpl($sLanguageId, $bIncludeDisabled, $bIncludeInvisible);
	
	public function getChildren($sLanguageId = null, $bIncludeDisabled = false, $bIncludeInvisible = false) {
		$sKey = "{$sLanguageId}_{$bIncludeDisabled}_{$bIncludeInvisible}";
		if(!isset($this->aChildren[$sKey])) {
			$this->aChildren[$sKey] = $this->getChildrenImpl($sLanguageId, $bIncludeDisabled, $bIncludeInvisible);
		}
		return array_merge($this->aCustomChildren, $this->aChildren[$sKey]);
	}
	
	public function isRoot() {
		return $this->oParent === null;
	}
	
	public abstract function isCurrent();
	public function isActive() {
		return $this->getCurrent() !== null;
	}
	public abstract function isSiblingOfCurrent();
	
	public function isSiblingOfActive() {
		if($this->oParent === null) {
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
	
	public function hasChildren($sLanguageId = null, $bIncludeDisabled = false, $bIncludeInvisible = false) {
		if($this->hasCustomChildren()) {
			return true;
		}
		return count($this->getChildren($sLanguageId, $bIncludeDisabled, $bIncludeInvisible)) > 0;
	}
	
	public function hasCustomChildren() {
		return count($this->aCustomChildren) > 0;
	}
	
	public function addChild(NavigationItem $oChild) {
		$this->aCustomChildren[$oChild->getName()] = $oChild;
	}
	
	public function namedChild($sName) {
		$aChildren = $this->getChildren();
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