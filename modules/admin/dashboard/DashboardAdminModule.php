<?php
/**
 * @package modules.admin
 */
class DashboardAdminModule extends AdminModule {

	public function __construct() {
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
