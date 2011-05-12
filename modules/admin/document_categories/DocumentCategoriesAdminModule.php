<?php
/**
 * @package modules.admin
 */
class DocumentCategoriesAdminModule extends AdminModule {
	
	private $oListWidget;
	
	public function __construct() {
		$this->oListWidget = new DocumentCategoryListWidgetModule();
	}
	
	public function mainContent() {
		return $this->oListWidget->doWidget();
	}
	
	public function sidebarContent() {
		return false;
	}

	public function usedWidgets() {
		return array($this->oListWidget);
	}
}
