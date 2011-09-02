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
		$oRichTextWidget = WidgetModule::getWidget('rich_text', null, $this->widgetData());
		$aToolbarSettings = Settings::getSetting('text_module','toolbar', null);
		if($aToolbarSettings) {
			$aResult = array();
			foreach($aToolbarSettings as $i => $aRowElements) {
				$aResult = array_merge($aResult, $aRowElements, array('/'));
			}
			array_pop($aResult);
			$oRichTextWidget->setSetting('toolbar_Full', $aResult);
		}
		$oRichTextWidget->setSetting('contentsLanguage', $this->oLanguageObject->getLanguageId());
		$oGenericWidget = WidgetModule::getWidget('generic_frontend_module', null, $this, $oRichTextWidget);
		$oGenericWidget->setSetting('preferred_width', Settings::getSetting('text_module', 'richtext_width', 600));
    
		return $oGenericWidget;
	}
	
	public function widgetData() {
		if($this->oLanguageObject->getData() === null) {
			return null;
		}
		return RichtextUtil::parseStorageForBackendOutput(stream_get_contents($this->oLanguageObject->getData()))->render();
	}
	
	public function getJsForFrontend() {
		if(Settings::getSetting("frontend", "protect_email_addresses", false)) {
			$oResourceIncluder = ResourceIncluder::defaultIncluder();
			$oResourceIncluder->startDependencies();
			$oResourceIncluder->addJavaScriptLibrary('jquery', 1);
			$oResourceIncluder->addResourceEndingDependency('e-mail-defuscate.js');
		}
		return null;
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
