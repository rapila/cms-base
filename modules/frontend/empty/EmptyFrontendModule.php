<?php
/**
 * @package modules.frontend
 */
 
class EmptyFrontendModule extends FrontendModule {

	public function __construct($oLanguageObject, $aRequestPath = null) {
		parent::__construct($oLanguageObject, $aRequestPath);
	}

	public function renderFrontend() {
		return '';	
	}

	public function widgetData() {
		return '';	
	}
	
	public function getSaveData($mData) {
		return '';
	}
	
	public function renderBackend() {
		return TranslationPeer::getString('wns.empty.confirm');
	}
}
