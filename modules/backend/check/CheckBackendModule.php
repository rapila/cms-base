<?php
/**
 * @package modules.backend
 */
class CheckBackendModule extends BackendModule {
  
  private $sCheckName = null;
  private $oTemplate;
  
  private static $EMPTY_STRING_KEY = "139c4e89cdbedaf144d05ca54a12a57b";
  
  private static $CONFIG_SETTINGS_SHOULD = array( "magic_quotes_gpc" => "0",
                                                  "safe_mode" => "",
                                                  "file_uploads" => "1",
                                                  "output_buffering" => "1",
                                                  "magic_quotes_runtime" => "");
  
  private static $CONFIG_SETTINGS_SHOULD_NOT = array( "last_modified" => '1',
                                                      "register_globals" => '1');
  
  const LOG_LEVEL_INFO = 0;
  const LOG_LEVEL_NOTICE = 2;
  const LOG_LEVEL_WARNING = 4;
  const LOG_LEVEL_ERROR = 6;
  
  public function __construct() {
    if(Manager::hasNextPathItem()) {
      $this->sCheckName = Manager::usePath();
    }
    
    $this->oTemplate = $this->constructTemplate("check_detail");
  }
  
  public function getChooser() {
    $oTemplate = $this->constructTemplate();
    $this->parseTree($oTemplate, array("pages", "strings", "static strings", "config", "tags", "content"), $this->sCheckName);
    return $oTemplate;
  }
  
	public function getDetail() {
	  if($this->sCheckName === null) {
	    return;
	  }
	  
	  switch($this->sCheckName) {
	    case "pages":
        $this->doCheckPages();
	    break;
	    case "strings":
        $this->doCheckStrings();
	    break;
	    case "static strings":
        $this->doCheckStaticStrings();
	    break;
	    case "tags":
        $this->doCheckTags();
	    break;
	    case "config":
        $this->doCheckConfig();
	    break;
	    case "content":
        $this->doCheckContent();
	    break;
	  }
	  $this->oTemplate->replacePstring("check_text", array('check_item' => $this->sCheckName));
	  return $this->oTemplate;
	}
	
	private function doCheckPages() {
    $aAllPages = PagePeer::doSelect(new Criteria());
    foreach($aAllPages as $oPage) {
      $this->log("Checking Page ".$oPage->getName());
      $sTemplateName = $oPage->getTemplateNameUsed();
      $oTemplate = new Template($sTemplateName);
      $sAllowedContainers = $oTemplate->listValuesByIdentifier("container");
      foreach($oPage->getContentObjects() as $oContentObject) {
        if(!in_array($oContentObject->getContainerName(), $sAllowedContainers)) {
          $this->log("Orphaned content found, identifier ".$oContentObject->getContainerName()." not found in template ".$sTemplateName, self::LOG_LEVEL_WARNING);
        }
      }
    
      if($oPage->getParentId() !== null && $oPage->getParent() === null) {
          $this->log("Page is orphaned! (Parent-Id = ".$oPage->getParentId().")", self::LOG_LEVEL_ERROR);
      }
      
      foreach($oPage->getPageStrings() as $oPageString) {
        if($oPageString->getLinkTextOnly() === $oPageString->getPageTitle()) {
          $sLanguageId = $oPageString->getLanguageId();
          $this->log("Page has redundant link text in language $sLanguageId", self::LOG_LEVEL_WARNING);
        }
      }
      
    }
	}
	
	private function doCheckStrings() {
    $aAllStringObjects = StringPeer::doSelect(new Criteria());
    $aAllStrings = array();
    foreach($aAllStringObjects as $oString) {
      if(!in_array($oString->getStringKey(), $aAllStrings))
        $aAllStrings[] = $oString->getStringKey();
    }
    $aAllLanguages = LanguagePeer::getLanguagesAssoc();
    foreach($aAllStrings as $sString) {
      foreach($aAllLanguages as $sLanguageId => $sLanguageName) {
        $oString = StringPeer::getString($sString, $sLanguageId, self::$EMPTY_STRING_KEY);
        if($oString === self::$EMPTY_STRING_KEY) {
          $this->log("String $sString does not exist in $sLanguageName ($sLanguageId)", self::LOG_LEVEL_WARNING);
        }
      }
    }
	}
	
