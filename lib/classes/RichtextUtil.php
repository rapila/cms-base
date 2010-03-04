<?php
/**
 * @package utils
 */
class RichtextUtil {
  
  private static $RICHTEXT_INDEX = 0;
  
  public static $USE_ABSOLUTE_LINKS = false;
  
  private $sAreaName;
  private $aSettings;
  
  private $mTrackReferences = null;
  
  public function __construct($sAreaName=null, $aSettings=null) {
    if($sAreaName === null) {
      $sAreaName = "richtext_area_";
    }
    $this->sAreaName = $sAreaName.self::$RICHTEXT_INDEX;
    self::$RICHTEXT_INDEX++;
    
    if($aSettings === null) {
      $aSettings = Settings::getSetting('backend', 'text_module', array());
    }
    $this->aSettings = $aSettings;
  }
  
  public static function parseInputFromMceForStorage($sInput) {
    $oRichtextUtil = new RichtextUtil();
    $_POST[$oRichtextUtil->sAreaName] = $sInput;
    return $oRichtextUtil->parseInputFromMce();
  }
  
  public function parseInputFromMce() {
    if($this->mTrackReferences !== null) {
      // delete all references before saving the tracked ones
      ReferencePeer::removeReferences($this->mTrackReferences);
    }
    $oTagParser = new TagParser("<text>".$_POST[$this->sAreaName]."</text>");
    $oTagParser->getTag()->setParseCallback(array($this, 'textTagParseCallback'));
    return $oTagParser->getTag()->__toString();
  }
  
  public static function parseStorageForOutput($sStorage, $bIsBackend) {
    $oTemplate = new Template($sStorage, "db", true);
    self::replaceIdentifierWithCallback($oTemplate, 'internal_link', 'internalLinkCallback', $bIsBackend);
    self::replaceIdentifierWithCallback($oTemplate, 'external_link', 'externalLinkCallback', $bIsBackend);
    self::replaceIdentifierWithCallback($oTemplate, 'file_link', 'fileLinkCallback', $bIsBackend);
    self::replaceIdentifierWithCallback($oTemplate, 'image', 'imageCallback', $bIsBackend);
    self::replaceIdentifierWithCallback($oTemplate, 'mailto_link', 'mailtoLinkCallback', $bIsBackend);
    return $oTemplate;
  }
  
  public static function parseStorageForFrontendOutput($sStorage) {
    return self::parseStorageForOutput($sStorage, false);
  }
  
  public static function parseStorageForBackendOutput($sStorage) {
    return self::parseStorageForOutput($sStorage, true);
  }
  
  private static function replaceIdentifierWithCallback($oTemplate, $sIdentifierName, $sCallbackName, $bIsBackend) {
    if($bIsBackend) {
      $sCallbackName .= 'Be';
    }
    $oTemplate->replaceIdentifierCallback($sIdentifierName, 'RichtextUtil', $sCallbackName, Template::NO_HTML_ESCAPE|Template::LEAVE_IDENTIFIERS);
  }
  
  private static function writeTagForIdentifier($sTagName, $aParameters, $oIdentifier, $sTagContent = null, $mCallbackContext = null) {
    if($sTagContent === null) {
      $sTagContent = $oIdentifier->getParameter("link_text");
    }
    FilterModule::getFilters()->handleRichtextWriteTagForIdentifier($sTagName, array(&$aParameters), $oIdentifier, $sTagContent, $mCallbackContext);
    $oWriter = new TagWriter($sTagName, array(), $sTagContent);
    foreach($aParameters as $sName => $sValue) {
      $oWriter->setParameter($sName, $sValue);
    }
    return self::writeTagForIdentifierWithWriter($oIdentifier, $oWriter);
  }
  
  private static function writeTagForIdentifierWithWriter($oIdentifier, $oWriter) {
    foreach($oIdentifier->getParameters() as $sName => $sValue) {
      if($sName === 'class') {
        $oWriter->addToParameter($sName, $sValue);
      } else if ($sName !== "link_text" && $sName !== "href") {
        $oWriter->setParameter($sName, $sValue);
      }
    }
    return $oWriter->parse(true);
  }
  
