<?php
require_once 'model/om/BasePage.php';

/**
 * @package model
 */
class Page extends BasePage {

	const DELETE_NOT_ALLOWED_CODE = 11;
	const REFERENCE_EXISTS_CODE = 44;
	
	private $aStrings = array();

	private $aFullPathArray = null;

	///Stores the “old” parent (before move operations)
	private $oOldParent = null;

	public function setName($sName) {
		parent::setName(StringUtil::normalizePath($sName, false));
	}

	public function getChildByName($sName) {
		$oPage = PageQuery::create()->childrenOf($this)->filterByName($sName)->findOne();
		if($oPage === null) {
			return null;
		}
		$oPage->aNestedSetParent = $this;
		return $oPage;
	}

	public function getActivePageString($sLanguageId = null) {
		if($sLanguageId === null) {
			$sLanguageId = Session::language();
		}
		$oResult = $this->getPageStringByLanguage($sLanguageId);
		if($oResult === null) {
			$oResult = $this->getPageStringByLanguage(Settings::getSetting("session_default", Session::SESSION_LANGUAGE_KEY, null));
		}
		if($oResult === null) {
			$oResult = $this->getPageStrings();
			if(count($oResult) === 0) {
				throw new Exception("No PageString defined for Page ".$this->getName());
				// FIXME getActivePageString in case of missing root page should be redirected to Form Page…
			}
			$oResult = $oResult[0];
		}
		return $oResult;
	}

	public function getDescription($sLanguageId = null) {
		if($sLocalDescription = $this->getActivePageString($sLanguageId)->getMetaDescription()) {
			return $sLocalDescription;
		}
		return TranslationPeer::getString('meta.description', $sLanguageId, '');
	}

	public function getConsolidatedKeywords($sLanguageId = null, $bReturnArray = false) {
		if($sLanguageId == null) {
			$sLanguageId = Session::language();
		}

		$aKeywords = array();
		$aKeywords[] = TranslationPeer::getString('meta.keywords', null, '');
		$aTags = TagPeer::tagInstancesForObject($this);
		foreach($aTags as $iKey => $oTag) {
			$aTags[$iKey] = $oTag->getTag()->getName();
		}
		$aKeywords[] = $aTags;
		$aKeywords[] = Settings::getSetting('frontend', 'keywords', '');
		$aKeywords[] = $this->getActivePageString()->getMetaKeywords();
		$aResult = array();

		foreach($aKeywords as $iKey => $mKeywords) {
			if(!is_array($mKeywords)) {
				$mKeywords = explode(',', $mKeywords);
			}

			foreach($mKeywords as $sKeyword) {
				$sKeyword = trim($sKeyword);
				if(!isset($aResult[$sKeyword]) && $sKeyword !== '') {
					$aResult[$sKeyword] = true;
				}
			}
		}

		if($bReturnArray) {
			return array_keys($aResult);
		}

		return implode(', ', array_keys($aResult));
	}

	public function getPageStringByLanguage($sLanguageId) {
		if(!isset($this->aStrings[$sLanguageId])) {
			$this->aStrings[$sLanguageId] = PageStringQuery::create()->filterByPage($this)->filterByLanguageId($sLanguageId)->findOne();
		}
		return $this->aStrings[$sLanguageId];
	}

	public function hasPageStringByLanguage($sLanguageId, $bOnlyActive = true) {
		$oString = $this->getPageStringByLanguage($sLanguageId);
		if(!$oString) {
			return false;
		}
		if($bOnlyActive && $oString->getIsInactive()) {
			return false;
		}
		return true;
	}

	/**
	* @deprecated use getPagePropertyQuery() instead
	*/
	public function getPageProperties() {
		return $this->getPagePropertys();
	}

	public function getPagePropertyQuery() {
		return PagePropertyQuery::create()->filterByPage($this);
	}

	public function getPagePropertyByName($sPropertyName) {
	  return $this->getPagePropertyQuery()->filterByName($sPropertyName)->findOne();
	}

