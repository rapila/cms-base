<?php
/**
 * @package modules.admin
 */
class BackupAdminModule extends AdminModule {
		
	private $oBackupOptionsWidget;
	private $sAction;
	
	public function __construct() {
		$this->oBackupOptionsWidget = new ListWidgetModule();
		$this->oBackupOptionsWidget->setDelegate($this);
	}
	
	public function setAction($sAction) {
	  $this->sAction = $sAction;
	}
	
	public function sidebarContent() {
		return $this->oBackupOptionsWidget->doWidget();
	}
	
	public function getColumnIdentifiers() {
		return array('action', 'title');
	}
	
	public function getMetadataForColumn($sColumnIdentifier) {
		$aResult = array();
		switch($sColumnIdentifier) {
			case 'action':
				$aResult['display_type'] = ListWidgetModule::DISPLAY_TYPE_DATA;
				break;
			case 'title':
				$aResult['heading'] = StringPeer::getString('widget.backup.sidebar_heading');
				break;
		}
		return $aResult;
	}
	
	public function getListContents($iRowStart = 0, $iRowCount = null) {
		$aResult = array();
		$aBackupOptions = array('load_from_local', 'backup_to_local');
		foreach($aBackupOptions as $sAction) {
			$aResult[] = array('action' => $sAction, 'title' => StringPeer::getString('backup.'.$sAction));
		}
		if($iRowCount === null) {
			$iRowCount = count($aResult);
		}
		return array_splice($aResult, $iRowStart, $iRowCount);
	}

	public function mainContent() {
		return $this->constructTemplate('info');
	}
	
	public function usedWidgets() {
		return array();
	}
}
