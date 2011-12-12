<?php
/**
 * @package modules.widget
 */
class StringCheckWidgetModule extends PersistentWidgetModule {

	private $aLogMessages = array();
	private static $CHECK_OPTIONS = array("static strings");

	const LOG_LEVEL_INFO = 0;
	const LOG_LEVEL_NOTICE = 2;
	const LOG_LEVEL_WARNING = 4;
	const LOG_LEVEL_ERROR = 6;
	
	public function __construct($sWidgetId) {
		parent::__construct($sWidgetId);
	}
	
	public function checkOptions() {
		return self::$CHECK_OPTIONS;
	}
	
	public function check($sCheckName) {
		switch($sCheckName) {
			case "static strings":
				return $this->checkStaticStrings();
			break;
		}
	}
	
	private function checkStaticStrings() {
		$aLanguageFiles = array_merge(ResourceFinder::findResourceByExpressions(array(DIRNAME_LANG, "/^.+\.ini$/"), ResourceFinder::SEARCH_SITE_FIRST), ResourceFinder::findResourceByExpressions(array(DIRNAME_MODULES, ResourceFinder::ANY_NAME_OR_TYPE_PATTERN, ResourceFinder::ANY_NAME_OR_TYPE_PATTERN, DIRNAME_LANG, "/^.+\.ini$/"), ResourceFinder::SEARCH_SITE_FIRST));
		
		$aSortedLanugageFiles = array();
		foreach($aLanguageFiles as $sRelativePath => $sAbsolutePath) {
			$aPathParts = array();
			preg_match("/(([^\/]+\/)+)(.+)\.ini/", $sRelativePath, $aPathParts);
			$sPathPrefix = $aPathParts[1];
			$sLanguageId = $aPathParts[3];
			if(!isset($aSortedLanugageFiles[$sPathPrefix])) {
				$aSortedLanugageFiles[$sPathPrefix] = array();
			}
			$aSortedLanugageFiles[$sPathPrefix][] = $sLanguageId;
		}
		
		foreach($aSortedLanugageFiles as $sPathPrefix => $aLanguageIds) {
			$this->log("Checking static strings in $sPathPrefix");
			$aAllStrings = array();
			$aAllLanguageFileContents = array();
			foreach($aLanguageIds as $sLanguageId) {
				$aLanguageFilePaths = ResourceFinder::findAllResources("$sPathPrefix$sLanguageId.ini", ResourceFinder::SEARCH_SITE_FIRST);
				$aAllLanguageFileContents[$sLanguageId] = parse_ini_file($aLanguageFilePaths[0]);
				if(isset($aLanguageFilePaths[1])) {
					$aAllLanguageFileContents[$sLanguageId] = array_merge($aAllLanguageFileContents[$sLanguageId], parse_ini_file($aLanguageFilePaths[1]));
				}
				$aAllStrings = array_merge($aAllStrings, $aAllLanguageFileContents[$sLanguageId]);
			}
			$aAllStrings = array_keys($aAllStrings);
			foreach($aAllStrings as $sStringKey) {
				foreach($aAllLanguageFileContents as $sLanguageId => $aLanguageFileContents) {
					if(!isset($aLanguageFileContents[$sStringKey])) {
						$this->log("String $sStringKey does not exist in $sPathPrefix$sLanguageId.ini", self::LOG_LEVEL_WARNING);
					}
				}
			}
		}
		return $this->aLogMessages;
	}
	
	private function log($sText, $iLogLevel=0) {

		$aLog = array();
		$aLog['level'] = $iLogLevel;
		$aLog['message'] = $sText;
		$this->aLogMessages[] = $aLog;
	}
}
