<?php
/**
 * @package modules.admin
 */
class DashboardAdminModule extends AdminModule {
		
	private $oModuleListWidget;
	private $sContext;
	
	public function __construct() {
		$this->oModuleListWidget = new ListWidgetModule();
		$this->oModuleListWidget->setDelegate($this);
		$this->sContext = Manager::usePath();
	}
	
	public function sidebarContent() {
		return $this->oModuleListWidget->doWidget();
	}
	
	public function mainContent() {
		// display context dashboard widget, make default actions if exist, like context modules (group modules)
		// @see dashboard_todo.txt
	}
	
	public function getColumnIdentifiers() {
		return array('name', 'link', 'title');
	}
	
	public function getMetadataForColumn($sColumnIdentifier) {
		$aResult = array();
		switch($sColumnIdentifier) {
			case 'name':
			case 'link':
				$aResult['display_type'] = ListWidgetModule::DISPLAY_TYPE_DATA;
				break;
			case 'title':
				$aResult['display_heading'] = false;
				break;
		}
		return $aResult;
	}
	
	public static function getListContents($iRowStart = 0, $iRowCount = null) {
		$aResult = array();
		$sModulePostFix = '';
		foreach(AdminModule::listModules() as $sModuleName => $aModuleInformation) {
			if($sModuleName !== 'dashboard') {
				$aResult[AdminModule::getDisplayNameByName($sModuleName)] = array('name' => $sModuleName, 'link' => LinkUtil::link(array($sModuleName), 'AdminManager'), 'title' => AdminModule::getDisplayNameByName($sModuleName));
			}
		}
		ksort($aResult);
		foreach($aResult as $sModuleName => $aModuleInformation) {
			unset($aResult[$sModuleName]);
			$aResult[] = $aModuleInformation;
		}
		
		if($iRowCount === null) {
			$iRowCount = count($aResult);
		}
		return array_splice($aResult, $iRowStart, $iRowCount);
	}
	
	public function usedWidgets() {
		return array($this->oModuleListWidget);
	}
}
