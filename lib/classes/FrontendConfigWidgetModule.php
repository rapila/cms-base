<?php
class FrontendConfigWidgetModule extends PersistentWidgetModule {
	private $oFrontendModule;
	private $sDisplayMode;

	public function __construct($sSessionKey, $oFrontendModule) {
		parent::__construct($sSessionKey);
		$this->oFrontendModule = $oFrontendModule;
		$this->sDisplayMode = $this->oFrontendModule->widgetData();
	}

	public function getDisplayMode() {
		return $this->sDisplayMode;
	}

	public function setDisplayMode($aDisplaymode) {
		return $this->sDisplayMode = $aDisplaymode;
	}
	
	public function getElementType() {
		return 'form';
	}
}