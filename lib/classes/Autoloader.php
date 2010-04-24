<?php
require_once(BASE_DIR."/".DIRNAME_LIB."/".DIRNAME_CLASSES."/ResourceFinder.php");
require_once(BASE_DIR."/".DIRNAME_LIB."/".DIRNAME_CLASSES."/Cache.php");

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
		
		$sIncludeFilePath = self::findIncludePath($sClassName);
	
		if($sIncludeFilePath === null) {
			throw new ClassNotFoundException("Could not find file for loading of class $sClassName", $sClassName);	
		}
		
		self::$CLASS_MAPPING[$sClassName] = $sIncludeFilePath;
		self::$MAPPING_HAS_BEEN_MODIFIED = true;
		require_once($sIncludeFilePath);
		return true;
	}
	
	public static function saveIncludeCache() {
		if(self::$MAPPING_HAS_BEEN_MODIFIED) {
			self::$INCLUDE_CACHE->setContents(self::$CLASS_MAPPING);
		}
	}
	
	private static function findIncludePath($sClassName) {
		$sFileName = "$sClassName.php";
		
		//Standard Classes
		$sPath = ResourceFinder::findResource(array(DIRNAME_CLASSES, $sFileName));
		if($sPath) {
			return $sPath;
		}
	
		//Generated Model classes
		$sPath = ResourceFinder::findResource(array(DIRNAME_GENERATED, DIRNAME_MODEL, $sFileName), ResourceFinder::SEARCH_MAIN_ONLY);
		if($sPath) {
			return $sPath;
		}
	
		//Model classes
		$sPath = ResourceFinder::findResource(array(DIRNAME_MODEL, $sFileName));
		if($sPath) {
			return $sPath;
		}
	
		if(Module::isValidModuleClassNameOfAnyType($sClassName)) {
			foreach(Module::listModuleTypes() as $sModuleType) {
				$sModuleBaseClass = Module::getClassNameByTypeAndName($sModuleType);
				if(!class_exists($sModuleBaseClass)) {
					continue;
				}
			
				if(call_user_func(array($sModuleBaseClass, 'isValidModuleClassName'), $sClassName)) {
					$sPath = ResourceFinder::findResource(array(DIRNAME_MODULES, $sModuleType, call_user_func(array($sModuleBaseClass, 'getNameByClassName'), $sClassName), $sFileName));
					if($sPath) {
						return $sPath;
					}
				}
			}
		}
		return null;
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