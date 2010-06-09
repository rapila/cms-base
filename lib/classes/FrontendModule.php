<?php
abstract class FrontendModule extends Module {
	protected static $MODULE_TYPE = 'frontend';
	
	protected $oLanguageObject;
	protected $oData;
	protected $aPath;
	protected $iId;
	
	public function __construct($oLanguageObject=null, $aPath=null, $iId = 1) {
		if($oLanguageObject instanceof LanguageObject) {
			$this->oLanguageObject = $oLanguageObject;
		} else {
			$this->oData = $oLanguageObject;
		}
		$this->aPath = $aPath;
		$this->iId = $iId;
	}

	public abstract function renderFrontend();

	public function getSaveData() {}

	public function renderBackend() {
		return "";
	}

	public function getCssForFrontend() {
		return null;
	}

	public function getJsForFrontend() {
		return null;
	}

	public function getCssForBackend() {
		return null;
	}

	public function getJsForBackend() {
		return null;
	}

	public function getWords() {
		return StringUtil::getWords($this->renderFrontend(), true);
	}
	
	protected function constructTemplate($sTemplateName = "main", $bUseGlobalTemplatesDir = false) {
		return self::constructTemplateForModuleAndType($this->getType(), $this->getModuleName(), $sTemplateName, $bUseGlobalTemplatesDir);
	}
	
	protected function getData() {
		if($this->oLanguageObject !== null && $this->oLanguageObject->getData() !== null) {
			return stream_get_contents($this->oLanguageObject->getData());
		}
		return $this->oData;
	}
	
	public static function listContentModules() {
		$aResult = array();
		$aModules = self::listModules();
		foreach($aModules as $sModuleName => $sModulePath) {
			$sClassName = self::getClassNameByName($sModuleName);
			$aResult[$sModuleName] = self::getDisplayNameByName($sModuleName);
		}
		return $aResult;
	}
	
	protected function getModuleSetting($sName, $sDefaultValue) {
		return Settings::getSetting($this->getModuleName(), $sName, $sDefaultValue, 'modules');
	}
	
	public static function getDirectoryForModule($sModuleName) {
		$aModules = FrontendModule::listModules();
		$sPath = $aModules[$sModuleName];
		return $sPath;
	}
	
	public static function getConfigDirectoryForModule($sModuleName) {
		return self::getDirectoryForModule($sModuleName)."/config";
	}
	
	public static function isDynamic() {
		return false;
	}
	
	/**
	 * @param object language object with the data
	 * description: should return some helpful information in backend content, displaying filtered unserialized language object data
	 * mainly for custom modules with options
	 * @return string/Template object/null
 */
	public static function getContentInfo($oLanguageObject) {
		if(!$oLanguageObject) {
			return null;
		}
		$mData = @unserialize(stream_get_contents($oLanguageObject->getData()));
		if(!$mData) {
			return null;
		}
		return var_export($mData, true);
	}
}
