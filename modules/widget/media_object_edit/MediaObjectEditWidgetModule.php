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
}