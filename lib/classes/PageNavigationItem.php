<?php
/**
 * @package navigation
 */
class PageNavigationItem extends NavigationItem {
	private $oMe;
	private $bIsCurrent;
	
	private static $NAVIGATION_ITEMS = array();
	
	public function __construct(Page $oMe, $oParent = null) {
		$this->oMe = $oMe;
		$this->bIsCurrent = null;
		parent::__construct($oParent);
	}
	
	public function getMe() {
		return $this->oMe;
	}
	
	public function getLevel() {
		$this->oMe->getLevel();
	}
	
	protected function getChildrenImpl($sLanguageId, $bIncludeDisabled, $bIncludeInvisible) {
		$aResult = array();
		foreach($this->oMe->getChildrenWith($sLanguageId, $bIncludeDisabled, $bIncludeInvisible) as $oPage) {
			$aResult[$oPage->getName()] = PageNavigationItem::navigationItemForPage($oPage, $this);
		}
		return $aResult;
	}
	
	protected function hasChildrenImpl($sLanguageId, $bIncludeDisabled, $bIncludeInvisible) {
		return $this->oMe->hasChildrenWith($sLanguageId, $bIncludeInvisible, $bIncludeInvisible);
	}
	
	public function isRoot() {
		return $this->oMe->isRoot();
	}
	
	public function isCurrent() {
		if($this->bIsCurrent === null) {
			return $this->oMe->getId() === FrontendManager::$CURRENT_PAGE->getId();
		}
		return $this->bIsCurrent;
	}
	
	public function setCurrent($bIsCurrent) {
		$this->bIsCurrent = $bIsCurrent;
	}
	
	public function isActive() {
		return $this->oMe->getLeftValue() <= FrontendManager::$CURRENT_PAGE->getLeftValue() && $this->oMe->getRightValue() >= FrontendManager::$CURRENT_PAGE->getRightValue();
	}
	
	public function isSiblingOfCurrent() {
		if($this->isRoot()) {
			return false;
		}
		if($this->oMe->getLevel() !== FrontendManager::$CURRENT_PAGE->getLevel()) {
			return false;
		}
		return $this->oMe->getParent()->getId() === FrontendManager::$CURRENT_PAGE->getParent()->getId();
	}
	
	public function getTitle($sLanguageId = null) {
		return $this->oMe->getActivePageString($sLanguageId)->getPageTitle();
	}
	
	public function getLinkText($sLanguageId = null) {
		return $this->oMe->getActivePageString($sLanguageId)->getLinkText();
	}
	
	public function getDescription($sLanguageId = null) {
		return $this->oMe->getActivePageString($sLanguageId)->getMetaDescription();
	}
	
	public function getIdentifier() {
		return $this->oMe->getIdentifier();
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
	
	public static function navigationItemForPage(Page $oPage, $oParent = null) {
		$sIdentifier = "{$oPage->getId()}";
		if(!isset(self::$NAVIGATION_ITEMS[$sIdentifier])) {
			self::$NAVIGATION_ITEMS[$sIdentifier] = new PageNavigationItem($oPage, $oParent);
		}
		return self::$NAVIGATION_ITEMS[$sIdentifier];
	}
}
