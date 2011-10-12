<?php
/**
* @package modules.widget
*/
class GenericFrontendModuleWidgetModule extends PersistentWidgetModule {
	private $oFrontendModule;
	private $oInternalWidget;
	
	public function __construct($sSessionKey, $oFrontendModule, $mInternalWidget = null) {
		parent::__construct($sSessionKey);
		$this->oFrontendModule = $oFrontendModule;
		if($mInternalWidget instanceof WidgetModule || $mInternalWidget instanceof Template || is_string($mInternalWidget)) {
			$this->oInternalWidget = $mInternalWidget;
		} else if($mInternalWidget === null) {
			$this->oInternalWidget = $oFrontendModule->widgetData();
		}
	}
		
	public function setObjectId($iObjectId) {
		if($this->oInternalWidget instanceof RichTextWidgetModule) {
			$oContentObject = ContentObjectPeer::retrieveByPK($iObjectId);
			$oPage = PageQuery::create()->filterByContentObject($oContentObject)->findOne();
			$this->oInternalWidget->setTemplate($oPage->getTemplateNameUsed());
		}
	}
	
	public function currentData() {
		return $this->oFrontendModule->widgetData();
	}
	
	public function doWidget() {
		if(is_string($this->oInternalWidget)) {
			return TagWriter::quickTag('div', array(), $this->oInternalWidget);
		} else if($this->oInternalWidget instanceof Template) {
			return TagWriter::quickTag('form', array(), $this->oInternalWidget);
		}
		return $this->oInternalWidget->doWidget();
	}
	
	public function saveData($mData) {
		return $this->oFrontendModule->widgetSave($mData);
	}
}
