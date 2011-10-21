<?php
class FrontendConfigWidgetModule extends PersistentWidgetModule {
	protected $oFrontendModule;

	public function __construct($sSessionKey, $oFrontendModule) {
		parent::__construct($sSessionKey);
		$this->oFrontendModule = $oFrontendModule;
	}

	public function configData() {
		return $this->oFrontendModule->widgetData();
	}

	///Synchronous alias for configData
	public function getConfigData() {
		return $this->configData();
	}

	public function updatePreview() {
		return null;
	}
	
	public function getElementType() {
		return 'form';
	}
}
