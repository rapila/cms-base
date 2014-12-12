<?php

/**
 * @brief Generic delegate for list widgets (ListWidgetModule) whose contents are determined by database entries of a specific model
 *
 * Usage:
 * @code
 * $this->oCriteriaListWidgetDelegate = new CriteriaListWidgetDelegate($this, 'ModelName');
 * $this->oListWidget = WidgetModule::getWidget('list', null, $this->oCriteriaListWidgetDelegate);
 * @endcode
 * CriteriaListWidgetDelegate still needs its own delegate. The required method for this is <code>getColumnIdentifiers</code>. Optional methods are as follows:
 * - <code>getCriteria</code> to customize the database query
 * - <code>getDatabaseColumnForColumn</code> for columns whose identifier or field_name does not correspond to a database field directly (you only need this if you wish to sort or filter by a column)
 * - <code>getFilterTypeForColumn</code> return one of the given FILTER_TYPE_* constants to allow filtering by a specific column (the column does not need to be displayed). Set the filters using ListWidgetModule::setOption() (also from JavaScript).
 */
class CriteriaListWidgetDelegate implements ListWidgetDelegate {
	private $oCriteriaDelegate;
	private $sModelName;
	private $sPeerClassName;
	private $oListSettings;
	private $bDatabaseColumnForColumnDefined;
	private $aFilterTypes;

	const SELECT_ALL = '__all';
	const SELECT_WITHOUT = '__without';

