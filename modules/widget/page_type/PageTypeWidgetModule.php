<?php
/**
* @package modules.widget
*/
class PageTypeWidgetModule extends PersistentWidgetModule {
	private $sPageType;
	private $oPageType;
	
	public function setPageTypeModule($oPageType) {
		$this->sPageType = $oPageType->getModuleName();
		$this->oPageType = $oPageType;
	}
	
	public function setPageType($sPageType, $iPageId, $sLanguageId = null) {
		$this->sPageType = $sPageType;
		$oPage = PageQuery::create()->findPk($iPageId);
		if($oPage === null) {
			throw new Exception("Invalid Page ID: $iPageId");
		}
		$this->oPageType = PageTypeModule::getModuleInstance($sPageType, PageQuery::create()->findPk($iPageId), null, $sLanguageId);
	}
	
	public function getPageType() {
		return $this->sPageType;
	}
	
	public function getPageTypeResources() {
		$oIncluder = new ResourceIncluder();
		TemplateResourceFileModule::includeAvailableResources(get_class($this->oPageType), false, $oIncluder);
		return $oIncluder->getIncludes()->render();;
	}

	public function getPageTypeMethods() {
		return get_class_methods($this->oPageType);
	}
	
	public function callPageTypeMethod($sMethodName) {
		$aArguments = func_get_args();
		array_shift($aArguments);
		return call_user_func_array(array($this->oPageType, $sMethodName), $aArguments);
	}
}
