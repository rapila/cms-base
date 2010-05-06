<?php
/**
 * @package modules.admin
 */
class PagesAdminModule extends AdminModule {
	
	private $oListWidget;
	
	public function __construct() {
		$this->oListWidget = new PageListWidgetModule();
	}
	
	public function mainContent() {
		// return page details
	}	
	
	public function sidebarContent() {
		return $this->oListWidget->doWidget();
	}

	public function usedWidgets() {
		return array($this->oListWidget);
	}
}