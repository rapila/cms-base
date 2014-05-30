<?php
/**
	* @package modules.frontend
	*/
class TextFrontendModule extends FrontendModule {
	
	private static $TEXT_ENCODING = "utf-8";
	
	public function __construct($oLanguageObject = null, $aRequestPath = null, $iId = 1) {
		parent::__construct($oLanguageObject, $aRequestPath, $iId);
	}
	
	public function renderFrontend() {
		return RichtextUtil::parseStorageForFrontendOutput($this->getData());
	}
	
	public function getWidget() {
		$oRichTextWidget = WidgetModule::getWidget('rich_text', null, $this->widgetData(), 'admin');
		$aToolbarSettings = Settings::getSetting('text_module','toolbar', null);
		$oRichTextWidget->setSetting('contentsLanguage', $this->oLanguageObject->getLanguageId());
		$oGenericWidget = WidgetModule::getWidget('generic_frontend_module', null, $this, $oRichTextWidget);
		$oGenericWidget->setSetting('preferred_width', $oRichTextWidget->getSettings('richtext_width', 600));
    
		return $oGenericWidget;
	}
	
	public function widgetData() {
		$sData = $this->getData();
		if($sData) {
			return RichtextUtil::parseStorageForBackendOutput($sData)->render();
		}
		return '';
	}
	
	public function getJsForFrontend() {
		if(Settings::getSetting("frontend", "protect_email_addresses", false)) {
			ResourceIncluder::defaultIncluder()->addResource('e-mail-defuscate.js');
		}
		return null;
	}
	
	public function getSaveData($sContents) {
		$oRichtextUtil = new RichtextUtil();
		if($this->oLanguageObject instanceof LanguageObject) {
			//Not a LanguageObjectHistory instance
			$oRichtextUtil->setTrackReferences($this->oLanguageObject);
		}
		return $oRichtextUtil->parseInputFromEditor($sContents);
	}

	public static function getContentInfo($oLanguageObject) {
		$sText = RichtextUtil::parseStorageForFrontendOutput(stream_get_contents($oLanguageObject->getData()));
		return implode(" ", StringUtil::getWords($sText, true));
	}
}
