<?php
/**
 * Module is the base class for all modules. There are currently three types of modules, page types, frontend and backend modules. Read the description in those files to see what they do.
 * All modules are found in the folder modules/module_type under either the root or site folder
 *
 * Modules always have the following directory structure:
 *
 * <pre>
 * module_name/
 * 	templates/ (optional, can be read with $this->{@link constructTemplate}('name') inside the module)
 * 	lang/ (optional, contains translation files with strings)
 * 	config/  (optional, contains the schema and various yml files)
 * 		schema.xml (defines tables to be mixed into the main schema.xml file on model generation)
 * 	model/ (this is where database classes are copied after being generated)
 * 		om/
 * 		map/
 * 	ModuleNameModuleTypeModule.php (contains the actual module code)
 *  </pre>
 * @see PageTypeModule
 * @see FrontendModule
 * @see BackendModule
 * @see FileModule
 */
abstract class Module {
  const INFO_FILE = "info.yml";
  
  protected static $MODULE_TYPE;
  private static $MODULE_TYPE_LIST = null;
  private static $MODULE_LIST = array();
  private static $MODULES_METADATA_LIST = array();
  
  //Static methods
  public static function getModuleInstanceByTypeAndName($sType, $sName) {
    if($sName === '') {
      throw new Exception("Exception in Module::getModuleInstanceByTypeAndName(): module name is empty");
    }
    $sClassName = self::getClassNameByTypeAndName($sType, $sName);
    if(!self::isModuleEnabled($sType, $sName)) {
      throw new Exception("Exception in Module::getModuleInstanceByTypeAndName(): tried to instanciate disabled module $sType.$sName");
    }
    $aArgs = array_slice(func_get_args(), 2);
    $oClass = new ReflectionClass($sClassName);
    // return $oClass->newInstanceArgs($aArgs); //Does not work in PHP < 5.1.3
    return call_user_func_array(array($oClass, "newInstance"), $aArgs);
  }
  
  public static function getClassNameByTypeAndName($sType, $sName = '') {
    return Util::camelize($sName, true).Util::camelize($sType, true).get_class();
  }
  
  public static function getDisplayNameByTypeAndName($sType, $sName, $sLanguageId = null) {
    $sDisplayName = StringPeer::getString("module.$sType.$sName", $sLanguageId, "");
    if($sDisplayName === "") {
      $aModuleInfo = self::getModuleInfoByTypeAndName($sType, $sName);
      if(isset($aModuleInfo['name'])) {
        $sDisplayName = $aModuleInfo['name'];
      } else {
        $sDisplayName = Util::makeReadableName($sName);
      }
    }
    return $sDisplayName;
  }
  
  public static function getPathArrayByTypeAndName($sType, $sName) {
    return array(DIRNAME_MODULES, $sType, $sName);
  }
  
  public static function getModuleInfoByTypeAndName($sType, $sName) {
    $aModuleMetadata = self::getModuleMetadataByTypeAndName($sType, $sName);
    return @$aModuleMetadata['module_info'];
  }
  
  public static function isModuleEnabled($sType, $sName) {
    $aModuleInfo = self::getModuleInfoByTypeAndName($sType, $sName);
    return @$aModuleInfo['enabled'];
  }
  
  /**
  * Fetches all module metadata (including module info obtained from the info.yml files) and stores it into a static field, returns it
  */
  public static function getModuleMetadataByTypeAndName($sType, $sName) {
    $aModuleMetadata = @self::$MODULES_METADATA_LIST[$sType][$sName];
    if($aModuleMetadata !== null) {
      return $aModuleMetadata;
    }
    $aInfoFilePaths = ResourceFinder::findAllResources(array(DIRNAME_MODULES, $sType, $sName, self::INFO_FILE));
    $oCache = new Cache("module_md_$sType-$sName", DIRNAME_CONFIG);
    if($oCache->cacheFileExists() && !$oCache->isOutdated($aInfoFilePaths)) {
      $aModuleMetadata = $oCache->getContentsAsVariable();
    } else {
      //Module exists?
      $aModulePath = array(DIRNAME_MODULES, $sType, $sName);
      if(ResourceFinder::findResource($aModulePath) === null) {
        return null;
      }
    
      $aModuleMetadata = array();
      
      //General info
      $aModuleMetadata['path'] = $aModulePath;
      $aModuleMetadata['type'] = $sType;
      $aModuleMetadata['name'] = $sName;
    
      //Folders
      $aModuleMetadata['folders'] = array();
      $aFolders = ResourceFinder::findResourceByExpressions(array(DIRNAME_MODULES, $sType, $sName, ResourceFinder::ANY_NAME_OR_TYPE_PATTERN));
      foreach($aFolders as $sRelativeFolderPath => $sAbsoluteFolderPath) {
        $sFolderName = explode("/", $sRelativeFolderPath);
        $aModuleMetadata['folders'][] = $sFolderName[count($sFolderName)-1];
      }
    
      //Module-info
      $aModuleInfo = array();
      require_once("spyc/Spyc.php");
      foreach($aInfoFilePaths as $sPath) {
        $aModuleInfo = array_merge($aModuleInfo, Spyc::YAMLLoad($sPath));
      }
      if(!isset($aModuleInfo['enabled'])) {
        $aModuleInfo['enabled'] = true;
      }
    
      $aModuleMetadata['module_info'] = $aModuleInfo;
    
      if(!isset(self::$MODULES_METADATA_LIST[$sType])) {
        self::$MODULES_METADATA_LIST[$sType] = array();
      }
      
      $oCache->setContents($aModuleMetadata);
    }
    self::$MODULES_METADATA_LIST[$sType][$sName] = $aModuleMetadata;
    return $aModuleMetadata;
  }
  
