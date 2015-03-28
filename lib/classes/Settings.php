<?php
///Reads and consolidates .yml files from the config dirs for the current environment.
class Settings {
	private $aSettings;
	private $sFile;
	private static $INSTANCES = array();
	
	/// This contains manual overrides for unit tests.
	/// Will be reset for every test case.
	private static $OVERRIDES = null;

	/**
	 * __construct()
	 */
	private function __construct($oFinder, $sFile) {
		require_once("spyc/Spyc.php");
		$oSpyc = new Spyc();
		$oSpyc->setting_use_syck_is_possible = false;
		$aConfigPaths = $oFinder->find();
		$this->aSettings = array();
		foreach($aConfigPaths as $sConfigPath) {
			// Consolidate sections from all files
			foreach($oSpyc->load(self::replaceEnvVars(file_get_contents($sConfigPath))) as $sSection => $aSection) {
				// Ignore empty sections or non-array sections
				if(!is_array($aSection)) {
					continue;
				}
				if(!isset($this->aSettings[$sSection])) {
					$this->aSettings[$sSection] = array();
				}
				foreach($aSection as $sKey => $mValue) {
					$this->aSettings[$sSection][$sKey] = $mValue;
				}
			}
		}
		$this->sFile = $sFile;
	}

	/**
	 * @param string $sSection config.yml section name
	 * @param string $sKey section var key
	 * @param mixed $mDefaultValue default value
	 * @return string|int|float|array The setting value
	 */
	public function _getSetting($sSection, $sKey, $mDefaultValue) {
		if(self::$OVERRIDES !== null) {
			// self::$OVERRIDES will be null unless environment is “test”
			if($sKey !== null && isset(self::$OVERRIDES[$this->sFile][$sSection][$sKey])) {
				return self::$OVERRIDES[$this->sFile][$sSection][$sKey];
			}
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

	public static function getInstance($sFile=null) {
		if($sFile === null) {
			$sFile = "config";
		}
		$sCacheKey = self::createCacheKey($sFile);
		$sFileName = "$sFile.yml";
		if(!isset(self::$INSTANCES[$sCacheKey])) {
			$oCache = new Cache($sCacheKey, DIRNAME_CONFIG, CachingStrategyFile::create());
			$oFinder = ResourceFinder::create(array(DIRNAME_CONFIG))->addOptionalPath(ErrorHandler::getEnvironment())->addPath($sFileName)->byExpressions()->searchBaseFirst()->all();
			if($oCache->entryExists() && !$oCache->isOutdated($oFinder)) {
				self::$INSTANCES[$sCacheKey] = $oCache->getContentsAsVariable();
			} else {
				self::$INSTANCES[$sCacheKey] = new Settings($oFinder, $sFile);
				$oCache->setContents(self::$INSTANCES[$sCacheKey]);
			}
		}
		return self::$INSTANCES[$sCacheKey];
	}

	private static function replaceEnvVars($sInput) {
		$aSearch = array();
		$aReplace = array();
		foreach((empty($_ENV) ? $_SERVER : $_ENV) as $sEnvVarName => $sEnvVarValue) {
			if(!is_string($sEnvVarValue)) {
				continue;
			}
			$aSearch[] = "#{{$sEnvVarName}}";
			$aReplace[] = $sEnvVarValue;
		}
		return str_replace($aSearch, $aReplace, $sInput);
	}
	
	/**
	* Adds test case override
	*/
	public static function addOverride($sSection, $sKey, $mValue, $sPath = null) {
		if(self::$OVERRIDES === null) {
			return;
		}
		if($sPath === null) {
			$sPath = "config";
		}
		self::$OVERRIDES[$sPath][$sSection][$sKey] = $mValue;
	}
	
	/**
	* Removes test case overrides
	*/
	public static function clearOverrides() {
		if(ErrorHandler::getEnvironment() === 'test') {
			self::$OVERRIDES = array();
		} else {
			self::$OVERRIDES = null;
		}
	}

}