  public static function imageCallback($oIdentifier) {
    $iDocumentId = $oIdentifier->getValue();
    $oDocument = DocumentPeer::retrieveByPK($iDocumentId);
    if($oDocument !== null && $oDocument->isImage()) {
      $oWriter = new TagWriter('img', $oIdentifier->getParameters());
      $aParameters = array();
      if($oIdentifier->hasParameter('max_width')) {
        $aParameters['max_width'] = $oIdentifier->getParameter('max_width');
        $oWriter->setParameter('max_width', null);
      }
      $oWriter->setParameter('src', self::getLink(array('display_document', $oDocument->getId()), 'FileManager', $aParameters));
      $oWriter->setParameter('alt', $oDocument->getDescription());
      $oWriter->setParameter('title', $oDocument->getDescription());
      return $oWriter->parse();
    }
  }
  
  public static function imageCallbackBe($oIdentifier) {
    $iDocumentId = $oIdentifier->getValue();
    $oDocument = DocumentPeer::retrieveByPK($iDocumentId);
    if($oDocument !== null && $oDocument->isImage()) {
      $oWriter = new TagWriter('img', $oIdentifier->getParameters());
      $oWriter->setParameter('src', self::getLink(array('display_document', $oDocument->getId()), 'FileManager'));
      $oWriter->setParameter('alt', $oDocument->getDescription());
      $oWriter->setParameter('title', $oDocument->getDescription());
      if($oIdentifier->hasParameter('max_width')) {
        $oWriter->setParameter('width', $oIdentifier->getParameter('max_width'));
      }
      return $oWriter->parse();
    }
  }
  
  public static function internalLinkCallback($oIdentifier) {
    $oPage = PagePeer::retrieveByPK($oIdentifier->getValue());
    if($oPage) {
      $sLink = self::getLink($oPage->getFullPathArray(), "FrontendManager");
      return self::writeTagForIdentifier("a", array('href' => $sLink, 'title' => $oPage->getPageTitle(), 'rel' => 'internal', 'class' => 'internal_link'), $oIdentifier, null, $oPage);
    }
  }
  
  public static function internalLinkCallbackBe($oIdentifier) {
    $oPage = PagePeer::retrieveByPK($oIdentifier->getValue());
    if($oPage) {
      $sLink = self::getLink(array('internal_link_proxy', $oPage->getId()), 'FileManager');
      return self::writeTagForIdentifier("a", array('href' => $sLink), $oIdentifier, null, $oPage);
    }
  }
  
  public static function mailtoLinkCallback($oIdentifier) {
    $sLinkUrl = $oIdentifier->getValue();
    $sText = $oIdentifier->getParameter("link_text");
    $oWriter = TagWriter::getEmailLinkWriter($sLinkUrl, $sText);
    return self::writeTagForIdentifierWithWriter($oIdentifier, $oWriter);
  }
  
  public static function mailtoLinkCallbackBe($oIdentifier) {
    return self::writeTagForIdentifier("a", array('href' => "mailto:".$oIdentifier->getValue()), $oIdentifier);
  }
  
  public static function externalLinkCallback($oIdentifier) {
    $oLink = LinkPeer::retrieveByPK($oIdentifier->getValue());
    if($oLink) {
      //Mailto-Link handling
      if(StringUtil::startsWith($oLink->getUrl(), 'mailto:')) {
        return self::mailtoLinkCallback(new TemplateIdentifier('mailto_link', substr($oLink->getUrl(), strlen('mailto:')), array('link_text' => $oIdentifier->getParameter("link_text"))));
      }
      return self::writeTagForIdentifier("a", array('href' => $oLink->getUrl(), 'title' => $oLink->getDescription(), 'rel' => 'external', 'class' => 'external_link'), $oIdentifier, null, $oLink);
    }
    return new Template($oIdentifier->getParameter('link_text'), null, true);
  }
  
