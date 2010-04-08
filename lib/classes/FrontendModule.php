<?php
abstract class FrontendModule extends Module {
  protected static $MODULE_TYPE = 'frontend';
  
  protected $oLanguageObject;
  protected $oData;
  protected $aPath;
  protected $iId;
  
  public function __construct($oLanguageObject=null, $aPath=null, $iId = 1) {
    if($oLanguageObject instanceof LanguageObject) {
      $this->oLanguageObject = $oLanguageObject;
    } else {
      $this->oData = $oLanguageObject;
    }
    $this->aPath = $aPath;
    $this->iId = $iId;
  }

  public abstract function renderFrontend();

  public function save(Blob $oData) {}

  public function renderBackend() {
    return "";
  }

  public function getCssForFrontend() {
    return null;
  }

  public function getJsForFrontend() {
    return null;
  }

  public function getCssForBackend() {
    return null;
  }

  public function getJsForBackend() {
    return null;
  }

  public function getWords() {
    return StringUtil::getWords($this->renderFrontend(), true);
  }
  
  protected function constructTemplate($sTemplateName = "main", $bUseGlobalTemplatesDir = false) {
    return parent::constructTemplate($sTemplateName, $bUseGlobalTemplatesDir);
  }
  
  protected function getData() {
    if($this->oLanguageObject !== null) {
      return $this->oLanguageObject->getData()->getContents();
    }
    return $this->oData;
  }
  
  public static function listContentModules() {
    $aResult = array();
    $aModules = self::listModules();
    foreach($aModules as $sModuleName => $sModulePath) {
      $sClassName = self::getClassNameByName($sModuleName);
      $aResult[$sModuleName] = self::getDisplayNameByName($sModuleName);
    }
    return $aResult;
  }
  
  protected function getModuleSetting($sName, $sDefaultValue) {
    return Settings::getSetting($this->getModuleName(), $sName, $sDefaultValue, 'modules');
  }
  
  public static function getDirectoryForModule($sModuleName) {
    $aModules = FrontendModule::listModules();
    $sPath = $aModules[$sModuleName];
    return $sPath;
  }
  
  public static function getConfigDirectoryForModule($sModuleName) {
    return self::getDirectoryForModule($sModuleName)."/config";
  }
  
  public static function isDynamic() {
    return false;
  }
  
  /**
   * @param object language object with the data
   * description: should return some helpful information in backend content, displaying filtered unserialized language object data
   * mainly for custom modules with options
   * @return string/Template object/null
 */
  public static function getContentInfo($oLanguageObject) {
    if(!$oLanguageObject) {
      return null;
    }
    $mData = @unserialize($oLanguageObject->getData()->getContents());
    if(!$mData) {
      return null;
    }
    return var_export($mData, true);
  }
  
  //Functions which should actually be in Module superclass but can't because they rely on MODULE_TYPE
  public static function getType() {
    return self::$MODULE_TYPE;
  }
  
  public static function listModules() {
    return self::listModulesByType(self::getType());
  }
  
  public static function getClassNameByName($sModuleName) {
    return StringUtil::camelize($sModuleName, true).get_class();
  }
  
  public static function getNameByClassName($sClassName) {
    if(strpos($sClassName, get_class()) === false) {
      return $sClassName;
    }
    return StringUtil::deCamelize(substr($sClassName, 0, 0-strlen(get_class())));
  }
  
  public static function getDisplayNameByName($sModuleName, $sLangugaeId = null) {
    return self::getDisplayNameByTypeAndName(self::getType(), $sModuleName, $sLangugaeId);
  }
  
  public static function getModuleInstance($sModuleName) {
    $aArgs = func_get_args();
    array_unshift($aArgs, self::getType());
    return call_user_func_array(array("Module", "getModuleInstanceByTypeAndName"), $aArgs);
  }
  
  public function getModuleName() {
    return self::getNameByClassName(get_class($this));
  }
  
  public static function isValidModuleClassName($sName) {
    return StringUtil::endsWith($sName, StringUtil::camelize(self::$MODULE_TYPE, true)."Module");
  }
}
