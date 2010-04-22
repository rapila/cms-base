<?php
require_once 'model/om/BasePage.php';

/**
 * @package model
 */	 
class Page extends BasePage {  
  
  const DELETE_NOT_ALLOWED_CODE = 11;
  const REFERENCE_EXISTS_CODE = 44;
  
  private $bIsActive = null;
  private $bIsRoot = null;
  
  private $aFullPathArray = null;
  
  public function getChildByName($sName) {
    $aChildren = $this->getChildren();
    foreach($aChildren as $oChild) {
      if($oChild->getName() === $sName) {
        return $oChild;
      }
    }
    return null;
  }

  public function getActivePageString($sLanguageId=null) {
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
        // FIXME getActivePageString in case of missing root page should be redirected to Form Page......
      }
      $oResult = $oResult[0];
    }
    return $oResult;
  }
  
  public function getConsolidatedKeywords($sLanguageId = null) {
    if($sLanguageId == null) {
      $sLanguageId = Session::language();
    }
    
    $aKeywords = array();
    $aKeywords[] = StringPeer::getString('meta.keywords', null, '');
    $aTags = TagPeer::tagInstancesForObject($this);
    foreach($aTags as $iKey => $oTag) {
      $aTags[$iKey] = $oTag->getTag()->getName();
    }
    $aKeywords[] = $aTags;
    $aKeywords[] = Settings::getSetting('frontend', 'keywords', '');
    $aKeywords[] = $this->getActivePageString()->getKeywords();
    
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
    
    return implode(', ', array_keys($aResult));
  }

  public function getNameMceIndented($sIndent = '_') {
    $sResult = '';
    if($this->getLevel() > 1) {
      for($i=1; $i<=($this->getLevel()-1); $i++) {
        $sResult .= $sIndent;
      }
    }
    return $sResult.$this->getName();
  }
  
  // getLanguageId is required by the relatedModule
  public function getLanguageId() {
    $oPageString = PageStringPeer::retrieveByPK($this->getId(), Session::language());
    if($oPageString !== null) {
      return $oPageString->getLanguageId();
    }
    return null;
  }

  public function getPageStringByLanguage($sLanguageId) {
    $aPageStrings = $this->getPageStrings();
    foreach($aPageStrings as $oPageString) {
      if($oPageString->getLanguageId() == $sLanguageId) {
        return $oPageString;
      }
    }
    return null;
  }

  public function getPageProperties() {
    return $this->getPagePropertys();
  }
  
  public function getPagePropertyByName($sPropertyName) {
    $oCriteria = new Criteria();
    $oCriteria->add(PagePropertyPeer::PAGE_ID, $this->getId());
    $oCriteria->add(PagePropertyPeer::NAME, $sPropertyName);
    return PagePropertyPeer::doSelectOne($oCriteria);
  }
  
  public function getPagePropertyValue($sPropertyName, $sDefaultValue = null) {
    $oProperty = $this->getPagePropertyByName($sPropertyName);
    if($oProperty) {
      return $oProperty->getValue();
    }
    return $sDefaultValue;
  }
  
  public function updatePageProperty($sPropertyName, $sPropertyValue) {
    $this->getPageProperties();
    $oTempProperty = $this->getPagePropertyByName($sPropertyName);
    if($oTempProperty !== null) {
      if($sPropertyValue === null) {
        $oTempProperty->delete();
        return;
      }
      $oTempProperty->setValue($sPropertyValue);
      $oTempProperty->save();
      return;
    } else if($sPropertyValue === null) {
      return;
    }
    $oTempProperty = new PageProperty();
    $oTempProperty->setName($sPropertyName);
    $oTempProperty->setValue($sPropertyValue);
    $this->addPageProperty($oTempProperty);
  }
  
  public function addTempPageProperty($sName, $sValue) {
    $this->getPageProperties();
    $oTempProperty = new PageProperty();
    $oTempProperty->setName($sName);
    $oTempProperty->setValue($sValue);
    $oTempProperty->bIsTemp = true;
    $this->addPageProperty($oTempProperty);
  }

  public function hasLanguage($sLanguageId) {
    return $this->getPageStringByLanguage($sLanguageId) !== null;
  }

  public function hasChildren($sLanguageId=null) {
    return count($this->getChildren($sLanguageId)) > 0;
  }

  public function getChildren($sLanguageId=null) {
    $aChildren;
    if($this->collPagesRelatedByParentId !== null) {
      $aChildren = $this->collPagesRelatedByParentId;
    } else {
      $aChildren = $this->getChildrenSortedBySort();
    }
    if($sLanguageId === null) {
      return $aChildren;
    }
    foreach($aChildren as $iKey => $oPage) {
      if($oPage->getPageStringByLanguage($sLanguageId) === null) {
        unset($aChildren[$iKey]);
      }
    }
    return $aChildren;
  }

  private function getChildrenSortedBySort() {
    $oCriteria = new Criteria();
    $oCriteria->addAscendingOrderByColumn(PagePeer::SORT);
    $aResult = $this->getPagesRelatedByParentId($oCriteria);
    foreach($aResult as $oPage) {
      $oPage->aPageRelatedByParentId = $this;
    }
    return $aResult;
  }

  public function getEnabledChildren($sLanguageId=null) {
    $aChildren = $this->getChildren();
    $aResult = array();
    foreach($aChildren as $oPage) {
      if(!$oPage->getIsInactive() && ($sLanguageId === null || $oPage->getPageStringByLanguage($sLanguageId) !== null)) {
        $aResult[] = $oPage;
      }
    }
    return $aResult;
  }

  public function getVisibleChildren($sLanguageId=null) {
    $aChildren = $this->getChildren();
    $aResult = array();
    foreach($aChildren as $oPage) {
      if(!$oPage->getIsHidden() && ($sLanguageId === null || $oPage->getPageStringByLanguage($sLanguageId) !== null)) {
        $aResult[] = $oPage;
      }
    }
    return $aResult;
  }

  public function getEnabledAndVisibleChildren($sLanguageId=null) {
    $aChildren = $this->getChildren();
    $aResult = array();
    foreach($aChildren as $oPage) {
      if(!$oPage->getIsInactive() && !$oPage->getIsHidden() && ($sLanguageId === null || $oPage->getPageStringByLanguage($sLanguageId) !== null)) {
        $aResult[] = $oPage;
      }
    }
    return $aResult;
  }

  public function hasEnabledChildren($sLanguageId=null) {
    return count($this->getEnabledChildren($sLanguageId)) > 0;
  }

  public function hasVisibleChildren($sLanguageId=null) {
    return count($this->getVisibleChildren($sLanguageId)) > 0;
  }

  public function hasEnabledAndVisibleChildren($sLanguageId=null) {
    return count($this->getEnabledAndVisibleChildren($sLanguageId)) > 0;
  }

  public function getChildrenWithLanguage($sLanguageId) {
    $aChildren = $this->getChildren();
    $aResult = array();
    foreach($aChildren as $oChild) {
      if($oChild->hasLanguage($sLanguageId)) {
        $aResult[] = $oChild;
      }
    }
    return $aResult;
  }

  public function getChildrenWithCurrentLanguage() {
    return $this->getChildrenWithLanguage(Session::language());
  }

  public function getParent() {
    if($this->isRoot()) {
      return null;
    }
    return $this->getPageRelatedByParentId();
  }

  public function isCurrent() {
    $oCurrentPage = Manager::getCurrentPage();
    if($oCurrentPage == null) {
      return false;
    }
    return $oCurrentPage->getId() === $this->getId();
  }

  public function isFolder() {
    return $this->getIsFolder();
  }

  public function isChildOfCurrent() {
    if($this->getParent() === null) {
      return false;
    }
    return $this->getParent()->isCurrent();
  }

  public function isDescendantOfCurrent() {
    $oActive=$this;
    while(null !== ($oActive=$oActive->getParent())) {
      if($oActive->isCurrent()) {
        return true;
      }
    }
    return false;
  }
  
  public function getSiblings($bSiblingsOnly=true) {
    $oParent = $this->getParent();
    if($oParent == null) {
      return array();
    }
    $aResult = $oParent->getChildren();
    if($bSiblingsOnly) {
      foreach($aResult as $iKey => $oPossibleSibling) {
        if($oPossibleSibling->getId() === $this->getId()) {
          unset($aResult[$iKey]);
          break;
        }
      }
    }
    return $aResult;
  }

  public function isSiblingOfCurrent() {
    foreach($this->getSiblings() as $oSibling) {
      if($oSibling->isCurrent()) {
        return true;
      }
    }
    return false;
  }

  public function isSiblingOfActive() {
    foreach($this->getSiblings() as $oSibling) {
      if($oSibling->isActive()) {
        return true;
      }
    }
    return false;
  }

  public function isActive() {
    if($this->bIsActive !== null) {
      return $this->bIsActive;
    }
    if($this->isCurrent()) {
      return $this->bIsActive = true;
    }
    foreach($this->getChildren() as $oChild) {
      if($oChild->isActive()) {
        return $this->bIsActive = true;
      }
    }
    $this->bIsActive = false;
    return false;
  }

  public function isRoot() {
    if($this->bIsRoot !== null) {
      return $this->bIsRoot;
    }
    if($this->getPageRelatedByParentId() === null) {
      $this->bIsRoot = true;
    } else {
      $this->bIsRoot = false;
    }
    return $this->bIsRoot;
  }
  
  public function isLoginPage() {
    return $this->isOfType('login');
  }
  
  public function isOfType($sType) {
    return $this->getPageType() === $sType;
  }

  public function getLevel() {
    $iResult = 0;
    $oParent = $this->getParent();
    while($oParent !== null) {
      $iResult++;
      $oParent = $oParent->getParent();
    }
    return $iResult;
  }

  public function getLongTitle($sLanguageId=null) {
    throw new Exception("Warning: used deprecated method Page->getLongTitle()");
  }

  public function getTitle($sLanguageId=null) {
    throw new Exception("Warning: used deprecated method Page->getTitle()");
  }

  public function getLinkText($sLanguageId=null) {
    $oActivePageString = $this->getActivePageString($sLanguageId);
    if($oActivePageString !== null) {
      return $oActivePageString->getLinkText();
    }
    return null;
  }
  
  public function getLinkTextIfExists($sLanguageId=null) {
    if ($this->getLinkText($sLanguageId)) {
      return $this->getLinkText($sLanguageId);
    }
    return $this->getName();
  }

  public function getLinkTextOnly($sLanguageId=null) {
    $oActivePageString = $this->getActivePageString($sLanguageId);
    if($oActivePageString !== null) {
      return $oActivePageString->getLinkTextOnly();
    }
    return null;
  }

  public function getPageTitle($sLanguageId=null) {
    $oActivePageString = $this->getActivePageString($sLanguageId);
    if($oActivePageString !== null) {
      return $oActivePageString->getPageTitle();
    }
    return null;
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
  
  public function getObjectsForContainer($sContainerName) {
    $oCrit = $this->getObjectsForContainerCriteria($sContainerName);
    $oCrit->addAscendingOrderByColumn(ContentObjectPeer::SORT);
    $oCrit->addAscendingOrderByColumn(ContentObjectPeer::ID);
    return $this->getContentObjects($oCrit);
  }

  public function countObjectsForContainer($sContainerName) {
    return $this->countContentObjects($this->getObjectsForContainerCriteria($sContainerName));
  }

  public function getFirstChild() {
    $aAllChildren = $this->getChildren();
    if(isset($aAllChildren[0])) {
      return $aAllChildren[0];
    }
    return null;
  }
  
  public function getFirstEnabledChild($sLanguageId=null, $iLevel=0) {
    $aAllChildren = $this->getEnabledChildren($sLanguageId);
    if(isset($aAllChildren[0])) {
      if(!$aAllChildren[0]->getIsFolder()) {
        return $aAllChildren[0];
      }
      return $aAllChildren[0]->getFirstEnabledChild($sLanguageId, $iLevel+1);
    }
    return null;
  }

  public function getFullPathArray() {
    if(!$this->aFullPathArray) {
      $this->aFullPathArray = array();
      $oActive = $this;
      while($oActive->getParent() !== null) {
        array_unshift($this->aFullPathArray, $oActive->getName());
        $oActive = $oActive->getParent();
      }
    }
    return $this->aFullPathArray;
  }

  /**
  * @deprecated Use getFullPathArray() instead
  */
  public function getFullPath() {
    return implode("/", $this->getFullPathArray());
  }
  
  /**
  * Alias of getFullPathArray()
  * @deprecated Use getFullPathArray() for clarity
  */
  public function getLink() {
    return $this->getFullPathArray();
  }
  
  public function getTopNavigationPage() {
    $oRootPage = PagePeer::getRootPage();
    if($oRootPage->isCurrent()) {
      return $oRootPage;
    }
    foreach($oRootPage->getChildren() as $oPage) {
      if($oPage->isActive()) {
        return $oPage;
      }
    }
    throw new Exception("Exception in Page->getTopNavigationName(): rootPage is not current but no child is active");
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
      $oCriteria = new Criteria();
      $oCriteria->add(PagePeer::IS_INACTIVE, false);
      $oCriteria->add(PagePeer::PAGE_TYPE, $sPageType);
      return PagePeer::doSelectOne($oCriteria);
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

  public function getTopNavigationName($bNameNotTitle = true) {
    $oPage = $this->getTopNavigationPage();
    if($oPage) {
      return ($bNameNotTitle ? $oPage->getName() : $oPage->getLinkText());
    }
    throw new Exception("Exception in Page->getTopNavigationName(): rootPage is not current but no child is active");
  }

  public function getTree($bNameOnly=false, $iLevel=0) {
    $aResults = array();
    if($bNameOnly) {
      $aResults[$this->getId()]['value'] = $this->getName();
      $aResults[$this->getId()]['level'] = $iLevel;
    } else {
      $aResults[$this->getId()] = $this;
    }
    foreach($this->getChildren() as $oChild) {
      $aResults = ($aResults + $oChild->getTree($bNameOnly, $oChild->getLevel()));
    }
    return $aResults;
  }

  public function delete(PropelPDO $con = null) {
    if($this->hasChildren() && !Settings::getSetting('backend','delete_pagetree_enable', false)) {
      throw new Exception('Pages with children are not allowed to be deleted', self::DELETE_NOT_ALLOWED_CODE);
    } else {
      if(ReferencePeer::hasReference($this)) {
        throw new Exception("Exception in ".__METHOD__.": tried removing an instance from the database even though it is still referenced.", self::REFERENCE_EXISTS_CODE);
      }
      TagPeer::deleteTagsForObject($this);
      ReferencePeer::removeReferences($this);
      return parent::delete($con);
    }
  }
  
  public function deletePageAndDescendants() {
    if($this->hasChildren()) {
      foreach($this->getChildren() as $oPage) {
        $oPage->deletePageAndDescendants();
      }
    }
    $this->delete();
  }
}