  public static function externalLinkCallbackBe($oIdentifier) {
    $oLink = LinkPeer::retrieveByPK($oIdentifier->getValue());
    if($oLink) {
      return self::writeTagForIdentifier("a", array('href' => self::getLink(array('external_link_proxy', $oLink->getId()), 'FileManager')), $oIdentifier, null, $oLink);
    } else {
      return self::writeTagForIdentifier("a", array('href' => '#', 'style' => "color: red;!important;"), $oIdentifier, $oIdentifier->getParameter("link_text").' [Link missing!]');
    }
  }
  
  public static function fileLinkCallback($oIdentifier) {
    $oDocument = DocumentPeer::retrieveByPK($oIdentifier->getValue());
    if($oDocument !== null) {
     return self::writeTagForIdentifier("a", array('href' => self::getLink(array('display_document', $oDocument->getId()), 'FileManager'), 'title' => $oDocument->getDescription() ? $oDocument->getDescription() : $oDocument->getName(), 'rel' => 'document', 'class' => 'document_link '.$oDocument->getExtension()), $oIdentifier, null, $oDocument);
    } else {
     return new Template($oIdentifier->getParameter('link_text'), null, true);
    }
  }
  
  public static function fileLinkCallbackBe($oIdentifier) {
    $oDocument = DocumentPeer::retrieveByPK($oIdentifier->getValue());
    if($oDocument !== null) {
      return self::writeTagForIdentifier("a", array('href' => self::getLink(array('display_document', $oDocument->getId()), 'FileManager')), $oIdentifier, null, $oDocument);
    } else {
      return self::writeTagForIdentifier("a", array('style' => "color: red;"), $oIdentifier, $oIdentifier->getParameter("link_text").' [Document missing!]');
    }
  }
  
  private static function getLink($mLocation, $sManager=null, $aParameters=array()) {
    if(self::$USE_ABSOLUTE_LINKS) {
      return LinkUtil::absoluteLink(LinkUtil::link($mLocation, $sManager, $aParameters));
    } else {
      return LinkUtil::link($mLocation, $sManager, $aParameters);
    }
  }
  
  public function getJavascript($oTemplate = null) {
    // for integration of new gzip function implement separate "mce_gzip.tmpl" read tinymce/readme.html
    if($oTemplate === null) {
      $oTemplate = new Template('mce');
    }
    $oTemplate->replaceIdentifier('textarea_id', $this->sAreaName);
    $aCssFiles = $this->getMceConfigArray('css_files');
    if($aCssFiles !== null) {
      $aResult = array();
      foreach($aCssFiles as $sCssFileName) {
        $aResult[] = EXT_CSS_DIR_FE."/$sCssFileName.css";
      }
      $oTemplate->replaceIdentifier('css_files', implode(",", $aResult));
    }
    
    $aBlockformats = $this->getMceConfigArray('blockformats');
    if($aBlockformats !== null) {
      $oTemplate->replaceIdentifier('blockformats', implode(",", $aBlockformats));
    }
    $sToolbarLocation = $this->getMceConfigArray('toolbar_location');
    $oTemplate->replaceIdentifier('toolbar_location', $sToolbarLocation !== null ? $sToolbarLocation : 'bottom');
    
    $aClasses = $this->getMceConfigArray('classes');
    if($aClasses !== null) {
      $aResult = array();
      foreach($aClasses as $sClassName) {
        $aResult[] = StringPeer::getString($sClassName.'.class', null, $sClassName)."=".$sClassName;
      }
      $oTemplate->replaceIdentifier('classes', implode(";", $aResult));
    }
    if($this->getMceConfigArray('force_br_newlines')) {
      $oTemplate->replaceIdentifier('force_br_newlines', 'true');
    }
    $oTemplate->replaceIdentifier('area_width', $this->getMceConfigArray('area_width') ? $this->getMceConfigArray('area_width') : "95%");
    $oTemplate->replaceIdentifier('area_height', $this->getMceConfigArray('area_height') ? $this->getMceConfigArray('area_height') : 400);    
    $oTemplate->replaceIdentifier('language', Session::language());  
    // plugins with defaults
    $aPlugins = $this->getMceConfigArray('plugins') !== null ? $this->getMceConfigArray('plugins') : array('advimage', 'advlink');
    $oTemplate->replaceIdentifier('plugins', implode(",", $aPlugins));
    // buttons row 1 with defaults
    $aButtons1 = $this->getMceConfigArray('advanced_buttons_1') !== null ? $this->getMceConfigArray('advanced_buttons_1') : array('bold','link','unlink','undo','redo');
    $oTemplate->replaceIdentifier('advanced_buttons_1', implode(",", $aButtons1));
    $aButtons2 = $this->getMceConfigArray('advanced_buttons_2');
    if($aButtons2 !== null) {
      $oTemplate->replaceIdentifier('advanced_buttons_2', implode(",", $aButtons2));
    }    
    return $oTemplate;
  }

