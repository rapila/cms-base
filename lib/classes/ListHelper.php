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
  const SELECTION_TYPE_IS_NULL = 'is_null';
  //Be sure to handle manual selections in the criteria before calling handle()
  const SELECTION_TYPE_MANUAL = 'manual';
  
  private $sCallerClass;
  private $sModelName;
  private $sPeerClass;
  private $sSessionKey;
  private $sRequestPrefix;
  
  private $oSortHeaderTemplate;
  private $oSelectTemplate;

  private $aSelectionTypes = array();
  
  public function __construct($oCaller, $oSortHeaderTemplate = null, $oSelectTemplate = null) {
    $this->sCallerClass = get_class($oCaller);
    $this->sModelName = $oCaller->getModelName();
    $this->sPeerClass = $this->sModelName.'Peer';
    $this->sSessionKey = $this->sCallerClass.self::SESSION_SUFFIX;
    $this->sRequestPrefix = $this->sCallerClass.self::REQUEST_PREFIX;
    
    if($oSortHeaderTemplate === null) {
      global $LIST_HELPER_SORT_HEADER_TEMPLATE;
      $oSortHeaderTemplate = $LIST_HELPER_SORT_HEADER_TEMPLATE;
    }
    $this->oSortHeaderTemplate = $oSortHeaderTemplate;
    
    if($oSelectTemplate === null) {
      global $LIST_HELPER_SELECT_TEMPLATE;
      $oSelectTemplate = $LIST_HELPER_SELECT_TEMPLATE;
    }
    $this->oSelectTemplate = $oSelectTemplate;
    
    $this->prepareSort();
  }
  
  private function prepareSort() {
    $oListSettings = $this->getListSettings();
    if($this->hasRequestValue('sort_field')) {
      $oListSettings->addSortColumn($this->getRequestValue('sort_field'), $this->getRequestValue('sort_order'));
    }
  }
  
  public function getFilterSelect($sColumn, $aPossibleItems, $sIncludeAllString = null, $sIncludeWithoutString = null, $sSelectionType = null, $sKeyMethod = null, $mDefaultValue = null) {
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
    //Set the current value to the one that’s coming from the request (if any)
    if($this->hasRequestValue($sColumn)) {
      $oListSettings->setFilterColumnValue($sColumn, $this->getRequestValue($sColumn));
    }
    //Set selection type
    $this->aSelectionTypes[$sColumn] = $sSelectionType;
    $oSelectTemplate = clone $this->oSelectTemplate;
    $aAdditionalOptions = array();
    if($sIncludeAllString !== null) {
      $aAdditionalOptions[self::SELECT_ALL] = $sIncludeAllString;
    }
    if($sIncludeWithoutString !== null) {
      if($sSelectionType === self::SELECTION_TYPE_CONTAINS || $sSelectionType === self::SELECTION_TYPE_BEGINS) {
        throw new Exception("Exception in ListHelper->getFilterSelect() selection type$sSelectionType not supported to have a __without value");
      }
      $aAdditionalOptions[self::SELECT_WITHOUT] = $sIncludeWithoutString;
    }
    if($mDefaultValue === null) {
      $mDefaultValue = ArrayUtil::assocKeyPeek($aAdditionalOptions);
      if($mDefaultValue === null) {
        $mDefaultValue = ArrayUtil::assocKeyPeek($aPossibleItems);
      }
    }
    $sSelectedItem = $oListSettings->getFilterColumnValue($sColumn, $mDefaultValue);
    if($sSelectedItem !== self::SELECT_ALL && $sSelectedItem !== self::SELECT_WITHOUT && is_numeric($sSelectedItem)) {
      $sSelectedItem = (int) $sSelectedItem;
    }
    $oSelectTemplate->replaceIdentifier('name', self::normalizeRequestKey($sColumn));
    if($bListIsOfObjects) {
      $oSelectTemplate->replaceIdentifier('options', TagWriter::optionsFromObjects($aPossibleItems, $sKeyMethod, null, $sSelectedItem, $aAdditionalOptions, true));
    } else {
      $oSelectTemplate->replaceIdentifier('options', TagWriter::optionsFromArray($aPossibleItems, $sSelectedItem, '', $aAdditionalOptions, true));
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
  
  public function getSortColumn($sColumn, $sString = null, $bIsDefault = false, $sSortOrder = 'asc') {
    if($sString === null) {
      $sString = 'columns.'.$sColumn;
    }
    $oListSettings = $this->getListSettings();
    if($bIsDefault && count($oListSettings->aSorts) == 0) {
      $oListSettings->addSortColumn($sColumn, $sSortOrder);
    }
    $oSortItemTemplate = clone $this->oSortHeaderTemplate;
    $oCurrentSortValue = $oListSettings->getSortColumnValue($sColumn);
    $oSortItemTemplate->replaceIdentifier("sort_link", LinkUtil::linkToSelf(null, array(self::normalizeRequestKey('sort_field') => $sColumn, self::normalizeRequestKey('sort_order') => $oListSettings->isTopSort($sColumn) ? $oCurrentSortValue === 'asc' ? 'desc' : 'asc' : 'asc')));
    $oSortItemTemplate->replaceIdentifier("sort_class", $oListSettings->isTopSort($sColumn) ? $oCurrentSortValue : 'blind');
    $oSortItemTemplate->replaceIdentifier("sort_heading", StringPeer::getString($sString));
    return $oSortItemTemplate;
  }
  
  public function handle($oCriteria = null) {
    if($oCriteria === null) {
      $oCriteria = new Criteria();
    }
    $this->handleListSearching($oCriteria);
    $this->handleListSorting($oCriteria);
    $this->handleListFiltering($oCriteria);
    return $oCriteria;
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
      if($sFilterValue === self::SELECT_ALL || $this->aSelectionTypes[$sFilterColumn] === self::SELECTION_TYPE_MANUAL) {
        //Don’t confine
        continue;
      }
      $bInverted = $sFilterValue === self::SELECT_WITHOUT;
      $sFilterValue = $bInverted ? null : $sFilterValue;
      if($this->aSelectionTypes[$sFilterColumn] === self::SELECTION_TYPE_IS) {
        $oCriteria->add($sFilterColumn, $sFilterValue, Criteria::EQUAL);
      //LIKE criterias are not compatible with $bInverted == true
      } else if($this->aSelectionTypes[$sFilterColumn] === self::SELECTION_TYPE_BEGINS) {
        $oCriteria->add($sFilterColumn, "$sFilterValue%", Criteria::LIKE);
      } else if($this->aSelectionTypes[$sFilterColumn] === self::SELECTION_TYPE_CONTAINS) {
        $oCriteria->add($sFilterColumn, "%$sFilterValue%", Criteria::LIKE);
      } else if($this->aSelectionTypes[$sFilterColumn] === self::SELECTION_TYPE_IS_NULL) {
        if($sFilterValue) {
          $oCriteria->add($sFilterColumn, null, Criteria::ISNULL);
        } else {
          $oCriteria->add($sFilterColumn, null, Criteria::ISNOTNULL);
        }
      } else if($this->aSelectionTypes[$sFilterColumn] === self::SELECTION_TYPE_TAG) {
        $aTaggedItemIds = array();
        foreach(TagInstancePeer::getByModelNameAndTagName($this->sModelName, $sFilterValue) as $oTagInstance) {
          $aTaggedItemIds[] = $oTagInstance->getTaggedItemId();
        }
        $oCriteria->add($sFilterColumn, $aTaggedItemIds, $bInverted ? Criteria::NOT_IN : Criteria::IN);
      }
    }
  }
  
  public function getListSettings() {
    // @todo fix session problem accross applications. storage is too persistent, maybe add domain name
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