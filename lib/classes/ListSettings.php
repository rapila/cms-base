<?php
/**
* @package utils
*/

class ListSettings {
  private $sSearchPhrase = null;
  public $aSorts = array();
  public $aFilters = array();
  
  public function getFilterColumnValue($sColumnName) {
    if(!isset($this->aFilters[$sColumnName])) {
      return ListHelper::SELECT_ALL;
    }
    return $this->aFilters[$sColumnName];
  }
  
  public function setFilterColumnValue($sColumnName, $sValue) {
    if(!$sValue) {
      unset($this->aFilters[$sColumnName]);
      return;
    }
    $this->aFilters[$sColumnName] = $sValue;
  }
  
  public function setSelectionType($sColumnName, $sSelectionType) {
    $this->aTagFilters[$sColumnName] = $sSelectionType;
  }
  
  public function usesTagFilter($sColumnName) {
    return in_array($sColumnName, $this->aTagFilters);
  }
  
  public function addSortColumn($sColumnName, $sSortOrder) {
    ArrayUtil::assocUnshift($this->aSorts, $sColumnName, $sSortOrder);
  }
  
  public function getSortColumnValue($sColumnName) {
    if(!isset($this->aSorts[$sColumnName])) {
      return null;
    }
    return $this->aSorts[$sColumnName];
  }
  
  public function isTopSort($sColumnName) {
    $aKeys = array_keys($this->aSorts);
    return @$aKeys[0] === $sColumnName;
  }
  
  public function setSearchPhrase($sSearchPhrase) {
    if($sSearchPhrase == '') {
      $sSearchPhrase = null;
    }
    $this->sSearchPhrase = $sSearchPhrase;
  }

  public function getSearchPhrase() {
    return $this->sSearchPhrase;
  }
}