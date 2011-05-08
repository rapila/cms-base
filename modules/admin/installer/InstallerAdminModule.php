<?php
/**
 * @package modules.admin
 */
class InstallerAdminModule extends AdminModule {
		
	private $oInstallerOptionsWidget;
	private $sAction;
	
	public function __construct() {
		$this->oInstallerOptionsWidget = new ListWidgetModule();
		$this->oInstallerOptionsWidget->setDelegate($this);
	}
	
	public function setAction($sAction) {
	  $this->sAction = $sAction;
	}

	public function mainContent() {
		switch($this->sAction) {
			default: return $this->constructTemplate('info');
		}
	}
	
	private function loadFromLocal() {
		
	}
	
	private function backupToLocal() {
		
	}
	
	public function sidebarContent() {
		return $this->oInstallerOptionsWidget->doWidget();
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
		$aInstaller = InstallUtil::loadYamlFile(BASE_DIR.'/'.DIRNAME_MODULES.'/admin/installer/installer_options.yml');
		foreach($aInstaller['options'] as $sSectionName => $aOptions) {
			$aResult[] = array('action' => $sSectionName, 'title' => StringPeer::getString('wns.backup.'.$sSectionName, null, StringUtil::makeReadableName($sSectionName)));
		}
		if($iRowCount === null) {
			$iRowCount = count($aResult);
		}
		return array_splice($aResult, $iRowStart, $iRowCount);
	}
	
	public function usedWidgets() {
		return array($this->oInstallerOptionsWidget);
	}
}
