<?php

require_once(BASE_DIR."/".DIRNAME_LIB."/".DIRNAME_CLASSES."/ResourceFinder.php");
require_once(BASE_DIR."/".DIRNAME_LIB."/".DIRNAME_CLASSES."/Cache.php");
require_once(BASE_DIR."/".DIRNAME_LIB."/".DIRNAME_CLASSES."/CachingStrategy.php");
require_once(BASE_DIR."/".DIRNAME_LIB."/".DIRNAME_CLASSES."/CachingStrategyFile.php");

class Autoloader {
	const CACHE_KEY = 'AUTOLOAD_CLASS_MAPPING';
	
	public static $INCLUDE_CACHE;
	public static $CLASS_MAPPING;
	public static $MAPPING_HAS_BEEN_MODIFIED;
	
	public static function loadIncludeCache() {
		$oStrategy = CachingStrategyFile::create();
		self::$INCLUDE_CACHE = new Cache(self::CACHE_KEY, DIRNAME_PRELOAD, $oStrategy);
		self::$MAPPING_HAS_BEEN_MODIFIED = false;
		if(!self::$INCLUDE_CACHE->entryExists()) {
			self::$CLASS_MAPPING = array();
			return;
		}
		self::$CLASS_MAPPING = self::$INCLUDE_CACHE->getContentsAsVariable();
	}
	
	public static function autoload($sClassName) {
		if(isset(self::$CLASS_MAPPING[$sClassName])) {
			if(self::$CLASS_MAPPING[$sClassName] === null) {
				return;
			}
			require_once(self::$CLASS_MAPPING[$sClassName]);
			return;
		}

		foreach(self::getClassFinders() as $sClassFinder) {
			$sIncludeFilePath = self::$sClassFinder($sClassName);
			if($sIncludeFilePath) {
				$sIncludeFilePath = stream_resolve_include_path($sIncludeFilePath);
				if($sIncludeFilePath === false) {
					$sIncludeFilePath = null;
					continue;
				}
				break;
			}
		}

		self::$CLASS_MAPPING[$sClassName] = $sIncludeFilePath;
		self::$MAPPING_HAS_BEEN_MODIFIED = true;
		if($sIncludeFilePath) {
			require_once($sIncludeFilePath);
		}
	}
	
	public static function saveIncludeCache() {
		if(self::$MAPPING_HAS_BEEN_MODIFIED) {
			self::$INCLUDE_CACHE->setContents(self::$CLASS_MAPPING);
		}
	}
	
	private static function getClassFinders() {
		return array_filter(get_class_methods(get_class()), function($sFinderName) {
			return strpos($sFinderName, 'find') === 0;
		});
	}
	
	private static function findRapilaClass($sClassName) {
		$sFileName = "$sClassName.php";
		$aFileName = explode('\\', $sFileName);

		//Standard Classes
		$sPath = ResourceFinder::create()->addPath(DIRNAME_LIB, DIRNAME_CLASSES)->addPaths($aFileName)->find();
		if($sPath) {
			return $sPath;
		}
	
		//Generated Model classes
		$sPath = ResourceFinder::create()->addPath(DIRNAME_GENERATED, DIRNAME_MODEL)->addPaths($aFileName)->searchMainOnly()->find();
		if($sPath) {
			return $sPath;
		}
		$sPath = ResourceFinder::create()->addPath(DIRNAME_GENERATED, DIRNAME_MODEL, false)->addPaths($aFileName)->byExpressions()->searchMainOnly()->find();
		if(($sPath = ArrayUtil::assocPeek($sPath)) !== null) {
			return $sPath;
		}
	
		//Model classes
		$sPath = ResourceFinder::create()->addPath(DIRNAME_LIB, DIRNAME_MODEL)->addPaths($aFileName)->find();
		if($sPath) {
			return $sPath;
		}
		$sPath = ResourceFinder::create()->addPath(DIRNAME_LIB, DIRNAME_MODEL, false)->addPaths($aFileName)->byExpressions()->find();
		if(($sPath = ArrayUtil::assocPeek($sPath)) !== null) {
			return $sPath;
		}
	
		if(Module::isValidModuleClassNameOfAnyType($sClassName)) {
			foreach(Module::listModuleTypes() as $sModuleType) {
				$sModuleBaseClass = Module::getClassNameByTypeAndName($sModuleType);
				if(!class_exists($sModuleBaseClass)) {
					continue;
				}

				if($sModuleBaseClass::isValidModuleClassName($sClassName)) {
					$sPath = ResourceFinder::create()->addPath(DIRNAME_MODULES, $sModuleType, $sModuleBaseClass::getNameByClassName($sClassName))->addPaths($aFileName)->find();
					if($sPath) {
						return $sPath;
					}
				}
			}
		}

		return null;
	}
	
	/**
	* Finds PSR-0 compatible classes in a vendor subdir
	*/
	private static function findVendorClass($sClassName) {
		$sClassName = ltrim($sClassName, '\\');
		$sFileName  = '';
		$sNamespace = '';
		if ($lastNsPos = strripos($sClassName, '\\')) {
			$sNamespace = substr($sClassName, 0, $lastNsPos);
			$sClassName = substr($sClassName, $lastNsPos + 1);
			$sFileName  = str_replace('\\', DIRECTORY_SEPARATOR, $sNamespace) . DIRECTORY_SEPARATOR;
		}
		$sFileName .= str_replace('_', DIRECTORY_SEPARATOR, $sClassName) . '.php';
		return $sFileName;
	}
	
	private static function findVendorLibClass($sClassName) {
		return 'lib/'.self::findVendorClass($sClassName);
	}
}
