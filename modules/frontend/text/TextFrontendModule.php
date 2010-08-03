<?php
/**
	* @package modules.frontend
	*/
class TextFrontendModule extends FrontendModule implements WidgetBasedFrontendModule {
	
	private static $TEXT_ENCODING = "utf-8";
	
	public function __construct($oLanguageObject = null, $aRequestPath = null, $iId = 1) {
		parent::__construct($oLanguageObject, $aRequestPath, $iId);
	}
	
	public function renderFrontend() {
		return RichtextUtil::parseStorageForFrontendOutput($this->getData());
	}
	
	public function getWidget() {
		return WidgetModule::getWidget('generic_frontend_module', null, $this, WidgetModule::getWidget('rich_text', null, $this->widgetData()));
	}
	
	public function widgetData() {
	  if($this->oLanguageObject->getData() === null) {
  	  return null;
	  }
		return stream_get_contents($this->oLanguageObject->getData());
	}
	
	public function widgetSave($sContents) {
		$oRichtextUtil = new RichtextUtil();
		$oRichtextUtil->setTrackReferences($this->oLanguageObject);
		$this->oLanguageObject->setData($oRichtextUtil->parseInputFromMce($sContents));
		return $this->oLanguageObject->save();
	}

	public static function getContentInfo($oLanguageObject) {
		$sText = RichtextUtil::parseStorageForFrontendOutput(stream_get_contents($oLanguageObject->getData()));
		return implode(" ", StringUtil::getWords($sText, true));
	}
}
?>