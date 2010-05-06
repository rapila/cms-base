<?php
/**
 * @package modules.admin
 */
class LanguagesAdminModule extends AdminModule {
	
	private $oListWidget;
	
	public function __construct() {
		$this->oListWidget = new LanguageListWidgetModule();
	}
	
	public function mainContent() {
		return $this->oListWidget->doWidget();
	}

	public function usedWidgets() {
		return array($this->oListWidget);
	}
}