  public static function listModulesByType($sType, $bListEnabledOnly = true) {
    if($sType === null) {
      $sType = ResourceFinder::ANY_NAME_OR_TYPE_PATTERN;
    }
    
    if(isset(self::$MODULE_LIST[$sType]) && !$bListEnabledOnly) {
      return self::$MODULE_LIST[$sType];
    }
    
    $aPaths = ResourceFinder::findResourceByExpressions(array(DIRNAME_MODULES, $sType, ResourceFinder::ANY_NAME_OR_TYPE_PATTERN));
    
    $aResult = array();
    foreach($aPaths as $sPath => $aAbsolutePath) {
      $aPathParts = explode("/", $sPath);
      
      $sName = $aPathParts[count($aPathParts)-1];
      $sType = $aPathParts[count($aPathParts)-2];
      
      $aModuleMetadata = self::getModuleMetadataByTypeAndName($sType, $sName);
      
      if(!$bListEnabledOnly || $aModuleMetadata['module_info']['enabled'] !== false) {
        $aResult[$sName] = $aModuleMetadata;
      }
    }
    
    if(!$bListEnabledOnly) {
      self::$MODULE_LIST[$sType] = $aResult;
    }
    return $aResult;
  }
  
  public static function listModuleTypes() {
    if(self::$MODULE_TYPE_LIST === null) {
      $aPaths = ResourceFinder::findResourceByExpressions(array(DIRNAME_MODULES, ResourceFinder::ANY_NAME_OR_TYPE_PATTERN));
      self::$MODULE_TYPE_LIST = array();
      foreach($aPaths as $sPath => $aAbsolutePath) {
        $aPathParts = explode("/", $sPath);
        self::$MODULE_TYPE_LIST[] = $aPathParts[count($aPathParts)-1];
      }
    }
    return self::$MODULE_TYPE_LIST;
  }
  
  public static function listAllModules($bListEnabledOnly = true) {
    return self::listModulesByType(null, $bListEnabledOnly);
  }
  
  protected static function constructTemplateForModuleAndType($sModuleType, $sModuleName, $sTemplateName = null, $bForceGlobalTemplatesDir = false) {
    if($sTemplateName === null) {
      $sTemplateName = $sModuleName;
    }
    
    $aDir = array(DIRNAME_MODULES, $sModuleType, $sModuleName, DIRNAME_TEMPLATES);
    if($bForceGlobalTemplatesDir === true) {
      $aDir = array(DIRNAME_TEMPLATES, $sModuleType);
    } else if(is_array($bForceGlobalTemplatesDir)) {
      $aDir = $bForceGlobalTemplatesDir;
    }
    
    return new Template($sTemplateName, $aDir);
  }
  
  /*
  public static abstract function getType();
  public static abstract function listModules();
  public static abstract function getClassNameByName($sModuleName);
  public static abstract function getDisplayNameByName($sModuleName, $sLanguageId = null);
  public static abstract function getModuleInstance();
  public static abstract function isValidModuleClassName($sName);
  public static abstract function getNameByClassName($sClassName);
  */
  
  public static function isValidModuleClassNameOfAnyType($sName) {
    return Util::endsWith($sName, "Module");
  }
  
  public abstract function getModuleName();
  
  public function getModuleInfo() {
    return self::getModuleInfoByTypeAndName($this->getType(), $this->getModuleName());
  }
  
  public function getDisplayName() {
    return self::getDisplayNameByTypeAndName(self::$MODULE_TYPE, $this->getModuleName(get_class($this)));
  }
  
  /**
   * Returns an instance of {@link Template} loaded from a file in the module's directory (or the directory of the same name in the site/modules dir if the module is internal)
   * @param string $sTemplateName the template name to be used, defaults to the model name
   * @param boolean $bForceGlobalTemplatesDir if set to true causes the template to be loaded from the global templates directory (internal or external) instead of the module's local one
   */
  protected function constructTemplate($sTemplateName = null, $bForceGlobalTemplatesDir = false) {
    return self::constructTemplateForModuleAndType($this->getType(), $this->getModuleName(), $sTemplateName, $bForceGlobalTemplatesDir);
  }
}