<?php
class LegacyFrontendModuleWidgetModule extends PersistentWidgetModule {
	private $oFrontendModule;
	
	public function __construct($sSessionKey, FrontendModule $oFrontendModule) {
		parent::__construct($sSessionKey);
		$this->oFrontendModule = $oFrontendModule;
	}
	
	public function getModuleBackend() {
		$mResult = $this->oFrontendModule->renderBackend();
		if($mResult instanceof Template) {
			return $mResult->render();
		}
		return $mResult;
	}
	
	public function getBackendJs() {
		$mResult = $this->oFrontendModule->getJsForBackend();
		if($mResult instanceof Template) {
			return $mResult->render();
		}
		return $mResult;
	}
	
	public function getBackendCss() {
		$mResult = $this->oFrontendModule->getCssForBackend();
		if($mResult instanceof Template) {
			return $mResult->render();
		}
		return $mResult;
	}
	
	public function saveData($aData) {
		$_REQUEST = array_merge($_REQUEST, $aData);
		$_POST = array_merge($_POST, $aData);
		$this->oFrontendModule->getLanguageObject()->setData($this->oFrontendModule->getSaveData());
		return $this->oFrontendModule->getLanguageObject()->save();
	}
	
	public function getElementType() {
		return 'form';
	}
}