	private function doCheckStaticStrings() {
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
	}
	
	private function doCheckConfig() {
	  foreach(self::$CONFIG_SETTINGS_SHOULD as $sConfigKey => $mConfigShouldValue) {
      $mCurrentValue = ini_get($sConfigKey);
	    if($mCurrentValue !== $mConfigShouldValue) {
        $this->log("Warning, value for $sConfigKey should be ".var_export($mConfigShouldValue, true)." but is ".var_export($mCurrentValue, true), self::LOG_LEVEL_ERROR);
	    } else {
        $this->log("Value for $sConfigKey is correct (".var_export($mCurrentValue, true).")");
	    }
	  }
	  foreach(self::$CONFIG_SETTINGS_SHOULD_NOT as $sConfigKey => $mConfigShouldNotValue) {
      $mCurrentValue = ini_get($sConfigKey);
	    if($mCurrentValue === $mConfigShouldNotValue) {
        $this->log("Warning, value for $sConfigKey should not be ".var_export($mConfigShouldNotValue, true)." but is", self::LOG_LEVEL_ERROR);
	    } else {
        $this->log("Value for $sConfigKey (".var_export($mCurrentValue, true).") is ok (should not be ".var_export($mConfigShouldNotValue, true).")");
	    }
	  }
	}
	
	private function doCheckTags() {
    $aAllTags = TagPeer::doSelect(new Criteria());
    foreach($aAllTags as $oTag) {
      $this->log("Checking tag ".$oTag->getName());
      if(count($oTag->getAllCorrespondingDataEntries()) == 0) {
        $this->log("Warning, tag ".$oTag->getName()." has no entries, removing", self::LOG_LEVEL_NOTICE);
        $oTag->delete();
      }
    }
	}
	
	private function doCheckContent() {
    $aLanguageObjects = LanguageObjectPeer::doSelect(new Criteria());
    $oRichtextUtil = new RichtextUtil();
    foreach($aLanguageObjects as $oLanguageObject) {
      $this->log("Checking language object ".$oLanguageObject->getObjectId()." in ".$oLanguageObject->getLanguage()->getName());
      if($oLanguageObject->getContentObject() === null) {
        $this->log("Error: language object ".$oLanguageObject->getObjectId()." in ".$oLanguageObject->getLanguage()->getName()." is orphaned, removing", self::LOG_LEVEL_NOTICE);
        $oLanguageObject->delete();
      }
      if($oLanguageObject->getContentObject()->getObjectType() === 'text') {
        $this->log("Re-creating all references in text language object", self::LOG_LEVEL_NOTICE);
        $_POST[$oRichtextUtil->getAreaName()] = RichtextUtil::parseStorageForBackendOutput($oLanguageObject->getData()->getContents());
        $oRichtextUtil->setTrackReferences($oLanguageObject);
        $oLanguageObject->getData()->setContents($oRichtextUtil->parseInputFromMce());
        $oLanguageObject->setData($oLanguageObject->getData());
        $oLanguageObject->save(); 
      }
    }
	}
	
	private function log($sText, $iLogLevel=0) {
	  if($iLogLevel > 0) {
	    $this->oTemplate->replaceIdentifierMultiple("messages", '<span class="important level_'.$iLogLevel.'">', null, Template::NO_HTML_ESCAPE|Template::NO_NEWLINE);
	  }
	  $this->oTemplate->replaceIdentifierMultiple("messages", date("D M j (G:i:s): ").$sText, null);
	  if($iLogLevel > 0) {
	    $this->oTemplate->replaceIdentifierMultiple("messages", '</span>', null, Template::NO_HTML_ESCAPE|Template::NO_NEWLINE);
	  }
    @ob_flush();
	}
}
