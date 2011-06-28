<?php
/**
* @package utils
*/

class ListSettings {
	private $sSearchPhrase = null;
	public $aSorts = array();
	public $aFilters = array();
	
	public function getFilterColumnValue($sColumnName, $mDefaultValue = '__all') {
		if(!isset($this->aFilters[$sColumnName])) {
			$this->aFilters[$sColumnName] = $mDefaultValue;
		}
		return $this->aFilters[$sColumnName];
	}
	
	public function setFilterColumnValue($sColumnName, $sValue) {
		if($sValue === null || $sValue === '') {
			if(!isset($this->aFilters[$sColumnName])) {
				return false;
			}
			unset($this->aFilters[$sColumnName]);
			return true;
		}
		if($this->getFilterColumnValue($sColumnName) == $sValue) {
			return false;
		}
		$this->aFilters[$sColumnName] = $sValue;
		return true;
	}
	
	public function allFilterColumns() {
		return array_keys($this->aFilters);
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

	public function getTopSort() {
		$aKeys = array_keys($this->aSorts);
		return @$aKeys[0];
	}
	
	public function setSearchPhrase($sSearchPhrase) {
		if($sSearchPhrase == '') {
			$sSearchPhrase = null;
		}
		if($this->sSearchPhrase == $sSearchPhrase) {
			return false;
		}
		$this->sSearchPhrase = $sSearchPhrase;
		return true;
	}

	public function getSearchPhrase() {
		return $this->sSearchPhrase;
	}
}