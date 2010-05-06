<?php

class CriteriaListWidgetDelegate {
	private $oCriteriaDelegate;
	private $sPeerClassName;
	private $oListSettings;
	private $bSortColumnForDisplayColumnDefined;
	const SELECT_ALL = '__all';
	const SELECT_WITHOUT = '__without';

	
	public function __construct($oCriteriaDelegate, $sModelName, $sDefaultOrderColumn=null, $sDefaultSortOrder='asc') {
		$this->oListSettings = new ListSettings();
		$this->oCriteriaDelegate = $oCriteriaDelegate;
		$this->sPeerClassName = "${sModelName}Peer";
		$this->bSortColumnForDisplayColumnDefined = method_exists($this->oCriteriaDelegate, 'getSortColumnForDisplayColumn');
		if($sDefaultOrderColumn !== null) {
			$this->oListSettings->addSortColumn($sDefaultOrderColumn, $sDefaultSortOrder);
		}
	}
	
	public function getDelegate() {
		return $this->oCriteriaDelegate;
	}
	
	public function __call($sMethodName, $aArguments) {
		return call_user_func_array(array($this->oCriteriaDelegate, $sMethodName), $aArguments);
	}
	
	private function getCriteria($bSortIsIrrelevant = false) {
		$oCriteria = null;
		if($this->oCriteriaDelegate === null || !method_exists($this->oCriteriaDelegate, 'getCriteria')) {
			$oCriteria = new Criteria();
		} else {
			$oCriteria = $this->oCriteriaDelegate->getCriteria();
		}
		$this->handleListSearching($oCriteria);
		if(!$bSortIsIrrelevant) {
			$this->handleListSorting($oCriteria);
		}
		return $oCriteria;
	}
	
	public function getListContents($iRowStart = 0, $iRowCount = null) {
		$oCriteria = $this->getCriteria();
		
		if($iRowStart > 0) {
			$oCriteria->setOffset($iRowStart);
		}
		if($iRowCount !== null) {
			$oCriteria->setLimit($iRowCount);
		}
		$aResult = call_user_func(array($this->sPeerClassName, 'doSelect'), $oCriteria);
		$aResult = array_merge($this->getCustomListElements(), $aResult);
		return $aResult;
	}
	
	public function getCustomListElements() {
		if(method_exists($this->oCriteriaDelegate, 'getCustomListElements')) {
			return $this->oCriteriaDelegate->getCustomListElements();
		}
		return array();
	}

	private function handleListSorting($oCriteria) {
		foreach($this->oListSettings->aSorts as $sSortColumn => $sSortOrder) {
			$sMethod = 'add'.ucfirst(strtolower($sSortOrder)).'endingOrderByColumn';
			$oCriteria->$sMethod($this->getSortColumnForDisplayColumn($sSortColumn));
		}
	}
	
	private function getSortColumnForDisplayColumn($sSortColumn) {
		$sSortOverride = null;
		if($this->bSortColumnForDisplayColumnDefined && ($sSortOverride = $this->oCriteriaDelegate->getSortColumnForDisplayColumn($sSortColumn)) !== null) {
			return $sSortOverride;
		}
		return constant("$this->sPeerClassName::".strtoupper($sSortColumn));
	}
	
	private function handleListSearching($oCriteria) {
		if($this->oListSettings->getSearchPhrase() === null) {
			return;
		}
		if(!method_exists($this->sPeerClassName, 'addSearchToCriteria')) {
			throw new LocalizedException('module.widget.list.search_not_implemented', array('model', $this->sPeerClassName));
		}
		call_user_func(array($this->sPeerClassName, 'addSearchToCriteria'), $this->oListSettings->getSearchPhrase(), $oCriteria);
	}

	public function setOrderColumnSort($sOrderColumn, $sSortOrder) {
		$this->oListSettings->addSortColumn($sOrderColumn, $sSortOrder);
	}

	public function getOrderColumnSort() {
		$sTopSortColumn = $this->oListSettings->getTopSort();
		if($sTopSortColumn === null) {
			return array(null, null);
		}
		return array($sTopSortColumn, $this->oListSettings->getSortColumnValue($sTopSortColumn));
	}
	
	private function criteriaFromRowData($aRowData, $oCriteria = null) {
		if($oCriteria === null) {
			$oCriteria = new Criteria();
		}
		$oCriterion = null;
		foreach($aRowData as $sRowDataColumnName => $mRowValue) {
			$sColumnName = constant("$this->sPeerClassName::".strtoupper($sRowDataColumnName));
			if($sColumnName !== null) {
				$oCriteria->addAnd($sColumnName, $mRowValue);
			}
		}
		return $oCriteria;
	}
	
	public function setSearch($sSearch) {
		$this->oListSettings->setSearchPhrase($sSearch);
	}
	
	public function getSearch() {
		return $this->oListSettings->getSearchPhrase();
	}
	
	public function deleteRow($aRowData) {
		call_user_func(array($this->sPeerClassName, 'doDelete'), $this->criteriaFromRowData($aRowData));
	}
	
	public function rowFromData($aRowData) {
		return call_user_func(array($this->sPeerClassName, 'doSelectOne'), $this->criteriaFromRowData($aRowData, $this->getCriteria(true)));
	}
	
	public function numberOfRows() {
		return call_user_func(array($this->sPeerClassName, 'doCount'), $this->getCriteria(true))+count($this->getCustomListElements());
	}
}