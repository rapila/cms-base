<?php

abstract class FileModule extends Module {
  protected static $MODULE_TYPE = 'file';
  
  protected $aPath;
  
  public function __construct($aRequestPath) {
    $this->aPath = $aRequestPath;
  }
  
  public abstract function renderFile();
  
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