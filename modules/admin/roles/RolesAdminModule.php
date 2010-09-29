<?php
/**
 * @package modules.admin
 */
class RolesAdminModule extends AdminModule {
	
	private $oListWidget;

	public function __construct() {
		$this->oListWidget = new RoleListWidgetModule();
	}
	
	public function mainContent() {
		return $this->oListWidget->doWidget();
	}

	public function usedWidgets() {
		return array($this->oListWidget);
	}
}
