<?php
/**
 * @package modules.widget
 */
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