	const FILTER_TYPE_IS = 'is';
	const FILTER_TYPE_IN = 'in';
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
		$this->bDatabaseColumnForColumnDefined = method_exists($this->oCriteriaDelegate, 'getDatabaseColumnForColumn');
		if($sDefaultOrderColumn !== null) {
			$this->oListSettings->addSortColumn($sDefaultOrderColumn, $sDefaultSortOrder);
		}
		$this->aFilterTypes = method_exists($this->oCriteriaDelegate, 'getFilterTypeForColumn') ? array() : null;
	}

	public function setModelName($sModelName) {
		$this->sModelName = $sModelName;
	}

	public function getModelName() {
		return $this->sModelName;
	}

	public function getListSettings() {
		return $this->oListSettings;
	}

	public function getDelegate() {
		return $this->oCriteriaDelegate;
	}

	private function filterTypeForColumn($sFilterColumn) {
		if($this->aFilterTypes === null) {
			return null;
		}
		if(!isset($this->aFilterTypes[$sFilterColumn])) {
			$sFilterType = $this->oCriteriaDelegate->getFilterTypeForColumn($sFilterColumn);
			$this->aFilterTypes[$sFilterColumn] = $sFilterType;
		}
		return $this->aFilterTypes[$sFilterColumn];
	}
	
	public function getColumnIdentifiers() {
		return $this->oCriteriaDelegate->getColumnIdentifiers();
	}

	public function __call($sMethodName, $aArguments) {
		if($this->aFilterTypes !== null && StringUtil::startsWith($sMethodName, 'set') && $sMethodName[3] === strtoupper($sMethodName[3])) {
			$sFilterColumn = StringUtil::deCamelize(lcfirst(substr($sMethodName, 3)));
			if($this->filterTypeForColumn($sFilterColumn) !== null) {
				return $this->oListSettings->setFilterColumnValue($sFilterColumn, $aArguments[0]);
			}
		}
		if($this->aFilterTypes !== null && StringUtil::startsWith($sMethodName, 'get') && $sMethodName[3] === strtoupper($sMethodName[3])) {
			$sFilterColumn = StringUtil::deCamelize(lcfirst(substr($sMethodName, 3)));
			if($this->filterTypeForColumn($sFilterColumn) !== null) {
				return $this->oListSettings->getFilterColumnValue($sFilterColumn);
			}
		}
		return call_user_func_array(array($this->oCriteriaDelegate, $sMethodName), $aArguments);
	}

	public function getMetadataForColumn($sColumnIdentifier) {
		if(method_exists($this->oCriteriaDelegate, 'getMetadataForColumn')) {
			return $this->oCriteriaDelegate->getMetadataForColumn($sColumnIdentifier);
		}
		return array();
	}

	public function getCriteria($bSortIsIrrelevant = false) {
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
			$oCriteria->$sMethod($this->getDatabaseColumnForColumn($sSortColumn));
		}
	}

	private function handleListFiltering($oCriteria) {
		foreach($this->oListSettings->aFilters as $sFilterIdentifier => $mFilterValue) {
			$sFilterType = $this->filterTypeForColumn($sFilterIdentifier);
			if($mFilterValue === self::SELECT_ALL || $sFilterType === self::FILTER_TYPE_MANUAL) {
				continue;
			}
			$sFilterColumn = $this->getDatabaseColumnForColumn($sFilterIdentifier);
			$bInverted = $mFilterValue === self::SELECT_WITHOUT;
			$mFilterValue = $bInverted ? null : $mFilterValue;
			if($sFilterType === self::FILTER_TYPE_IS) {
				$oCriteria->add($sFilterColumn, $mFilterValue, Criteria::EQUAL);
			//LIKE criterias are not compatible with $bInverted == true
			} else if($sFilterType === self::FILTER_TYPE_BEGINS) {
				$oCriteria->add($sFilterColumn, "$mFilterValue%", Criteria::LIKE);
			} else if($sFilterType === self::FILTER_TYPE_CONTAINS) {
				$oCriteria->add($sFilterColumn, "%$mFilterValue%", Criteria::LIKE);
			} else if($sFilterType === self::FILTER_TYPE_IS_NULL) {
				if($mFilterValue) {
					$oCriteria->add($sFilterColumn, null, Criteria::ISNULL);
				} else {
					$oCriteria->add($sFilterColumn, null, Criteria::ISNOTNULL);
				}
			} else if($sFilterType === self::FILTER_TYPE_IN) {
				if(!is_array($mFilterValue)) {
					$mFilterValue = array($mFilterValue);
				}
				if(count($mFilterValue) === 0) {
					$bInverted = true;
				}
				$oCriteria->add($sFilterColumn, $mFilterValue, $bInverted ? Criteria::NOT_IN : Criteria::IN);
			} else if($sFilterType === self::FILTER_TYPE_TAG) {
				$aTaggedItemIds = array();
				foreach(TagInstancePeer::getByModelNameAndTagName($this->sModelName, $mFilterValue) as $oTagInstance) {
					$aTaggedItemIds[] = $oTagInstance->getTaggedItemId();
				}
				$oCriteria->add($sFilterColumn, $aTaggedItemIds, $bInverted ? Criteria::NOT_IN : Criteria::IN);
			}
		}
	}

	private function getDatabaseColumnForColumn($sColumnIdentifier, $bLenient = false) {
		$sSortOverride = null;
		if($this->bDatabaseColumnForColumnDefined && ($sSortOverride = $this->oCriteriaDelegate->getDatabaseColumnForColumn($sColumnIdentifier)) !== null) {
			return $sSortOverride;
		}
		$aMetadata = $this->getMetadataForColumn($sColumnIdentifier);
		$sFieldName = $sColumnIdentifier;
		if(isset($aMetadata['field_name'])) {
			$sFieldName = $aMetadata['field_name'];
		}
		$sConstant = "$this->sPeerClassName::".strtoupper($sFieldName);
		if(!defined($sConstant)) {
			$sConstant = "$this->sPeerClassName::".strtoupper($sColumnIdentifier);
		}
		if($bLenient && !defined($sConstant)) {
			return null;
		}
		return constant($sConstant);
	}

	private function handleListSearching($oCriteria) {
		if($this->oListSettings->getSearchPhrase() === null) {
			return;
		}
		if(!method_exists($this->sPeerClassName, 'addSearchToCriteria')) {
			throw new LocalizedException('wns.module.search_not_implemented', array('model' => $this->sPeerClassName));
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
		foreach($aRowData as $sRowDataColumnIdentifier => $mRowValue) {
			$sColumn = $this->getDatabaseColumnForColumn($sRowDataColumnIdentifier, true);
			if($sColumn !== null) {
				$oCriteria->addAnd($sColumn, $mRowValue);
			}
		}
		return $oCriteria;
	}

	public function allowSort($sColumnIdentifier) {
		if(method_exists($this->oCriteriaDelegate, 'allowSort')) {
			return $this->oCriteriaDelegate->allowSort($sColumnIdentifier);
		}
		return false;
	}

	public function doSort($sColumnIdentifier, $aRowData, $aRelatedRowData, $sPosition) {
		$oObjectToSort = $this->rowFromData($aRowData);
		$oRelatedObject = $this->rowFromData($aRelatedRowData);
		$this->oCriteriaDelegate->doSort($sColumnIdentifier, $oObjectToSort, $oRelatedObject, $sPosition);
	}

	public function setSearch($sSearch) {
		return $this->oListSettings->setSearchPhrase($sSearch);
	}

	/**
	* Searching only works if the ModelNamePeer class has a Method named <code>addSearchToCriteria($sSearchString, $oCriteria)</code> which should set all the necessary search query params on the criteria.
	*/
	public function getSearch() {
		return $this->oListSettings->getSearchPhrase();
	}

	public function deleteRow($aRowData) {
		$oCriteria = $this->criteriaFromRowData($aRowData);
		if(method_exists($this->oCriteriaDelegate, 'deleteRow')) {
			return $this->oCriteriaDelegate->deleteRow($aRowData, $oCriteria);
		}
		$oObj = call_user_func(array($this->sPeerClassName, 'doSelectOne'), $oCriteria);
		return $oObj->delete();
	}

	public function rowFromData($aRowData) {
		return call_user_func(array($this->sPeerClassName, 'doSelectOne'), $this->criteriaFromRowData($aRowData, $this->getCriteria(true)));
	}

	public function numberOfRows() {
		return call_user_func(array($this->sPeerClassName, 'doCount'), $this->getCriteria(true))+count($this->getCustomListElements());
	}
}
