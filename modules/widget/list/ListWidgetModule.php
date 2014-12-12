<?php
/**
 * @package modules.widget
 */
class ListWidgetModule extends PersistentWidgetModule {
	
	const DISPLAY_TYPE_DEFAULT = null;
	
	const DISPLAY_TYPE_TEXT = 'text';
	const DISPLAY_TYPE_NUMERIC = 'numeric';
	const DISPLAY_TYPE_HTML = 'html';
	
	// url can process string or array of params [href, linktext]
	const DISPLAY_TYPE_STATIC = 'static';
	const DISPLAY_TYPE_ICON = 'icon';
	const DISPLAY_TYPE_BOOLEAN = 'boolean';
	const DISPLAY_TYPE_DOCUMENT = 'document';
	const DISPLAY_TYPE_URL = 'url';
	
	const DISPLAY_TYPE_CLASSNAME = 'classname';
	const DISPLAY_TYPE_DATA = 'data';
	const DISPLAY_TYPE_REORDERABLE = 'reorderable';

	private $oDelegate;
	private $oListTag;
	private $aSchema = null;
	
	private $oSpecializedListWidgetModule;

	public $sStringPrefix = 'column';

	public function __construct($sSessionKey = null, ListWidgetDelegate $oDelegate = null) {
		parent::__construct($sSessionKey);
		$this->oDelegate = $oDelegate;
	}
	
	public function specialize($oSpecializedListWidgetModule) {
		$this->oSpecializedListWidgetModule = $oSpecializedListWidgetModule;
	}
	
	public function setDelegate(ListWidgetDelegate $oDelegate) {
		$this->oDelegate = $oDelegate;
	}
	
	public function getDelegate() {
		return $this->oDelegate;
	}
	
	public function getModelName() {
		if(method_exists($this->oDelegate, 'getModelName')) {
			return $this->oDelegate->getModelName();
		}
		return null;
	}

	public function setListTag($oListTag) {
		$this->oListTag = $oListTag;
	}
	
	private static function displayTypeVisible($sDisplayType) {
		return !in_array($sDisplayType, array(self::DISPLAY_TYPE_DATA, self::DISPLAY_TYPE_CLASSNAME));
	}

	public function doWidget($sClassName = '') {
		if(!$this->oListTag) {
			$aSchema = $this->getSchema();
			$iVisibleColumnCount = 0;
			foreach($aSchema as $aColumn) {
				if(self::displayTypeVisible($aColumn['display_type'])) {
					$iVisibleColumnCount++;
				}
			}
			$this->oListTag = new TagWriter($iVisibleColumnCount > 1 ? 'table' : 'ul');
		}

		if($this->oSpecializedListWidgetModule) {
			$this->oListTag->addToParameter('class', $this->oSpecializedListWidgetModule->getModuleName());
			$this->oListTag->setParameter('data-list-widget-type', $this->oSpecializedListWidgetModule->getModuleName());
		}

		$this->oListTag->addToParameter('class', "ui-list $sClassName");
		$this->oListTag->setParameter('data-widget-session', $this->sPersistentSessionKey);
		$this->oListTag->setParameter('data-widget-type', $this->getModuleName());
		return $this->oListTag->parse();
	}

	public function getSchema($bForceReload = false) {
		if($this->aSchema !== null && !$bForceReload) {
			return $this->aSchema;
		}
		$aColumns = $this->oDelegate->getColumnIdentifiers();
		$this->aSchema = array();
		foreach($aColumns as $sColumnIdentifier) {
			$aMetadata = $this->oDelegate->getMetadataForColumn($sColumnIdentifier);
			if($aMetadata === null) {
				$aMetadata = array();
			}
			$aMetadata['identifier'] = $sColumnIdentifier;
			if(!isset($aMetadata['display_type'])) {
				$aMetadata['display_type'] = ($sColumnIdentifier === 'id' ? self::DISPLAY_TYPE_DATA : self::DISPLAY_TYPE_DEFAULT);
			}
			if(!isset($aMetadata['display_heading'])) {
				$aMetadata['display_heading'] = self::displayTypeVisible($aMetadata['display_type']);
			}
			if(!isset($aMetadata['heading']) && $aMetadata['display_heading']) {
				$aMetadata['heading'] = StringPeer::getString("$this->sStringPrefix.$sColumnIdentifier");
			}
			if(!isset($aMetadata['field_name'])) {
				$aMetadata['field_name'] = $sColumnIdentifier;
			}
			if(!isset($aMetadata['has_data'])) {
				$aMetadata['has_data'] = $aMetadata['display_type'] !== self::DISPLAY_TYPE_STATIC && $aMetadata['display_type'] !== self::DISPLAY_TYPE_ICON && $aMetadata['display_type'] !== self::DISPLAY_TYPE_REORDERABLE;
			}
			if(!isset($aMetadata['is_sortable'])) {
				$aMetadata['is_sortable'] = $aMetadata['display_type'] === self::DISPLAY_TYPE_REORDERABLE;
			}
			
			$this->aSchema[] = $aMetadata;
		}
		return $this->aSchema;
	}
	
