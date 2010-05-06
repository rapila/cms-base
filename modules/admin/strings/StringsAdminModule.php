<?php
/**
 * @package modules.admin
 */
class StringsAdminModule extends AdminModule {

	private $oListWidget;
	private $oSidebarWidget;
	
	public function __construct() {
		$this->oListWidget 		= new StringListWidgetModule();
		$this->oSidebarWidget = new ListWidgetModule();
		$this->oSidebarWidget->setDelegate($this);
	}
	
	public function mainContent() {
		return $this->oListWidget->doWidget();
	}
	
	public function sidebarContent() {
		return $this->oSidebarWidget->doWidget();
	}
	
	public function numberOfRows() {
		return count(StringsPeer::getNamespaces($this->sNameSpace));
	}
	
	public function getColumnIdentifiers() {
		return array('title', 'name_space');
	}
	
	public function getMetadataForColumn($sColumnIdentifier) {
		$aResult = array();
		switch($sColumnIdentifier) {
			case 'title':
				$aResult['display_heading'] = false;
				break;
			case 'name_space':
				$aResult['display_type'] = ListWidgetModule::DISPLAY_TYPE_DATA;
				break;
		}
		return $aResult;
	}
	
	public static function getListContents($iRowStart = 0, $iRowCount = null) {
		$aResult = array();
		foreach(StringPeer::getNamespaces() as $sNameSpace) {
			$aResult[] = array('title' => $sNameSpace, 'name_space' => $sNameSpace);
		}
		if($iRowCount === null) {
			$iRowCount = count($aResult);
		}
		return array_splice($aResult, $iRowStart, $iRowCount);
	}

	public function usedWidgets() {
		return array($this->oListWidget, $this->oListWidget);
	}
}
