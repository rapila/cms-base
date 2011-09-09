<?php
/**
 * Module is the base class for all modules. There are currently five types of modules: page type, filter, file, frontend and admin modules. Read the description in those files to see what they do.
 * All modules are found in the folder modules/module_type under either the root or site folder
 *
 * Modules always have the following directory structure:
 *
 * <pre>
 * module_name/
 *	templates/ (optional, can be read with $this->{@link constructTemplate}('name') inside the module)
 *	lang/ (optional, contains translation files with strings)
 *	ModuleNameModuleTypeModule.php (contains the actual module code)
 *	info.yml (optional) contains info about the module as well as permission settings
 * </pre>
 * @see PageTypeModule
 * @see FrontendModule
 * @see AdminModule
 * @see FileModule
 * @see FilterModule
 */
abstract class Module {
	const INFO_FILE = "info.yml";
	
	protected static $MODULE_TYPE;
	private static $MODULE_TYPE_LIST = null;
	private static $MODULE_LIST = array();
	private static $MODULES_METADATA_LIST = array();
	private static $SINGLETONS = array();
	
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
		
		if($sClassName::isSingleton()) {
			if(!isset(self::$SINGLETONS[$sClassName])) {
				try {
					self::$SINGLETONS[$sClassName] = $oClass->newInstanceArgs($aArgs);
				} catch(ReflectionException $ex) {
					self::$SINGLETONS[$sClassName] = $oClass->newInstance();
				}
			}
			return self::$SINGLETONS[$sClassName];
		}
		try {
			return $oClass->newInstanceArgs($aArgs); //Does not work in PHP < 5.1.3
		} catch(ReflectionException $ex) {
			return $oClass->newInstance(); //Does not work in PHP < 5.1.3
		}
	}
	
	public static function getClassNameByTypeAndName($sType, $sName = '') {
		return StringUtil::camelize($sName, true).StringUtil::camelize($sType, true).get_class();
	}
	
	public static function getDisplayNameByTypeAndName($sType, $sName, $sLanguageId = null) {
		$sDisplayName = StringPeer::getString("module.$sType.$sName", $sLanguageId, "");
		if($sDisplayName === "") {
			$aModuleInfo = self::getModuleInfoByTypeAndName($sType, $sName);
			if(isset($aModuleInfo['name'])) {
				$sDisplayName = $aModuleInfo['name'];
			} else {
				$sDisplayName = StringUtil::makeReadableName($sName);
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
	
	public static function isModuleAllowed($sType, $sName, $oUser = null) {
		if($oUser === null) {
			if(!self::isModuleEnabled($sType, $sName)) {
				return false;
			}
			$aModuleInfo = Module::getModuleInfoByTypeAndName($sType, $sName);
			//Access to module is unrestricted: allow
			if(!isset($aModuleInfo['allowed_roles']) || !is_array($aModuleInfo['allowed_roles'])) {
				return true;
			}
			return false;
		} else {
			return $oUser->mayUseModuleOfTypeAndName($sType, $sName);
		}
	}
	
	/**
	* Fetches all module metadata (including module info obtained from the info.yml files) and stores it into a static field, returns it
	*/
	public static function getModuleMetadataByTypeAndName($sType, $sName) {
		$aModuleMetadata = @self::$MODULES_METADATA_LIST[$sType][$sName];
		if($aModuleMetadata !== null) {
			return $aModuleMetadata;
		}
		$oInfoFileFinder = ResourceFinder::create(array(DIRNAME_MODULES, $sType, $sName, self::INFO_FILE))->all();
		$oCache = new Cache("module_md_$sType-$sName", DIRNAME_PRELOAD);
		if($oCache->cacheFileExists() && !$oCache->isOutdated($oInfoFileFinder)) {
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
			$aFolders = ResourceFinder::findResourceObjectsByExpressions(array(DIRNAME_MODULES, $sType, $sName, ResourceFinder::ANY_NAME_OR_TYPE_PATTERN));
			foreach($aFolders as $oFolder) {
				$aModuleMetadata['folders'][] = $oFolder->getFileName();
			}
		
			//Module-info
			$aModuleInfo = array();
			require_once("spyc/Spyc.php");
			foreach($oInfoFileFinder->find() as $sPath) {
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
	
	public static function moduleExists($sModuleName, $sType=null) {
		$aModules = self::listModulesByType($sType);
		return isset($aModules[$sModuleName]);
	}
	
	public static function listModulesByType($sType, $bListEnabledOnly = true) {
		if($sType === null) {
			$sType = ResourceFinder::ANY_NAME_OR_TYPE_PATTERN;
		}
		
		if(isset(self::$MODULE_LIST[$sType]) && !$bListEnabledOnly) {
			return self::$MODULE_LIST[$sType];
		}
		
		$aPaths = ResourceFinder::findResourcesByExpressions(array(DIRNAME_MODULES, $sType, ResourceFinder::ANY_NAME_OR_TYPE_PATTERN));
		
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
		ksort($aResult);
		return $aResult;
	}
	
	public static function listModulesByTypeAndAspect($sType, $sAspect, $bListEnabledOnly = true) {
		$aResult = array();
		foreach(self::listModulesByType($sType, $bListEnabledOnly) as $sName => $aMetadata) {
			if(isset($aMetadata['module_info']['aspects']) && in_array($sAspect, $aMetadata['module_info']['aspects'])) {
				$aResult[$sName] = $aMetadata;
			}
		}
		return $aResult;
	}
	
	public static function listModuleTypes() {
		if(self::$MODULE_TYPE_LIST === null) {
			$aPaths = ResourceFinder::findResourceObjectsByExpressions(array(DIRNAME_MODULES, ResourceFinder::ANY_NAME_OR_TYPE_PATTERN));
			self::$MODULE_TYPE_LIST = array();
			foreach($aPaths as $oPath) {
				self::$MODULE_TYPE_LIST[] = $oPath->getFileName();
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
	
	public static function getType() {
		return static::$MODULE_TYPE;
	}
	
	public static function listModules($bListEnabledOnly = true) {
		return self::listModulesByType(self::getType(), $bListEnabledOnly);
	}
	
	public static function listModulesByAspect($sAspect, $bListEnabledOnly = true) {
		return self::listModulesByTypeAndAspect(self::getType(), $sAspect, $bListEnabledOnly);
	}
	
	public static function getClassNameByName($sModuleName) {
		return StringUtil::camelize($sModuleName, true).get_called_class();
	}
	
	public static function getNameByClassName($sClassName) {
		$sModuleTypeClassName = StringUtil::camelize(static::$MODULE_TYPE, true)."Module";
		if(strpos($sClassName, $sModuleTypeClassName) === false) {
			return $sClassName;
		}
		return StringUtil::deCamelize(substr($sClassName, 0, 0-strlen($sModuleTypeClassName)));
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
		return StringUtil::endsWith($sName, StringUtil::camelize(self::getType(), true)."Module");
	}
	
	public static function isValidModuleClassNameOfAnyType($sName) {
		return StringUtil::endsWith($sName, "Module");
	}
	
	public function getModuleInfo() {
		return self::getModuleInfoByTypeAndName($this->getType(), $this->getModuleName());
	}
	
	public function getDisplayName($sLanguageId = null) {
		return self::getDisplayNameByTypeAndName($this->getType(), $this->getModuleName(get_class($this)), $sLanguageId);
	}

	public static function isSingleton() {
		return false;
	}
	
	/**
	 * Returns an instance of {@link Template} loaded from a file in the module's directory (or the directory of the same name in the site/modules dir if the module is internal)
	 * @param string $sTemplateName the template name to be used, defaults to the model name
	 * @param boolean $bForceGlobalTemplatesDir if set to true causes the template to be loaded from the global templates directory (internal or external) instead of the module's local one
	 */
	protected function constructTemplate($sTemplateName = null, $bForceGlobalTemplatesDir = false) {
		return self::constructTemplateForModuleAndType(self::getType(), $this->getModuleName(), $sTemplateName, $bForceGlobalTemplatesDir);
	}
}
