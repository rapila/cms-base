<?php
/**
 * @package navigation
 */
class VirtualNavigationItem extends NavigationItem {
	private $sName;
	private $sTitle;
	private $sLinkText;
	private $mData;
	private $sType;
	private $oCanonical;
	public $bIsIndexed = true;

	/**
	 * @param string $sType Virtual identifier
	 * @param string $sName Page path name
	 * @param string $sTitle Page title
	 * @param string $sLinkText Page link text. Defaults to title.
	 * @param mixed $mData Additional data to be stored for later retrieval
	 */
	public function __construct($sType, $sName, $sTitle, $sLinkText = null, $mData = null, $oCanonical = null) {
		$this->sType = $sType;
		$this->sName = (string) $sName;
		$this->sTitle = $sTitle;
		$this->sLinkText = ($sLinkText === null ? $sTitle : $sLinkText);
		$this->mData = $mData;
		$this->oCanonical = $oCanonical;
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

	public function isActive() {
		if(!FrontendManager::$CURRENT_NAVIGATION_ITEM) {
			return null;
		}
		if(FrontendManager::$CURRENT_NAVIGATION_ITEM->getLevel() < $this->getLevel()) {
			return false;
		}
		for($oParent = FrontendManager::$CURRENT_NAVIGATION_ITEM;$oParent !== null;$oParent = $oParent->getParent()) {
			if($oParent === $this) {
				return true;
			}
		}
		return false;
	}

	public function isSiblingOfCurrent() {
		if(!FrontendManager::$CURRENT_NAVIGATION_ITEM) {
			return null;
		}
		if(FrontendManager::$CURRENT_NAVIGATION_ITEM->getLevel() !== $this->getLevel()) {
			return false;
		}
		return FrontendManager::$CURRENT_NAVIGATION_ITEM->getParent() === $this->getParent();
	}
	
	public function getData() {
		return $this->mData;
	}

	protected final function getIdImpl() {
		if($this->isRoot()) {
			return "";
		}
		return "{$this->oParent->getId()}/{$this->getName()}";
	}

	public function getPathId() {
		return "{$this->oParent->getIdImpl()}/{$this->getName()}";
	}

	public function hasData($mKey) {
		return isset($this->mData[$mKey]);
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
	
	protected function getCanonicalImpl($sLanguageId = null) {
		$this->oCanonical;
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
	
	public function isIndexed() {
		return $this->bIsIndexed;
	}
}
