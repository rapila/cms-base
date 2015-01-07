<?php
/**
 * @package modules.widget
 */
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
