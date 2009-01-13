<?php
/**
 * class Settings
 */
class Settings {
  
  private $aSettings;
  private static $INSTANCES = array();
  
  /**
   * __construct()
   */
  private function __construct($sFileName) {
    require_once("spyc/Spyc.php");
    $aConfigPaths = ResourceFinder::findAllResources(array(DIRNAME_CONFIG, $sFileName), ResourceFinder::SEARCH_SITE_FIRST);
    $this->aSettings = array();
    foreach($aConfigPaths as $sConfigPath) {
      foreach(Spyc::YAMLLoad($sConfigPath) as $sSection => $aSection) {
        foreach($aSection as $sKey => $mValue) {
          if(!isset($this->aSettings[$sSection])) {
            $this->aSettings[$sSection] = array();
          }
          $this->aSettings[$sSection][$sKey] = $mValue;
        }
      }
    }
  } // getInstance();
    
  /**
   * getConfigurationSetting()
   * @param string cms.yml section name
   * @param string section var key
   * @param mixed default value
   * @return mixed value
   */
  public function _getSetting($sSection, $sKey, $mDefaultValue) {
    $aSettingsPart = $this->aSettings;
    if($sSection !== null) {
      if(!isset($aSettingsPart[$sSection])) {
        return $mDefaultValue;
      }
      $aSettingsPart = $aSettingsPart[$sSection];
    }
    if(!isset($aSettingsPart[$sKey])) {
      return $mDefaultValue;
    }
    return $aSettingsPart[$sKey];
  }
  
  public function getSettingsArray() {
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

  public static function getInstance($sFileName=null) {
    if($sFileName === null) {
      $sFileName = "config";
    }
    $sFileName = $sFileName.".yml";
    if(!isset(self::$INSTANCES[$sFileName])) {
      $oCache = new Cache($sFileName, DIRNAME_CONFIG);
      if($oCache->cacheFileExists() && !$oCache->isOutdated(ResourceFinder::findAllResources(array(DIRNAME_CONFIG, $sFileName)))) {
        self::$INSTANCES[$sFileName] = $oCache->getContentsAsVariable();
      } else {
        self::$INSTANCES[$sFileName] = new Settings($sFileName);
        $oCache->setContents(self::$INSTANCES[$sFileName]);
      }
    }
    return self::$INSTANCES[$sFileName];
  }
  
}
