<?php
///Reads and consolidates .yml files from the config dirs for the current environment.
class Settings {
	private $aSettings;
	private static $INSTANCES = array();
	
	/**
	 * __construct()
	 */
	private function __construct($oFinder) {
		require_once("spyc/Spyc.php");
		$oSpyc = new Spyc();
		$oSpyc->setting_use_syck_is_possible = true;
		$aConfigPaths = $oFinder->find();
		$this->aSettings = array();
		foreach($aConfigPaths as $sConfigPath) {
			foreach($oSpyc->loadFile($sConfigPath) as $sSection => $aSection) {
				foreach($aSection as $sKey => $mValue) {
					if(!isset($this->aSettings[$sSection])) {
						$this->aSettings[$sSection] = array();
					}
					$this->aSettings[$sSection][$sKey] = $mValue;
				}
			}
		}
	}
		
	/**
	 * @param string $sSection config.yml section name
	 * @param string $sKey section var key
	 * @param mixed $mDefaultValue default value
	 * @return string|int|float|array The setting value
	 */
	public function _getSetting($sSection, $sKey, $mDefaultValue) {
		if(isset($_REQUEST["setting-override-$sSection/$sKey"]) && Session::getSession()->isBackendAuthenticated()) {
			return $_REQUEST["setting-override-$sSection/$sKey"];
		}
		$aSettingsPart = $this->aSettings;
		if($sSection !== null) {
			if(!isset($aSettingsPart[$sSection])) {
				return $mDefaultValue;
			}
			$aSettingsPart = $aSettingsPart[$sSection];
		}
		if($sKey === null) {
			return $aSettingsPart;
		}
		if(!isset($aSettingsPart[$sKey])) {
			return $mDefaultValue;
		}
		return $aSettingsPart[$sKey];
	}
	
	public function &getSettingsArray($sSection = null) {
		return $this->aSettings;
	}
	
	public static function getSetting($sSection, $sKey, $mDefaultValue, $sPath = null) {
		return self::getInstance($sPath)->_getSetting($sSection, $sKey, $mDefaultValue);
	}
	
	public function _getSettingIf($mCondition, $sSection, $sKey, $mDefaultValue) {
		if($mCondition !== null) {
			return $mCondition;
		}
		return $this->_getSetting($sSection, $sKey, $mDefaultValue);
	}

	public static function getSettingIf($mCondition, $sSection, $sKey, $mDefaultValue, $sPath = null) {
		return self::getInstance($sPath)->_getSettingIf($mCondition, $sSection, $sKey, $mDefaultValue);
	}
	
	public static function createCacheKey($sFileName) {
		return "$sFileName.yml-".ErrorHandler::getEnvironment();
	}

	public static function getInstance($sFileName=null) {
		if($sFileName === null) {
			$sFileName = "config";
		}
		$sCacheKey = self::createCacheKey($sFileName);
		$sFileName = "$sFileName.yml";
		if(!isset(self::$INSTANCES[$sCacheKey])) {
			$oCache = new Cache($sCacheKey, DIRNAME_CONFIG);
			$oFinder = ResourceFinder::create(array(DIRNAME_CONFIG))->addOptionalPath(ErrorHandler::getEnvironment())->addPath($sFileName)->byExpressions()->searchBaseFirst()->all();
			if($oCache->cacheFileExists() && !$oCache->isOutdated($oFinder)) {
				self::$INSTANCES[$sCacheKey] = $oCache->getContentsAsVariable();
			} else {
				self::$INSTANCES[$sCacheKey] = new Settings($oFinder);
				$oCache->setContents(self::$INSTANCES[$sCacheKey]);
			}
		}
		return self::$INSTANCES[$sCacheKey];
	}
	
}
