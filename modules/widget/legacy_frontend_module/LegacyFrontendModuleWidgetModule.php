<?php
/**
* @package modules.widget
*/
class LegacyFrontendModuleWidgetModule extends PersistentWidgetModule {
	private $oFrontendModule;
	
	public function __construct($sSessionKey, FrontendModule $oFrontendModule) {
		parent::__construct($sSessionKey);
		$this->oFrontendModule = $oFrontendModule;
	}
	
	public static function includeResources($oResourceIncluder = null) {
		if($oResourceIncluder === null) {
			$oResourceIncluder = ResourceIncluder::defaultIncluder();
		}
		$oResourceIncluder->addReverseDependency('lib_prototype', false, 'preview/prototype_json_fix.js');
		$oResourceIncluder->addJavaScriptLibrary('prototype', 1.6);
		self::includeWidgetResources(false, $oResourceIncluder);
	}
	
	public function getModuleBackend() {
		$mResult = $this->oFrontendModule->renderBackend();
		if($mResult instanceof Template) {
			return $mResult->render();
		}
		return $mResult;
	}
	
	public function getBackendJs() {
		if(!method_exists($this->oFrontendModule, 'getJsForBackend')) {
			return '';
		}
		$mResult = $this->oFrontendModule->getJsForBackend();
		if($mResult instanceof Template) {
			return $mResult->render();
		}
		return $mResult;
	}
	
	public function getBackendCss() {
		if(!method_exists($this->oFrontendModule, 'getCssForBackend')) {
			return '';
		}
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