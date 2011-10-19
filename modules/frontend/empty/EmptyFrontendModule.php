<?php
/**
 * @package modules.frontend
 */
 
class EmptyFrontendModule extends FrontendModule implements WidgetBasedFrontendModule {

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
		return StringPeer::getString('wns.empty.confirm');
	}
}
