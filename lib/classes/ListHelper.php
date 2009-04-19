<?php
/**
* @package utils
*/

global $LIST_HELPER_SORT_HEADER_TEMPLATE;
$LIST_HELPER_SORT_HEADER_TEMPLATE = new Template('<a href="{{sort_link}}" class="sort_{{sort_class}}">{{sort_heading}}</a>', null, true);
global $LIST_HELPER_SELECT_TEMPLATE;
$LIST_HELPER_SELECT_TEMPLATE = new Template('<form action="{{writeLink=to_self;ignore_request=true}}" method="get"><select onchange="$(this).up(\'form\').submit();" name="{{name}}">{{options}}</select></form>', null, true);

class ListHelper {
  const SELECT_ALL = '__all';
  const SELECT_WITHOUT = '__without';
  
  const SESSION_SUFFIX = '_list_storage';
  const REQUEST_PREFIX = '_list_storage_';
  
  const SELECTION_TYPE_IS = 'is';
  const SELECTION_TYPE_BEGINS = 'begins';
  const SELECTION_TYPE_CONTAINS = 'contains';
  const SELECTION_TYPE_TAG = 'tag';
  
  private $sCallerClass;
  private $sModelName;
  private $sPeerClass;
  private $sSessionKey;
  private $sRequestPrefix;

  private $aSelectionTypes = array();
  
  public function __construct($oCaller) {
    $this->sCallerClass = get_class($oCaller);
    $this->sModelName = $oCaller->getModelName();
    $this->sPeerClass = $this->sModelName.'Peer';
    $this->sSessionKey = $this->sCallerClass.self::SESSION_SUFFIX;
    $this->sRequestPrefix = $this->sCallerClass.self::REQUEST_PREFIX;
    
    $this->prepareSort();
  }
  
  private function prepareSort() {
    $oListSettings = $this->getListSettings();
    if($this->hasRequestValue('sort_field')) {
      $oListSettings->addSortColumn($this->getRequestValue('sort_field'), $this->getRequestValue('sort_order'));
    }
  }
  
  public function getFilterSelect($sColumn, $aPossibleItems, $sIncludeAllString = null, $sIncludeWithoutString = null, $sSelectionType = null, $sKeyMethod = null) {
    if($sSelectionType === null) {
      $sSelectionType = self::SELECTION_TYPE_IS;
    }
    $oListSettings = $this->getListSettings();
    $bListIsOfObjects = false;
    if(count($aPossibleItems) === 0) {
      $oListSettings->setFilterColumnValue($sColumn, self::SELECT_ALL);
      return null;
    } else {
      //If list is of objects, options must be created using optionsFromObjects, else optionsFromArray
      $bListIsOfObjects = is_object(ArrayUtil::assocPeek($aPossibleItems));
    }
    if($this->hasRequestValue($sColumn)) {
      $oListSettings->setFilterColumnValue($sColumn, $this->getRequestValue($sColumn));
    }
    //Set selection type
    $this->aSelectionTypes[$sColumn] = $sSelectionType;
    
    $sSelectedItem = $oListSettings->getFilterColumnValue($sColumn);
    global $LIST_HELPER_SELECT_TEMPLATE;
    $oSelectTemplate = clone $LIST_HELPER_SELECT_TEMPLATE;
    $aAdditionalOptions = array();
    if($sIncludeAllString !== null) {
      $aAdditionalOptions[self::SELECT_ALL] = $sIncludeAllString;
    }
    if($sIncludeWithoutString !== null) {
      $aAdditionalOptions[self::SELECT_WITHOUT] = $sIncludeWithoutString;
    }
    if($sSelectedItem !== self::SELECT_ALL && $sSelectedItem !== self::SELECT_WITHOUT && is_numeric($sSelectedItem)) {
      $sSelectedItem = (int) $sSelectedItem;
    }
    $oSelectTemplate->replaceIdentifier('name', self::normalizeRequestKey($sColumn));
    if($bListIsOfObjects) {
      $oSelectTemplate->replaceIdentifier('options', TagWriter::optionsFromObjects($aPossibleItems, $sKeyMethod, null, $sSelectedItem, $aAdditionalOptions));
    } else {
      $oSelectTemplate->replaceIdentifier('options', TagWriter::optionsFromArray($aPossibleItems, $sSelectedItem, '', $aAdditionalOptions));
    }
    return $oSelectTemplate;
  }
  
  public function getFilterSelectForTagFilter($sColumn = null) {
    if($sColumn === null) {
      $sColumn = constant($this->sPeerClass.'::ID');
    }
    $aTagsUsedInModel = TagPeer::getTagsUsedInModel($this->sModelName);
    
    // @todo needs to be generic
    return $this->getFilterSelect($sColumn, $aTagsUsedInModel, StringPeer::getString('all_entries'), StringPeer::getString('link.without_tags'), self::SELECTION_TYPE_TAG, 'getName');
  }
  
