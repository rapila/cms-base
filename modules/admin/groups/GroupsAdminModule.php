<?php
/**
 * @package modules.admin
 */
class GroupsAdminModule extends AdminModule {
	
	private $oListWidget;

	public function __construct() {
		$this->oListWidget = new GroupListWidgetModule();
	}
	
	public function mainContent() {
		return $this->oListWidget->doWidget();
	}

	public function usedWidgets() {
		return array($this->oListWidget);
	}
}
