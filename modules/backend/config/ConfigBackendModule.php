<?php
require_once('spyc/Spyc.php');
/**
 * @package modules.backend
 */
class ConfigBackendModule extends BackendModule {
  
  private $sDirName = null;
  private $sFileName = null;
  
  public function __construct() {
    if(Manager::hasNextPathItem()) {
      $this->sDirName = Manager::usePath();
      if(Manager::hasNextPathItem()) {
        $this->sFileName = Manager::usePath();
      } else {
        $this->sFileName = $this->sDirName;
        $this->sDirName = DIRNAME_CONFIG;
      }
    }
  }
  
  public function getChooser() {
    $oTemplate = $this->constructTemplate();
    
    $aResult = array();
    $aConfigFilesInt = ResourceFinder::findResourceByExpressions(array(DIRNAME_CONFIG, "/[\w_-].yml/"), ResourceFinder::SEARCH_BASE_ONLY);
    $aConfigFilesExt = ResourceFinder::findResourceByExpressions(array(DIRNAME_CONFIG, "/[\w_-].yml/"), ResourceFinder::SEARCH_SITE_ONLY);
    
    foreach($aConfigFilesInt as $sFileName => $sFilePath) {
      $oTemplate->replaceIdentifierMultiple("text", '<div><a class="edit" href="'.$this->link($sFileName, array("int" => true)).'">'.$sFileName.' </a> (INT)</div>', null, Template::NO_HTML_ESCAPE);  
    }
    
    foreach($aConfigFilesExt as $sFileName => $sFilePath) {
      $oTemplate->replaceIdentifierMultiple("text", '<div><a class="edit" href="'.$this->link($sFileName).'">'.$sFileName.' </a> (EXT)</div>', null, Template::NO_HTML_ESCAPE);  
    }
    
    return $oTemplate;
  }
  
  public function getDetail() {
    if($this->sFileName === null) {
      return;
    }
    
    $sConfigFile = ResourceFinder::findResource(array(DIRNAME_CONFIG, $this->sFileName), @$_REQUEST['int'] ? ResourceFinder::SEARCH_BASE_ONLY : ResourceFinder::SEARCH_SITE_ONLY);
    $aCmsConfig = Spyc::YAMLLoad($sConfigFile);
    if(!is_array($aCmsConfig)) {
      throw new Exception('something wrong with YAMLload of Configfile '.$this->sFileName);
    }
    
    $oTemplateConfig = $this->constructTemplate("detail");
    
    $oTemplateConfig->replaceIdentifier("title", $this->sFileName);
    $oTemplateConfig->replaceIdentifier("action", $this->link($this->sFileName));
    
  	ob_start();
  	var_dump($aCmsConfig);
  	$sCmsConfig = ob_get_contents();
  	ob_end_clean();
    $oTemplateConfig->replaceIdentifier("config", $sCmsConfig);
    
    $oTemplateConfig->replaceIdentifier("config_text", file_get_contents($sConfigFile));
    
    return $oTemplateConfig;
  }
}