  public function getAreaName() {
      return $this->sAreaName;
  }
  
  public function setTrackReferences($mTrackReferences) {
    $this->mTrackReferences = $mTrackReferences;
  }

  public function getTrackReferences() {
    return $this->mTrackReferences;
  }
  
  private function addTrackReference($iToId, $sToClass) {
    if($this->mTrackReferences === null) {
      return;
    }
    ReferencePeer::addReference($this->mTrackReferences, array($iToId, $sToClass));
  }
  
  public function textTagParseCallback($oHtmlTag, $sParsedChildren) {
    if($oHtmlTag->getName() === 'text') {
      return $sParsedChildren;
    }
    if($oHtmlTag->getName() === 'img') {
      if(preg_match("%display_document/(\\d+)%", $oHtmlTag->getParameter('src'), $aMatches)) {
        $aParameters = $oHtmlTag->getParameters();
        if($oHtmlTag->hasParameter('width')) {
          $aParameters['max_width'] = $oHtmlTag->getParameter('width');
          unset($aParameters['width']);
          unset($aParameters['height']);
        }
        $this->addTrackReference($aMatches[1], "Document");
        return TemplateIdentifier::constructIdentifier('image', $aMatches[1], $aParameters);
      }
    }
    if($oHtmlTag->getName() === 'a') {
      if($sParsedChildren === '') return '';
      $bHasMatched = preg_match("%/".preg_quote(Manager::getPrefixForManager('FileManager'), "%")."/([^/]+)/(\\d+)$%", $oHtmlTag->getParameter('href'), $aMatches) === 1;
      if($bHasMatched) {
        $sFileMethod = $aMatches[1];
        $iId = $aMatches[2];
        $sIdentifier = 'file_link';
        $sModel = 'Document';
        if($sFileMethod === 'external_link_proxy') {
          $sIdentifier = 'external_link';
          $sModel = 'Link';
        } else if($sFileMethod === 'internal_link_proxy') {
          $sIdentifier = 'internal_link';
          $sModel = 'Page';
        }
        $this->addTrackReference($iId, $sModel);
        return TemplateIdentifier::constructIdentifier($sIdentifier, $iId, array_merge($oHtmlTag->getParameters(), array('link_text' => $sParsedChildren)));
      } else if(strpos($oHtmlTag->getParameter('href'), "mailto:") === 0) {
        return TemplateIdentifier::constructIdentifier("mailto_link", substr($oHtmlTag->getParameter('href'), strlen("mailto:")), array("link_text" => $sParsedChildren));
      }
    }
    $oTagWriter = new TagWriter($oHtmlTag->getName(), $oHtmlTag->getParameters(), $sParsedChildren);
    $oTagTemplate = $oTagWriter->parse(true);
    $oTagTemplate->bKillIdentifiersBeforeRender = false;
    return $oTagTemplate->render();
  }
  
  private function getMceConfigArray($sConfigName) {
    if(isset($this->aSettings[$sConfigName])) {
      if(!is_array($this->aSettings[$sConfigName])) {
        $this->aSettings[$sConfigName] = array($this->aSettings[$sConfigName]);
      }
      return count($this->aSettings[$sConfigName]) === 0 ? null : $this->aSettings[$sConfigName];
    }
    return null;
  }
  
}// end class RichtextUtil