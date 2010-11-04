<?php
/**
 * @package modules.frontend
 */
 
class EmptyFrontendModule extends FrontendModule implements WidgetBasedFrontendModule {

	public function __construct($oLanguageObject, $aRequestPath = null) {
		parent::__construct($oLanguageObject, $aRequestPath);
	}

	public function renderFrontend() {
		return "";
	}

	public function renderBackend() {
		return $this->constructTemplate('backend');
	}

	public function getSaveData() {
		return "";
	}
	
	public function widgetData() {
		return '';	
	}
	
	public function widgetSave($mData) {
		return $this->oLanguageObject->setData('')->save();
	}
	
	public function getWidget() {
		return new GenericFrontendModuleWidgetModule(null, $this, StringPeer::getString('widget.empty.confirm'));
	}
}