	public function allowSort($sColumnIdentifier) {
		if(method_exists($this->oDelegate, 'allowSort')) {
			return $this->oDelegate->allowSort($sColumnIdentifier);
		}
		return false;
	}
	
	public function doSort($sColumnIdentifier, $aRowData, $aRelatedRowData, $sPosition) {
		$this->oDelegate->doSort($sColumnIdentifier, $aRowData, $aRelatedRowData, $sPosition);
	}

	public function deleteRow($aRowData) {
		return $this->oDelegate->deleteRow($aRowData);
	}	

	public function toggleBoolean($aRowData, $sBooleanName='is_inactive') {
		$sMethodName = 'toggle'.StringUtil::camelize($sBooleanName, true);
		$this->oDelegate->$sMethodName($aRowData);
	}

	public function getNumberOfColumns() {
		return count($this->oDelegate->getColumnIdentifiers());
	}

	public function getNumberOfRows() {
		return $this->oDelegate->numberOfRows();
	}

	// Async version of getNumberOfRows
	public function numberOfRows() {
		return $this->oDelegate->numberOfRows();
	}
	
	public function getOrderColumnSort() {
		if(method_exists($this->oDelegate, 'getOrderColumnSort')) {
			return $this->oDelegate->getOrderColumnSort();
		}
		return array(null, null);
	}
	
	public function setOrderColumnSort($sOrderColumn, $sSortOrder) {
		if(method_exists($this->oDelegate, 'setOrderColumnSort')) {
			return $this->oDelegate->setOrderColumnSort($sOrderColumn, $sSortOrder);
		}
	}
	
	public function completeList() {
		return $this->partialList(0, null);
	}

	public function partialList($iStart = 0, $iLength = null) {
		$aResult = $this->oDelegate->getListContents($iStart, $iLength);
		if(count($aResult) === 0) {
			return $aResult;
		}
		return WidgetJsonFileModule::jsonBaseObjects($aResult, $this->columnsForJson());
	}
	
	private function columnsForJson() {
		$aColumns = array();
		foreach($this->getSchema() as $aColumn) {
			if($aColumn['has_data']) {
				$aColumns[$aColumn['identifier']] = $aColumn['field_name'];
			}
		}
		return $aColumns;
	}

	public function rowFromData($aRowData) {
		$oRow = $this->oDelegate->rowFromData($aRowData);
		if($oRow === null) {
			return null;
		}
		$aRow = array($oRow);
		$aRow = WidgetJsonFileModule::jsonBaseObjects($aRow, $this->columnsForJson());
		return $aRow[0];
	}
	
	public function setOption($sName, $mValue = null) {
		$sName = 'set'.StringUtil::camelize($sName, true);
		$aArgs = func_get_args();
		if(count($aArgs) === 1) {
			$aArgs[] = null;
		}
		return call_user_func_array(array($this->oDelegate, $sName), array_splice($aArgs, 1));
	}

	public function getOption($sName) {
		$sName = 'get'.StringUtil::camelize($sName, true);
		$aArgs = func_get_args();
		return call_user_func_array(array($this->oDelegate, $sName), array_splice($aArgs, 1));
	}

	public function setSearch($sSearch=null) {
		if($this->getSearch() == $sSearch) {
			return false;
		}
		$this->oDelegate->setSearch($sSearch);
		return true;
	}

	public function getSearch() {
		return $this->oDelegate->getSearch();
	}
}

interface ListWidgetDelegate {
	public function getColumnIdentifiers();
	public function getMetadataForColumn($sColumnIdentifier);
	public function numberOfRows();
	public function getListContents($iRowStart = 0, $iRowCount = null);
	// Optional
	// public function getModelName();
	// public function rowFromData($aRowData);
	// public function deleteRow($aRowData);
}

class TestListWidgetDelegate implements ListWidgetDelegate {
	private $iColumns;
	private $iRows;
	
	public function __construct($iColumns, $iRows) {
		$this->iColumns = $iColumns;
		$this->iRows = $iRows;
	}
	
	public function getColumnIdentifiers() {
		$aResult = array();
		for($i=0;$i<$this->iColumns;$i++) {
			$aResult[] = 'col_'.$i;
		}
		return $aResult;
	}
	
	public function getMetadataForColumn($sColumnIdentifier) {
		return array(
			'heading' => 'Column ' . (1+substr($sColumnIdentifier, 4))
		);
	}
	
	public function numberOfRows() {
		return $this->iRows;
	}
	
	public function getListContents($iRowStart = 0, $iRowCount = null) {
		$aResult = array();
		$iMax = $this->iRows;
		if($iRowCount && $iRowStart + $iRowCount < $iMax) {
			$iMax = $iRowStart + $iRowCount;
		}
		for($i=$iRowStart;$i<$iMax;$i++) {
			$aRow = array();
			for($j=0;$j<$this->iColumns;$j++) {
				$aRow['col_'.$j] = "Row ".($i+1).", Column ".($j+1);
			}
			$aResult[] = $aRow;
		}

		return $aResult;
	}
}
