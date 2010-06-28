<?php
/**
  * @package modules.frontend
  */
class TextFrontendModule extends FrontendModule {
  
  private static $TEXT_ENCODING = "utf-8";
  
  private $oRichtextUtil;
  
  public function __construct($oLanguageObject = null, $aRequestPath = null, $iId = 1) {
    
    parent::__construct($oLanguageObject, $aRequestPath, $iId);
    $this->oRichtextUtil = new RichtextUtil("text_module_editor_$iId");
    $this->oRichtextUtil->setTrackReferences($this->oLanguageObject);
  }
  
  public function renderFrontend() {
    return RichtextUtil::parseStorageForFrontendOutput($this->getData());
  }
  
  public function renderBackend() {
    $oTemplate = $this->constructTemplate('main_admin');
    $oTemplate->replaceIdentifier("textarea_id", $this->oRichtextUtil->getAreaName());
    $oTemplate->replaceIdentifier("text", RichtextUtil::parseStorageForBackendOutput($this->getData()));
    return $oTemplate;
  }

  public function getJsForBackend() {
    return $this->oRichtextUtil->getJavascript();
  }
  
  public function getSaveData() {
    return $this->oRichtextUtil->parseInputFromMce();
  }
  
  public static function getContentInfo($oLanguageObject) {
    $sText = RichtextUtil::parseStorageForFrontendOutput(stream_get_contents($oLanguageObject->getData()));
    return implode(" ", StringUtil::getWords($sText, true));
  }
}
?>