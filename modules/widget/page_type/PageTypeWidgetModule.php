<?php
class PageTypeWidgetModule extends PersistentWidgetModule {
	private $sPageType;
	private $oPageType;
	
	public function setPageType($sPageType, $iPageId) {
		$this->sPageType = $sPageType;
		$this->oPageType = PageTypeModule::getModuleInstance($sPageType, PagePeer::retrieveByPK($iPageId));
	}
	
	public function getPageTypeJs() {
		$sResourceUrl = TemplateResourceFileModule::getAvailableResource($this->oPageType->getModuleName(), 'page_type', ResourceIncluder::RESOURCE_TYPE_JS, array());
		if($sResourceUrl === null) {
			throw new LocalizedException("widget.page_type.no_widget_js_exists", array('exception_location' => __METHOD__, 'page_type' => $this->sPageType));
		}
		return $sResourceUrl;
	}
	
	public function callPageTypeMethod($sMethodName) {
		$aArguments = func_get_args();
		array_shift($aArguments);
		return call_user_func_array(array($this->oPageType, $sMethodName), $aArguments);
	}
}