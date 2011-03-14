<?php
/**
 * @package modules.admin
 */
class DashboardAdminModule extends AdminModule {
		
	private $oModuleListWidget;
	
	public function __construct() {
		$this->oModuleListWidget = new ListWidgetModule();
		$this->oModuleListWidget->setDelegate($this);
		$sUsePath = Manager::usePath();
		$this->addResourceParameter(ResourceIncluder::RESOURCE_TYPE_JS, 'context_module', $sUsePath);
	}
	
	public function includeCustomResources($oResourceIncluder) {
		$oResourceIncluder->addResource('admin/dashboard-interface.css', null, null, array(), ResourceIncluder::PRIORITY_NORMAL, null, true);
		$oResourceIncluder->addResource('admin/dashboard-interface.js', null, null, array(), ResourceIncluder::PRIORITY_NORMAL, null, true);
		parent::includeCustomResources($oResourceIncluder);
	}
	
	public function sidebarContent() {
		return $this->oModuleListWidget->doWidget();
	}
	
	public function mainContent() {
		$oTemplate = $this->constructTemplate('main');
		return $oTemplate;
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
		foreach(WidgetModule::listModulesByAspect('dashboard') as $sModuleName => $aModuleInformation) {
			$aResult[] = array('name' => $sModuleName, 'link' => LinkUtil::link(array($sModuleName), 'AdminManager'), 'title' => AdminModule::getDisplayNameByName($sModuleName));
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
