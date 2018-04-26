<?php
/**
 * @package modules.admin
 */
class LinkCategoriesAdminModule extends AdminModule {

	private $oListWidget;

	public function __construct() {
		$this->oListWidget = new LinkCategoryListWidgetModule();
		$this->oListWidget->addPaging();
	}

	public function mainContent() {
		return $this->oListWidget->doWidget();
	}

	public function usedWidgets() {
		return array($this->oListWidget);
	}
}