  public function getSortColumn($sColumn, $sString = null, $bIsDefault = false) {
    if($sString === null) {
      $sString = 'columns.'.$sColumn;
    }
    $oListSettings = $this->getListSettings();
    if($bIsDefault && count($oListSettings->aSorts) == 0) {
      $oListSettings->addSortColumn($sColumn, 'asc');
    }
    global $LIST_HELPER_SORT_HEADER_TEMPLATE;
    $oSortItemTemplate = clone $LIST_HELPER_SORT_HEADER_TEMPLATE;
    $oCurrentSortValue = $oListSettings->getSortColumnValue($sColumn);
    $oSortItemTemplate->replaceIdentifier("sort_link", LinkUtil::linkToSelf(null, array(self::normalizeRequestKey('sort_field') => $sColumn, self::normalizeRequestKey('sort_order') => $oListSettings->isTopSort($sColumn) ? $oCurrentSortValue === 'asc' ? 'desc' : 'asc' : 'asc')));
    $oSortItemTemplate->replaceIdentifier("sort_class", $oListSettings->isTopSort($sColumn) ? $oCurrentSortValue : 'blind');
    $oSortItemTemplate->replaceIdentifier("sort_heading", StringPeer::getString($sString));
    return $oSortItemTemplate;
  }
  
  public function handle($oCriteria) {
    $this->handleListSearching($oCriteria);
    $this->handleListSorting($oCriteria);
    $this->handleListFiltering($oCriteria);
  }
  
  private function handleListSearching($oCriteria) {
    $oListSettings = $this->getListSettings();
    if(isset($_REQUEST['search'])) {
      $oListSettings->setSearchPhrase($_REQUEST['search']);
    }
    if($oListSettings->getSearchPhrase() === null) {
      return;
    }
    call_user_func(array($this->sPeerClass, 'addSearchToCriteria'), $oListSettings->getSearchPhrase(), $oCriteria);
    $_REQUEST['search'] = $oListSettings->getSearchPhrase();
  }
  
  private function handleListSorting($oCriteria) {
    $oListSettings = $this->getListSettings();
    foreach($oListSettings->aSorts as $sSortColumn => $sSortOrder) {
      $sMethod = 'add'.ucfirst(strtolower($sSortOrder)).'endingOrderByColumn';
      $oCriteria->$sMethod($sSortColumn);
    }
  }
  
  private function handleListFiltering($oCriteria, $aParams=array()) {
    $oListSettings = $this->getListSettings();
    foreach($oListSettings->aFilters as $sFilterColumn => $sFilterValue) {
      if($sFilterValue === self::SELECT_ALL) {
        //Don’t confine
        continue;
      }
      $bInverted = $sFilterValue === self::SELECT_WITHOUT;
      if($this->aSelectionTypes[$sFilterColumn] === self::SELECTION_TYPE_IS) {
        $oCriteria->add($sFilterColumn, $sFilterValue, $bInverted ? Criteria::NOT_EQUAL : Criteria::EQUAL);
        // @todo somekind of callback for special criterias
        if(count($aParams) > 0 && isset($aParams['extract_boolean'])) {
          // special handling for mixed, hacked selects like butti section boolean is_archive
          // do something to extract boolean from value and fix value
        }
      } else if($this->aSelectionTypes[$sFilterColumn] === self::SELECTION_TYPE_BEGINS) {
        $oCriteria->add($sFilterColumn, "$sFilterValue%", $bInverted ? Criteria::NOT_LIKE : Criteria::LIKE);
      } else if($this->aSelectionTypes[$sFilterColumn] === self::SELECTION_TYPE_CONTAINS) {
        $oCriteria->add($sFilterColumn, "%$sFilterValue%", $bInverted ? Criteria::NOT_LIKE : Criteria::LIKE);
      } else if($this->aSelectionTypes[$sFilterColumn] === self::SELECTION_TYPE_TAG) {
        $aTaggedItemIds = array();
        // @todo check fixed: if invert, then $sFilterValue should be null
        $sFilterValue = $bInverted ? null : $sFilterValue;
        foreach(TagInstancePeer::getByModelNameAndTagName($this->sModelName, $sFilterValue) as $oTagInstance) {
          $aTaggedItemIds[] = $oTagInstance->getTaggedItemId();
        }
        $oCriteria->add($sFilterColumn, $aTaggedItemIds, $bInverted ? Criteria::NOT_IN : Criteria::IN);
      }
    }
  }
  
  public function getListSettings() {
    $oSession = Session::getSession();
    if(!$oSession->hasAttribute($this->sSessionKey)) {
      $oSession->setAttribute($this->sSessionKey, new ListSettings());
    }
    return $oSession->getAttribute($this->sSessionKey);
  }
  
  public function getRequestValue($sKey) {
    return $_REQUEST[self::normalizeRequestKey($sKey)];
  }
  
  public function hasRequestValue($sKey) {
    return isset($_REQUEST[self::normalizeRequestKey($sKey)]);
  }
  
  public function normalizeRequestKey($sKey) {
    return StringUtil::normalize($this->sRequestPrefix.$sKey);
  }
}