<?php
class AdminModule extends Module {
	protected static $MODULE_TYPE = 'admin';
	
	private $aResourceParameters = null;
	
	public function __construct() {
		$this->aResourceParameters = array_fill_keys(TemplateResourceFileModule::$RESOURCE_TYPES, array());
	}
	
	public function mainWidgetName() {
		return $this->getModuleName();
	}
	
	public function usedWidgets() {
		return array($this->mainWidgetName());
	}
	
	public function mainContent() {
		return null;
	}
	
	public function sidebarContent() {
		return null;
	}
	
	protected function addResourceParameter($sResourceType, $sParameterName, $sParameterValue) {
		$this->aResourceParameters[$sResourceType][$sParameterName] = $sParameterValue;
	}
	
	public function includeCustomResources($oResourceIncluder) {
		TemplateResourceFileModule::includeAvailableResources($this, false, $oResourceIncluder, $this->aResourceParameters);
	}
}