<?php

require_once(MAIN_DIR."/".DIRNAME_INCLUDES."/".DIRNAME_CLASSES."/ResourceFinder.php");
require_once(MAIN_DIR."/".DIRNAME_INCLUDES."/".DIRNAME_CLASSES."/Cache.php");

/**
* @package helpers
*/
class Autoloader {
  const CACHE_KEY = 'AUTOLOAD_CLASS_MAPPING';
  
  public static $INCLUDE_CACHE;
  public static $CLASS_MAPPING;
  public static $MAPPING_HAS_BEEN_MODIFIED;
  
  public static function loadIncludeCache() {
    self::$INCLUDE_CACHE = new Cache(self::CACHE_KEY, DIRNAME_CONFIG);
    self::$MAPPING_HAS_BEEN_MODIFIED = false;
    if(!self::$INCLUDE_CACHE->cacheFileExists(false)) {
      self::$CLASS_MAPPING = array();
      return;
    }
    self::$CLASS_MAPPING = self::$INCLUDE_CACHE->getContentsAsVariable();
  }
  
  public static function autoload($sClassName) {
    if(isset(self::$CLASS_MAPPING[$sClassName])) {
      require_once(self::$CLASS_MAPPING[$sClassName]);
      return;
    }
    
    $sFileName = "$sClassName.php";
    $sIncludeFilePath = null;
    //Standard Classes
    $sPath = ResourceFinder::findResource(array(DIRNAME_CLASSES, $sFileName));
    if($sPath) {
      $sIncludeFilePath = $sPath;
    }
  
    //Model classes
    if($sIncludeFilePath === null) {
      $sPath = ResourceFinder::findResource(array(DIRNAME_MODEL, $sFileName), ResourceFinder::SEARCH_INT_ONLY);
      if($sPath) {
        $sIncludeFilePath = $sPath;
      }
    }
  
    if($sIncludeFilePath === null && Module::isValidModuleClassNameOfAnyType($sClassName)) {
      foreach(Module::listModuleTypes() as $sModuleType) {
        $sModuleBaseClass = Module::getClassNameByTypeAndName($sModuleType);
        if(!class_exists($sModuleBaseClass)) {
          continue;
        }
      
        if(call_user_func(array($sModuleBaseClass, 'isValidModuleClassName'), $sClassName)) {
          $sPath = ResourceFinder::findResource(array(DIRNAME_MODULES, $sModuleType, call_user_func(array($sModuleBaseClass, 'getNameByClassName'), $sClassName), $sFileName));
          if($sPath) {
            $sIncludeFilePath = $sPath;
            continue;
          }
        }
      }
    }
  
    //Model classes from modules
    if($sIncludeFilePath === null) {
      $sPath = ResourceFinder::findResourceByExpressions(array(DIRNAME_MODULES, Module::ANY_NAME_OR_TYPE_PATTERN, Module::ANY_NAME_OR_TYPE_PATTERN, DIRNAME_MODEL, $sFileName));
      if(count($sPath) > 0) {
        $sIncludeFilePath = array_shift($sPath = array_values($sPath));
      }
    }
  
    if($sIncludeFilePath !== null) {
      self::$CLASS_MAPPING[$sClassName] = $sIncludeFilePath;
      self::$MAPPING_HAS_BEEN_MODIFIED = true;
      require_once($sIncludeFilePath);
      return;
    } else if(error_reporting() === 0) {
      return eval("class $sClassName {function __construct() {throw new ClassNotFoundException('Could not find file $sFileName for loading of class $sClassName', '$sClassName);}}");
    }
    throw new ClassNotFoundException("Could not find file $sFileName for loading of class $sClassName", $sClassName);  
  }
  
  public static function saveIncludeCache() {
    if(self::$MAPPING_HAS_BEEN_MODIFIED) {
      self::$INCLUDE_CACHE->setContents(self::$CLASS_MAPPING);
    }
  }
}

class ClassNotFoundException extends Exception {
  private $sClassName;
  
  public function __construct($sMessage, $sClassName) {
    $this->sClassName = $sClassName;
    parent::__construct($sMessage);
  }
  
  public function setClassName($sClassName) {
      $this->sClassName = $sClassName;
  }

  public function getClassName() {
      return $this->sClassName;
  }
}