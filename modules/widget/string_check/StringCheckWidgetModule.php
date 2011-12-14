<?php
/**
 * @package modules.widget
 */
class StringCheckWidgetModule extends PersistentWidgetModule {

	private $aLogMessages = array();
	private static $CHECK_OPTIONS = array("static_strings", "strings");

	private static $EMPTY_STRING_KEY = "139c4e89cdbedaf144d05ca54a12a57b";

	const LOG_LEVEL_INFO = 0;
	const LOG_LEVEL_NOTICE = 2;
	const LOG_LEVEL_WARNING = 4;
	const LOG_LEVEL_ERROR = 6;
	
	public function __construct($sWidgetId) {
		parent::__construct($sWidgetId);
	}
	
	public function checkOptions() {
		$aResult = array();
		foreach(self::$CHECK_OPTIONS as $sCheckOption) {
			// no string check required if there is no second language
			if($sCheckOption === 'strings' && LanguageQuery::create()->count() === 1) {
				continue;
			}
			$aResult[$sCheckOption] = StringPeer::getString('check_option.'.$sCheckOption, null, StringUtil::makeReadableName($sCheckOption));
		}
		return $aResult;
	}
	
	public function check($sCheckName, $sLanguageId = null) {
		$this->aLogMessages = array();
		switch($sCheckName) {
			case "static_strings":
				return $this->checkStaticStrings($sLanguageId);
			break;
			case "strings":
				return $this->checkStrings($sLanguageId);
			break;
		}
	}
	
	private function checkStrings($sCheckLanguageId = null) {
		$aAllStringObjects = StringQuery::create()->orderByStringKey()->find();
		$aAllStrings = array();
		$aAllLanguages = LanguagePeer::getLanguagesAssoc();
		foreach($aAllStringObjects as $oString) {
			if(!in_array($oString->getStringKey(), $aAllStrings))
				$aAllStrings[] = $oString->getStringKey();
		}

		foreach($aAllStrings as $sStringKey) {
			foreach($aAllLanguages as $sLanguageId => $sLanguageName) {
				$oString = StringPeer::getString($sStringKey, $sLanguageId, self::$EMPTY_STRING_KEY);
				if($oString === self::$EMPTY_STRING_KEY) {
					$sText = StringPeer::getString('wns.check.check_string_message', null, null, array('string_key' => $sStringKey, 'language_id' => $sLanguageId));
					$this->log($sText, $sLanguageId, self::LOG_LEVEL_WARNING);
				}
			}
		}
		return $this->aLogMessages;
	}

	private function checkStaticStrings($sCheckLanguageId = null) {

		$aPaths = array();
		$aPaths[] = array('base');
		foreach(ResourceFinder::create(array(DIRNAME_PLUGINS, ResourceFinder::ANY_NAME_OR_TYPE_PATTERN))->searchMainOnly()->byExpressions()->find() as $sPlugin => $sDir) {
			$aPaths[] = explode('/', $sPlugin);
		}
		$aPaths[] = array('site');

		foreach($aPaths as $aPath) {
			$this->log(StringPeer::getString('wns.check.check_static_strings_title', null, null, array('path_prefix' => implode('/', $aPath))));
			$aLanguagesInContextDir = array();
			$aLanguageFiles = ResourceFinder::create($aPath)->addRecursion()->addPath(DIRNAME_LANG)->addExpression("/^.+\.ini$/")->noCache()->returnObjects()->searchMainOnly()->find();
			foreach($aLanguageFiles as $oLanguageFile) {
				$sLanguageId = $oLanguageFile->getFileName('.ini');
				$aLanguagesInContextDir[$sLanguageId] = true;
			}
			$aLanguagesInContextDir = array_keys($aLanguagesInContextDir);
			$aLanguageDirs = ResourceFinder::create($aPath)->addRecursion()->addPath(DIRNAME_LANG)->noCache()->returnObjects()->searchMainOnly()->find();
			foreach($aLanguageDirs as $oDir) {
			$this->log(StringPeer::getString('wns.check.check_static_strings_dir', null, null, array('dir' => $oDir->getRelativePath())));
				$aDir = explode('/', $oDir->getRelativePath());
				$aStrings = array();
				foreach($aLanguagesInContextDir as $sLanguageId) {
					$sFile = ResourceFinder::create($aDir)->addPath("$sLanguageId.ini")->searchMainOnly()->find();
					ErrorHandler::log($sFile, $aDir, "$sLanguageId.ini");
					if(!$sFile) {
						continue;
					}
					$aContents = parse_ini_file($sFile);
					foreach($aContents as $sStringKey => $sString) {
						if(!isset($aStrings[$sStringKey])) {
							$aStrings[$sStringKey] = array();
						}
						$aStrings[$sStringKey][$sLanguageId] = $sString;
					}
				}
				foreach($aStrings as $sStringKey => &$aStringLanguages) {
					foreach($aLanguagesInContextDir as $sLanguageId) {
						if($sCheckLanguageId !== null && $sLanguageId !== $sCheckLanguageId) {
							continue;
						}
						if(!isset($aStringLanguages[$sLanguageId])) {
							$sText = StringPeer::getString('wns.check.check_message', null, null, array('string_key' => $sStringKey, 'ini_file_name' => $oDir->getRelativePath().'/'.$sLanguageId.'.ini'));
							$this->log($sText, $sLanguageId, self::LOG_LEVEL_WARNING);
						}
					}
					
				}
			}
		}

		return $this->aLogMessages;
	}
	
	private function log($sText, $sLanguageId=null, $iLogLevel=0) {
		$aLog = array();
		$aLog['level'] = $iLogLevel;
		$aLog['message'] = $sText;
		$aLog['language_id'] = $sLanguageId;
		$this->aLogMessages[] = $aLog;
	}
}
