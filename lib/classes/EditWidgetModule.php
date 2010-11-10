<?php
class EditWidgetModule extends PersistentWidgetModule {
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
	
	public function saveData($mData) {
		return $this->oFrontendModule->widgetSave($mData);
	}
	
	public function getElementType() {
		return 'form';
	}
}