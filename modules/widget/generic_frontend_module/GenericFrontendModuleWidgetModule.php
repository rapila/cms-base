<?php
/**
* @package modules.widget
*/
class GenericFrontendModuleWidgetModule extends PersistentWidgetModule {
	private $oFrontendModule;
	private $oInternalWidget;
	
	public function __construct($sSessionKey, $oFrontendModule, $mInternalWidget) {
		parent::__construct($sSessionKey);
		$this->oFrontendModule = $oFrontendModule;
		if($mInternalWidget instanceof WidgetModule) {
			$this->oInternalWidget = $mInternalWidget;
		} else {
			$this->oInternalWidget = WidgetModule::getWidget($mInternalWidget);
		}
	}
	
	public function currentData() {
		return $this->oFrontendModule->widgetData();
	}
	
	public function doWidget() {
		return $this->oInternalWidget->doWidget();
	}
	
	public function saveData($mData) {
		return $this->oFrontendModule->widgetSave($mData);
	}
}