	public function getPagePropertyValue($sPropertyName, $sDefaultValue = null) {
		$oProperty = $this->getPagePropertyByName($sPropertyName);
		if($oProperty) {
			return $oProperty->getValue();
		}
		return $sDefaultValue;
	}

	/**
	* Updated page properties: changes them if they exist and creates them otherwise.
	* @param $sPropertyName the property name
	* @param $sPropertyValue the new value. Set null if you wish to remove the property
	*/
	public function updatePageProperty($sPropertyName, $sPropertyValue) {
		$oTempProperty = $this->getPagePropertyByName($sPropertyName);
		if($oTempProperty !== null) {
			if($sPropertyValue === null || $sPropertyValue === '') {
				$oTempProperty->delete();
				return;
			}
			$oTempProperty->setValue($sPropertyValue);
			$oTempProperty->save();
			return;
		} else if($sPropertyValue === null || $sPropertyValue === '') {
			return;
		}
		$oTempProperty = new PageProperty();
		$oTempProperty->setName($sPropertyName);
		$oTempProperty->setValue($sPropertyValue);
		$oTempProperty->setPage($this);
		$this->addPageProperty($oTempProperty);
		$oTempProperty->save();
	}

	/**
	* Add a temporary page property to the page for the duration of the request.
	*/
	public function addTempPageProperty($sName, $sValue) {
		// Make sure the page properties are loaded so we won’t override them later on
		$this->getPageProperties();
		$oTempProperty = new PageProperty();
		$oTempProperty->setName($sName);
		$oTempProperty->setValue($sValue);
		$oTempProperty->bIsTemp = true;
		$this->addPageProperty($oTempProperty);
	}

	public function getChildren($oCriteria = null, PropelPDO $oConnection = null) {
		if($oCriteria !== null) {
			$aResult = parent::getChildren($oCriteria, $oConnection);
			foreach($aResult as $oChild) {
				$oChild->aNestedSetParent = $this;
			}
			return $aResult;
		}
		if($this->collNestedSetChildren === null) {
			parent::getChildren($oCriteria, $oConnection);
			foreach($this->collNestedSetChildren as $oChild) {
				$oChild->aNestedSetParent = $this;
			}
		}
		return $this->collNestedSetChildren;
	}

	public function getChildrenWith($sLanguageId = null, $bIncludeDisabled = false, $bIncludeInvisible = false) {
		$oCriteria = PageQuery::create();
		if(!$bIncludeDisabled) {
			$oCriteria->filterByIsInactive(false);
		}
		if(!$bIncludeInvisible) {
			$oCriteria->filterByIsHidden(false);
		}
		if($sLanguageId !== null) {
			$oCriteria->joinPageString();
			$oCriteria->add(PageStringPeer::LANGUAGE_ID, $sLanguageId);
			if(!$bIncludeDisabled) {
			  $oCriteria->add(PageStringPeer::IS_INACTIVE, false);
			}
		}
		return $this->getChildren($oCriteria);
	}

	public function countChildrenWith($sLanguageId = null, $bIncludeDisabled = false, $bIncludeInvisible = false) {
		$oCriteria = PageQuery::create();
		if(!$bIncludeDisabled) {
			$oCriteria->filterByIsInactive(false);
		}
		if(!$bIncludeInvisible) {
			$oCriteria->filterByIsHidden(false);
		}
		if($sLanguageId !== null) {
			$oCriteria->joinPageString();
			$oCriteria->add(PageStringPeer::LANGUAGE_ID, $sLanguageId);
		}
		return $this->countChildren($oCriteria);
	}

	public function hasChildrenWith($sLanguageId = null, $bIncludeDisabled = false, $bIncludeInvisible = false) {
		return $this->countChildrenWith($sLanguageId, $bIncludeDisabled, $bIncludeInvisible) > 0;
	}

	public function isFolder() {
		return $this->getIsFolder();
	}

