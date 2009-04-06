<?php
/**
 */
abstract class PageTypeModule extends Module {
  protected static $MODULE_TYPE = 'page_type';
  
  protected $oPage;
  
  public function __construct(Page $oPage) {
    $this->oPage = $oPage;
  }
  
  public abstract function display(Template $oTemplate);
  public abstract function backendDisplay();
  public abstract function backendSave();
  public abstract function backendInit();
  public $backendCustomJs = "";
  
  public function setIsDynamicAndAllowedParameterPointers(&$bIsDynamic, &$aAllowedParams, $aModulesToCheck = null) {}
  
  protected function backendLink($aPath, $aParameters = array()) {
    array_unshift($aPath, "content");
    return LinkUtil::link($aPath, null, $aParameters);
  }

  /**
  * Returns the class name of the main model that is being modified at the moment by the backend module
  * Used only to assign tags using the tag panel
  * Default is null
  */
  public function getModelName() {return null;}
  
  /**
  * Returns the primary key value of the main model ({@link getModelName}) row that is being modified at the moment by the backend module
  * Used only to assign tags using the tag panel
  * Default is null
  */
  public function getCurrentId() {return null;}
  
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
  
  //Warning: different than normal
  public static function getModuleInstance() {
    $sModuleName = func_get_arg(0);
    if(!$sModuleName) {
      $sModuleName = "default";
    }
    $aArgs = func_get_args();
    array_shift($aArgs);
    array_unshift($aArgs, $sModuleName);
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