<?php

class MediaObjectEditWidgetModule extends PersistentWidgetModule {
	private $oFrontendModule;
	private $sDisplayMode;
	
	public function __construct($sSessionKey, $oFrontendModule) {
		parent::__construct($sSessionKey);
		$this->oFrontendModule = $oFrontendModule;
	}
	
	public function getElementType() {
		return new TagWriter('form', array(), $this->constructTemplate('edit'));
	}
	
	public function renderPreview($aPostData) {
		$sModuleData = $this->oFrontendModule->dataFromPost($aPostData);
		$oModule = FrontendModule::getModuleInstance('media_object', $sModuleData);
		return $oModule->renderFrontend()->render();
	}
	
	public function mimetypeFor($sId, $sUrl) {
		return $this->oFrontendModule->mimetypeFor($sId, $sUrl);
	}
	
	public function currentData() {
		return $this->oFrontendModule->widgetData();
	}
	
	public function saveData($mData) {
		return $this->oFrontendModule->widgetSave($mData);
	}
}