	public function isLoginPage() {
		return $this->isOfType('login');
	}

	public function isOfType($sType) {
		return $this->getPageType() === $sType;
	}

	public function getLoginPage() {
		return $this->getPageOfType('login');
	}

	public function getPageOfType($sPageType) {
		if($this->isOfType($sPageType)) {
			return $this;
		}
		foreach($this->getChildren() as $oChild) {
			if($oChild->isOfType($sPageType)) {
				return $oChild;
			}
		}
		if($this->isRoot()) {
			return PageQuery::create()->active()->filterByPageType($sPageType)->findOne();
		}
		return $this->getParent()->getPageOfType($sPageType);
	}

	public function getPageOfName($sName) {
		if($this->getName() === $sName) {
			return $this;
		}
		foreach($this->getChildren() as $oChild) {
			if($oChild->getName() === $sName) {
				return $oChild;
			}
		}
		if($this->isRoot()) {
			return $this->getName() === $sName ? $this : null;
		}
		return $this->getParent()->getPageOfName($sName);
	}

	public function getLinkText($sLanguageId = null) {
		$oActivePageString = $this->getActivePageString($sLanguageId);
		if($oActivePageString !== null) {
			return $oActivePageString->getLinkText();
		}
		return $this->getName();
	}

	public function getPageTitle($sLanguageId = null) {
		$oActivePageString = $this->getActivePageString($sLanguageId);
		if($oActivePageString !== null) {
			return $oActivePageString->getPageTitle();
		}
		return $this->getName();
	}

	public function getTemplateNameUsed() {
		return Settings::getSettingIf($this->getTemplateName(), "frontend", "main_template", "index");
	}

	public function getTemplate($bDirectOutput = false) {
		return new Template($this->getTemplateNameUsed(), null, false, $bDirectOutput);
	}

	public function getObjectsForContainerCriteria($sContainerName) {
		$oCrit = new Criteria();
		$oCrit->add(ContentObjectPeer::CONTAINER_NAME, $sContainerName);
		return $oCrit;
	}

	public function getObjectsForContainer($sContainerName, $mEqualHigherSort=null, $bSortAsc = false) {
		$oCrit = $this->getObjectsForContainerCriteria($sContainerName);
		if($mEqualHigherSort) {
			$oCrit->add(ContentObjectPeer::SORT, $mEqualHigherSort, Criteria::GREATER_EQUAL);
		}
		$oCrit->addAscendingOrderByColumn(ContentObjectPeer::SORT);
		if($bSortAsc) {
			$oCrit->addAscendingOrderByColumn(ContentObjectPeer::UPDATED_AT);
		} else {
			$oCrit->addDescendingOrderByColumn(ContentObjectPeer::UPDATED_AT);
		}
		return $this->getContentObjects($oCrit);
	}

	public function countObjectsForContainer($sContainerName) {
		return $this->countContentObjects($this->getObjectsForContainerCriteria($sContainerName));
	}

	public function getFirstEnabledChild($sLanguageId=null, $iLevel=0) {
		$aAllChildren = $this->getChildrenWith($sLanguageId, false, true);
		if(isset($aAllChildren[0])) {
			if(!$aAllChildren[0]->getIsFolder()) {
				return $aAllChildren[0];
			}
			return $aAllChildren[0]->getFirstEnabledChild($sLanguageId, $iLevel+1);
		}
		return null;
	}

	public function shouldBeIncludedInList($sLanguageId, $oPage) {
		return $oPage === null || $this->getId() !== $oPage->getId();
	}

	public function renderListItem($oTemplate) {
		$oTemplate->replaceIdentifier("id", $this->getId());
		$oTemplate->replaceIdentifier("name", $this->getName());
		$oTemplate->replaceIdentifier("link_text", $this->getLinkText());
		$oTemplate->replaceIdentifier("title", $this->getPageTitle());
		$oTemplate->replaceIdentifier("description", $this->getPageTitle());
		$oTemplate->replaceIdentifier("url", LinkUtil::link($this->getFullPathArray(), 'FrontendManager'));
	}

