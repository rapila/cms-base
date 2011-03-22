<?php
/**
 * @package modules.admin
 */
class DashboardAdminModule extends AdminModule {
		
	private $oModuleListWidget;
	
	public function __construct() {
		$sUsePath = Manager::usePath();
		$this->addResourceParameter(ResourceIncluder::RESOURCE_TYPE_JS, 'context_module', $sUsePath);
	}
	
	public function includeCustomResources($oResourceIncluder) {
		$oResourceIncluder->addResource('admin/dashboard-interface.css', null, null, array(), ResourceIncluder::PRIORITY_NORMAL, null, true);
		$oResourceIncluder->addResource('admin/dashboard-interface.js', null, null, array(), ResourceIncluder::PRIORITY_NORMAL, null, true);
		parent::includeCustomResources($oResourceIncluder);
	}
	
	public function mainContent() {
		$oTemplate = $this->constructTemplate('main');
		return $oTemplate;
	}
	
	public function sidebarContent() {
		return false;
	}
}
