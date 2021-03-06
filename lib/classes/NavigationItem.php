<?php
/**
 * @package navigation
 */
abstract class NavigationItem {
	protected $oParent;
	private $oCanonical = false;
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
		if($this->aCustomChildren !== null) {
			return;
		}
		$sCacheKey = Session::language().'/'.$this->getId();
		$oCache = new Cache("$sCacheKey/custom-children", 'navigation');
		if($oCache->entryExists()) {
			// Not setting validators will result in the cache being always up-to-date
			$bIsOutdated = false;
			FilterModule::getFilters()->handleNavigationItemChildrenCacheDetectOutdated($this, $oCache, array(&$bIsOutdated));
			if(!$bIsOutdated) {
				$this->aCustomChildren = $oCache->getContentsAsVariable();
				foreach($this->aCustomChildren as $oChildNavigationItem) {
					$oChildNavigationItem->oParent = $this;
				}
				return;
			}
		}
		$this->aCustomChildren = array();
		FilterModule::getFilters()->handleNavigationItemChildrenRequested($this);
		$oCache->setContents($this->aCustomChildren, true);
	}

	protected function getCustomChildren($sLanguageId = null, $bIncludeDisabled = false, $bIncludeInvisible = false) {
		//Language id is ignored in this implementation
		if($bIncludeDisabled && $bIncludeInvisible) {
			return $this->aCustomChildren;
		}
		$aCustomChildren = array();
		foreach($this->aCustomChildren as $oChild) {
			if($bIncludeDisabled || $oChild->isEnabled()) {
				if($bIncludeInvisible || $oChild->isVisible()) {
					$aCustomChildren[$oChild->getName()] = $oChild;
				}
			}
		}
		return $aCustomChildren;
	}

	protected function hasCustomChildren($sLanguageId = null, $bIncludeDisabled = false, $bIncludeInvisible = false) {
		//Language id is ignored in this implementation
		if($bIncludeDisabled && $bIncludeInvisible) {
			return count($this->aCustomChildren) > 0;
		}
		foreach($this->aCustomChildren as $oChild) {
			if($bIncludeDisabled || $oChild->isEnabled()) {
				if($bIncludeInvisible || $oChild->isVisible()) {
					return true;
				}
			}
		}
		return false;
	}

	public function getChildren($sLanguageId = null, $bIncludeDisabled = false, $bIncludeInvisible = false) {
		$sKey = "{$sLanguageId}_{$bIncludeDisabled}_{$bIncludeInvisible}";
		if(!isset($this->aChildren[$sKey])) {
			$this->aChildren[$sKey] = $this->getChildrenImpl($sLanguageId, $bIncludeDisabled, $bIncludeInvisible);
		}
		$this->prepareChildren();
		return ($this->aChildren[$sKey] + $this->getCustomChildren($sLanguageId, $bIncludeDisabled, $bIncludeInvisible));
	}

	public function hasChildren($sLanguageId = null, $bIncludeDisabled = false, $bIncludeInvisible = false) {
		if($this->hasChildrenImpl($sLanguageId, $bIncludeDisabled, $bIncludeInvisible)) {
			return true;
		}
		$this->prepareChildren();
		return $this->hasCustomChildren($sLanguageId, $bIncludeDisabled, $bIncludeInvisible);
	}

	public function isRoot() {
		return $this->oParent === null;
	}

	public abstract function isCurrent();
	public abstract function isActive();
	public abstract function isSiblingOfCurrent();

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
	public abstract function getDescription($sLanguageId = null);
	public abstract function getName();
	public abstract function getType();

	public function getIdentifier() {
		return null;
	}

	public function getLink() {
		if($this->isRoot()) {
			return array();
		}
		return array_merge($this->oParent->getLink(), array($this->getName()));
	}

	private $sId = null;
	public final function getId() {
		if($this->sId === null) {
			$this->sId = get_class($this)."|".$this->getIdImpl();
		}
		return $this->sId;
	}
	
	/**
	* Gets a value uniquely identifying this navigation item. This could be a full path or an internal id of the backing store.
	* Note: This is NOT the same as the identifier retrieved using @link(getIdentifier()) as that is allowed to return null in some implementations.
	*/
	protected abstract function getIdImpl();

	/**
	* Gets a value uniquely identifying this navigation item in the form of (page id)/virtual/path/items.
	* Should be overridden by VirtualNavigationItem subclasses that implement getIdImpl if they return a value there that does not conform to the form as specified above.
	*/
	public function getPathId() {
		return $this->getIdImpl();
	}

	public function getParent() {
		return $this->oParent;
	}

	public function getFirstChild($sLanguageId = null, $bIncludeDisabled = false, $bIncludeInvisible = false) {
		foreach($this->getChildren($sLanguageId, $bIncludeDisabled, $bIncludeInvisible) as $oChild) {
			if($oChild->isFolder()) {
				return $oChild->getFirstChild($sLanguageId, $bIncludeDisabled, $bIncludeInvisible);
			}
			return $oChild;
		}
		return null;
	}

	protected abstract function getCanonicalImpl($sLanguageId = null);

	public function getCanonical($sLanguageId = null) {
		if($this->oCanonical === false) {
			$this->oCanonical = $this->findCanonical($sLanguageId);
		}
		return $this->oCanonical;
	}
	private function findCanonical($sLanguageId) {
		$oCanonical = $this->getCanonicalImpl($sLanguageId);
		if($oCanonical) {
			return $oCanonical;
		}
		if($this->getParent() === null) {
			return null;
		}
		$oParentCanonical = $this->getParent()->getCanonical();
		if(!$oParentCanonical) {
			return null;
		}
		return $oParentCanonical->namedChild($this->getName(), $sLanguageId, !$this->isEnabled(), !$this->isVisible());
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

	/**
	* @return Whether to include this navigation item in the search index
	*/
	public function isIndexed() {
		return true;
	}

	public function __sleep() {
		$aVars = (array) $this;
		unset($aVars["\0*\0oParent"]);
		unset($aVars["\0*\0oCanonical"]);
		unset($aVars["\0*\0aCustomChildren"]);
		unset($aVars["\0*\0aChildren"]);
		return array_keys($aVars);
	}
}
