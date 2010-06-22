<?php
class LegacyFrontendModuleWidgetModule extends PersistentWidgetModule {
	private $oFrontendModule;
	
	public function __construct($sSessionKey, $oFrontendModule) {
		parent::__construct($sSessionKey);
		$this->oFrontendModule = $oFrontendModule;
	}
	
	public function getModuleContent() {
		$sClass = get_class($this->oFrontendModule);
		// ErrorHandler::log($this->oFrontendModule->renderBackend()->render());
		return $this->oFrontendModule->renderBackend()->render();
		// return $this->oFrontendModule->renderFrontend()->render();
	}
	
	public function getBackendContents() {
		return $this->oFrontendModule->renderBackend()->render();
	}
	
}