	/**
	* Returns the path leading to this page.
	* @param array $aSubpages An array to append to the output
	*/
	public function getFullPathArray(array $aSubpages = array()) {
		if(!$this->aFullPathArray) {
			$this->aFullPathArray = array();
			$oActive = $this;
			while($oActive->getParent() !== null) {
				array_unshift($this->aFullPathArray, $oActive->getName());
				$oActive = $oActive->getParent();
			}
		}
		return array_merge($this->aFullPathArray, $aSubpages);
	}

	/**
	* Alias of getFullPathArray()
	* @deprecated Use getFullPathArray() for clarity
	*/
	public function getLink() {
		return $this->getFullPathArray();
	}

	/**
	* Exploded alias of getFullPathArray(). All params given to this method will be passed as the first parameter of getFullPathArray.
	*/
	public function getLinkArray() {
		return $this->getFullPathArray(func_get_args());
	}

	public function getCanonical() {
		return $this->getPageRelatedByCanonicalId();
	}

	public function deletePageAndDescendants() {
		if($this->hasChildren()) {
			foreach($this->getChildren() as $oPage) {
				$oPage->deletePageAndDescendants();
			}
		}
		$this->delete();
	}

	// Override moveSubtreeTo to store the old parent
	protected function moveSubtreeTo($destLeft, $levelDelta, PropelPDO $con = null) {
		$oOldParent = $this->getParent($con);
		$oNewParent = PageQuery::create()->filterByTreeLeft($destLeft, Criteria::LESS_THAN)->filterByTreeRight($destLeft, Criteria::GREATER_EQUAL)->filterByTreeLevel($this->getLevel()+$levelDelta-1)->findOne();
		// Copied from denyable behavior
		if(!(PagePeer::isIgnoringRights() || $this->mayMoveFromTo($oOldParent, $oNewParent))) {
			throw new PropelException(new NotPermittedException("move.custom.pages", array("role_key" => "pages")));
		}
		return parent::moveSubtreeTo($destLeft, $levelDelta, $con);
	}

	private function mayMoveFromTo($oFrom, $oTo) {
		// When moving pages, the user must have rights to both source and destination
		$oUser = Session::getSession()->getUser();
		if(!$oUser->mayCreateChildren($oFrom)) {
			return false;
		}
		if($oTo === null) {
			//Only admins may create root pages
			return false;
		}
		return $oUser->mayCreateChildren($oTo);
	}

	public function getOldParent() {
		return $this->oOldParent;
	}
	
	public function executeActionActivate() {
		$this->setIsInactive(false);
		$this->save();
	}

	public static function describeActionActivate() {
		return ActionDescriptor::create('page.activate');
	}
	
	public function executeActionActivateLanguage(ScheduledAction $oAction, $sLanguageId = null, $bActivatePageAsWell) {
		$oQuery = PageStringQuery::create()->filterByPageId($this->getId());
		if($sLanguageId) {
			$oQuery->filterByLanguageId($sLanguageId);
		}
		foreach($oQuery->find() as $oPageString) {
			$oPageString->setIsInactive(false);
			$oPageString->save();
		}
		if($bActivatePageAsWell) {
			$this->executeActionActivate($oAction);
		}
	}

	public static function describeActionActivateLanguage() {
		$oLanguageChoices = ActionParameterChoiceType::create();
		foreach(LanguagePeer::getLanguagesAssoc(true, true) as $sLanguageId => $sLanguageName) {
			$oLanguageChoices->addChoice($sLanguageName, $sLanguageId);
		}
		return ActionDescriptor::create('page.activate_language')
			->addParameter(ActionParameterDescriptor::create($oLanguageChoices, 'page.activate_language.language')->allowNull())
			->addParameter(ActionParameterDescriptor::create(ActionParameterBooleanType::create(), 'page.activate_language.page_too')->withDefaultValue(true));
	}
}
