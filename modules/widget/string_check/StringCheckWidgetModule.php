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
	
	public function allOptions() {
		$aResult = array();
		
		// Check options
		$aResult['check_options'] = array();
		foreach(self::$CHECK_OPTIONS as $sCheckOption) {
			// no string check required if there is no second language
			if($sCheckOption === 'strings' && LanguageQuery::create()->count() === 1) {
				continue;
			}
			$aResult['check_options'][$sCheckOption] = TranslationPeer::getString('check_option.'.$sCheckOption, null, StringUtil::makeReadableName($sCheckOption));
		}

    // Directory options, only applicable for static strings
		$aResult['directory_options'] = array();
		foreach(array(DIRNAME_SITE, DIRNAME_PLUGINS, DIRNAME_BASE) as $sDirectory) {
  		$aResult['directory_options'][$sDirectory] = StringUtil::makeReadableName($sDirectory);
		}
		$aResult['directory_options'][''] = TranslationPeer::getString('wns.check.all_directories');
		return $aResult;
	}
	
	public function check($sCheckName, $sLanguageId = null, $sDirectory = null) {
		$this->aLogMessages = array();
		switch($sCheckName) {
			case "static_strings":
				return $this->checkStaticStrings($sLanguageId, $sDirectory);
			break;
			case "strings":
				return $this->checkStrings($sLanguageId);
			break;
		}
	}
	
	private function checkStrings($sCheckLanguageId = null) {
		$aAllStrings = array();
		foreach(TranslationQuery::create()->orderByStringKey()->find() as $oString) {
			if(!in_array($oString->getStringKey(), $aAllStrings)) {
				$aAllStrings[] = $oString->getStringKey();
			}
		}

		$aAllLanguages = array();
		foreach(LanguageQuery::create()->orderById()->find() as $oLanguage) {
			$aAllLanguages[$oLanguage->getId()] = $oLanguage->getLanguageName();
		} 
		
		foreach($aAllStrings as $sStringKey) {
			foreach($aAllLanguages as $sLanguageId => $sLanguageName) {
				if($sCheckLanguageId && $sCheckLanguageId === $sLanguageId) {
					continue;
				}
				$oString = TranslationPeer::getString($sStringKey, $sLanguageId, self::$EMPTY_STRING_KEY);
				if($oString === self::$EMPTY_STRING_KEY) {
					$sText = TranslationPeer::getString('wns.check.check_string_message', null, null, array('string_key' => $sStringKey, 'language_id' => $sLanguageId));
					$this->log($sText, $sLanguageId, self::LOG_LEVEL_WARNING);
				}
			}
		}
		return $this->aLogMessages;
	}

	private function checkStaticStrings($sCheckLanguageId = null, $sDirectory = null) {
		$aPaths = array();
		if($sDirectory === null || $sDirectory === 'base') {
  		$aPaths[] = array('base');
		}
		if($sDirectory === null || $sDirectory === 'plugins') {
  		foreach(ResourceFinder::create(array(DIRNAME_PLUGINS, ResourceFinder::ANY_NAME_OR_TYPE_PATTERN))->searchMainOnly()->byExpressions()->find() as $sPlugin => $sDir) {
  			$aPaths[] = explode('/', $sPlugin);
  		}
		}
		if($sDirectory === null || $sDirectory === 'site') {
  		$aPaths[] = array('site');
		}

		foreach($aPaths as $aPath) {
			$this->log(TranslationPeer::getString('wns.check.check_static_strings_title', null, null, array('path_prefix' => implode('/', $aPath))), null, 'title_main_dir');
			$aLanguagesInContextDir = array();
			$aLanguageFiles = ResourceFinder::create($aPath)->addRecursion()->addPath(DIRNAME_LANG)->addExpression("/^.+\.ini$/")->noCache()->returnObjects()->searchMainOnly()->find();
			foreach($aLanguageFiles as $oLanguageFile) {
				$sLanguageId = $oLanguageFile->getFileName('.ini');
				$aLanguagesInContextDir[$sLanguageId] = true;
			}
			$aLanguagesInContextDir = array_keys($aLanguagesInContextDir);
			$aLanguageDirs = ResourceFinder::create($aPath)->addRecursion()->addPath(DIRNAME_LANG)->noCache()->returnObjects()->searchMainOnly()->find();
			foreach($aLanguageDirs as $oDir) {
			$this->log(TranslationPeer::getString('wns.check.check_static_strings_dir', null, null, array('dir' => $oDir->getRelativePath())), null, 'title_dir');
				$aDir = explode('/', $oDir->getRelativePath());
				$aStrings = array();
				foreach($aLanguagesInContextDir as $sLanguageId) {
					$sFile = ResourceFinder::create($aDir)->addPath("$sLanguageId.ini")->searchMainOnly()->find();
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
							$this->log($sStringKey, $sLanguageId, self::LOG_LEVEL_WARNING);
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
