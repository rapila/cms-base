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

	public function mainContent() {
		switch($this->sAction) {
			case 'load_from_local': return $this->loadFromLocal(); break;
			case 'backup_to_local': return $this->backupToLocal(); break;
			default: return $this->constructTemplate('info');
		}
	}
	
	private function loadFromLocal() {
		
	}
	
	private function backupToLocal() {
		
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
				$aResult['heading'] = StringPeer::getString('wns.backup.sidebar_heading');
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
	
	public function usedWidgets() {
		return array($this->oBackupOptionsWidget);
	}
}
