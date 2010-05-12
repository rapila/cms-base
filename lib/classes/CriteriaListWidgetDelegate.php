<?php

class CriteriaListWidgetDelegate {
	private $oCriteriaDelegate;
	private $sModelName;
	private $sPeerClassName;
	private $oListSettings;
	private $bSortColumnForDisplayColumnDefined;
	private $aFilterTypes;
	
	const SELECT_ALL = '__all';
	const SELECT_WITHOUT = '__without';
	
	const FILTER_TYPE_IS = 'is';
	const FILTER_TYPE_BEGINS = 'begins';
	const FILTER_TYPE_CONTAINS = 'contains';
	const FILTER_TYPE_TAG = 'tag';
	const FILTER_TYPE_IS_NULL = 'is_null';
	const FILTER_TYPE_MANUAL = 'manual';
	
	public function __construct($oCriteriaDelegate, $sModelName, $sDefaultOrderColumn=null, $sDefaultSortOrder='asc') {
		$this->oListSettings = new ListSettings();
		$this->oCriteriaDelegate = $oCriteriaDelegate;
		$this->sModelName = $sModelName;
		$this->sPeerClassName = "${sModelName}Peer";
		$this->bSortColumnForDisplayColumnDefined = method_exists($this->oCriteriaDelegate, 'getDatabaseColumnForDisplayColumn');
		if($sDefaultOrderColumn !== null) {
			$this->oListSettings->addSortColumn($sDefaultOrderColumn, $sDefaultSortOrder);
		}
		$this->aFilterTypes = method_exists($this->oCriteriaDelegate, 'getFilterTypeForColumn') ? array() : null;
	}
	
	public function getListSettings() {
		return $this->oListSettings;
	}
	
	public function getDelegate() {
		return $this->oCriteriaDelegate;
	}
	
	public function __call($sMethodName, $aArguments) {
		if($this->aFilterTypes !== null && StringUtil::startsWith($sMethodName, 'set') && $sMethodName[3] === strtoupper($sMethodName[3])) {
			$sFilterColumn = StringUtil::deCamelize(lcfirst(substr($sMethodName, 3)));
			if(!isset($this->aFilterTypes[$sFilterColumn])) {
				$sFilterType = $this->oCriteriaDelegate->getFilterTypeForColumn($sFilterColumn);
				if($sFilterType === null) {
					goto default_function;
				}
				$this->aFilterTypes[$sFilterColumn] = $sFilterType;
			}
			$this->oListSettings->setFilterColumnValue($sFilterColumn, $aArguments[0]);
			return;
		}
		default_function:
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
		$this->handleListFiltering($oCriteria);
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
			$oCriteria->$sMethod($this->getDatabaseColumnForDisplayColumn($sSortColumn));
		}
	}
	
	private function handleListFiltering($oCriteria) {
		foreach($this->oListSettings->aFilters as $sFilterIdentifier => $sFilterValue) {
			$sFilterColumn = $this->getDatabaseColumnForDisplayColumn($sFilterIdentifier);
			if($sFilterValue === self::SELECT_ALL || $this->aFilterTypes[$sFilterIdentifier] === self::FILTER_TYPE_MANUAL) {
				continue;
			}
			$bInverted = $sFilterValue === self::SELECT_WITHOUT;
			$sFilterValue = $bInverted ? null : $sFilterValue;
			if($this->aFilterTypes[$sFilterIdentifier] === self::FILTER_TYPE_IS) {
				$oCriteria->add($sFilterColumn, $sFilterValue, Criteria::EQUAL);
			//LIKE criterias are not compatible with $bInverted == true
			} else if($this->aFilterTypes[$sFilterIdentifier] === self::FILTER_TYPE_BEGINS) {
				$oCriteria->add($sFilterColumn, "$sFilterValue%", Criteria::LIKE);
			} else if($this->aFilterTypes[$sFilterIdentifier] === self::FILTER_TYPE_CONTAINS) {
				$oCriteria->add($sFilterColumn, "%$sFilterValue%", Criteria::LIKE);
			} else if($this->aFilterTypes[$sFilterIdentifier] === self::FILTER_TYPE_IS_NULL) {
				if($sFilterValue) {
					$oCriteria->add($sFilterColumn, null, Criteria::ISNULL);
				} else {
					$oCriteria->add($sFilterColumn, null, Criteria::ISNOTNULL);
				}
			} else if($this->aFilterTypes[$sFilterIdentifier] === self::FILTER_TYPE_TAG) {
				$aTaggedItemIds = array();
				foreach(TagInstancePeer::getByModelNameAndTagName($this->sModelName, $sFilterValue) as $oTagInstance) {
					$aTaggedItemIds[] = $oTagInstance->getTaggedItemId();
				}
				$oCriteria->add($sFilterColumn, $aTaggedItemIds, $bInverted ? Criteria::NOT_IN : Criteria::IN);
			}
		}
	}
	
	private function getDatabaseColumnForDisplayColumn($sSortColumn) {
		$sSortOverride = null;
		if($this->bSortColumnForDisplayColumnDefined && ($sSortOverride = $this->oCriteriaDelegate->getDatabaseColumnForDisplayColumn($sSortColumn)) !== null) {
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