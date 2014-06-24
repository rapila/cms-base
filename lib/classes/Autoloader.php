<?php

require_once(BASE_DIR."/".DIRNAME_LIB."/".DIRNAME_CLASSES."/ResourceFinder.php");
require_once(BASE_DIR."/".DIRNAME_LIB."/".DIRNAME_CLASSES."/Cache.php");

class Autoloader {
	const CACHE_KEY = 'AUTOLOAD_CLASS_MAPPING';
	
	public static $INCLUDE_CACHE;
	public static $CLASS_MAPPING;
	public static $MAPPING_HAS_BEEN_MODIFIED;
	
	public static function loadIncludeCache() {
		self::$INCLUDE_CACHE = new Cache(self::CACHE_KEY, DIRNAME_PRELOAD);
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
			return false;
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
		$sPath = ResourceFinder::create()->addPath(DIRNAME_LIB, DIRNAME_CLASSES, $sFileName)->find();
		if($sPath) {
			return $sPath;
		}
	
		//Generated Model classes
		$sPath = ResourceFinder::create()->addPath(DIRNAME_GENERATED, DIRNAME_MODEL, $sFileName)->searchMainOnly()->find();
		if($sPath) {
			return $sPath;
		}
		$sPath = ResourceFinder::create()->addPath(DIRNAME_GENERATED, DIRNAME_MODEL, false, $sFileName)->byExpressions()->searchMainOnly()->find();
		if(($sPath = ArrayUtil::assocPeek($sPath)) !== null) {
			return $sPath;
		}
	
		//Model classes
		$sPath = ResourceFinder::create()->addPath(DIRNAME_LIB, DIRNAME_MODEL, $sFileName)->find();
		if($sPath) {
			return $sPath;
		}
		$sPath = ResourceFinder::create()->addPath(DIRNAME_LIB, DIRNAME_MODEL, false, $sFileName)->byExpressions()->find();
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
					$sPath = ResourceFinder::create(array(DIRNAME_MODULES, $sModuleType, $sModuleBaseClass::getNameByClassName($sClassName), $sFileName))->find();
					if($sPath) {
						return $sPath;
					}
				}
			}
		}
		
		return null;
	}
}
