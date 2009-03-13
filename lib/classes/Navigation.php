<?php
/**
 * classname:   Navigation
 */
class Navigation {
  private static $TEMPLATES = array();
  
  private $aConfig = null;
  private $iMaxLevel = 0;
  private $sLinkPrefix;
  private static $BOOLEAN_PARSER_DEFAULT_VALUES = array(
            "has_children" => false,
            "is_current" => false,
            "is_active" => false,
            "is_hidden" => false,
            "is_disabled" => false,
            "is_inaccessible" => false,
            "is_sibling_of_current" => false,
            "is_sibling_of_active" => false,
            "is_child_of_current" => false,
            "is_folder" => false,
            "is_descendant_of_current" => false,
            //Please don't use those properties in frontend navigations
            "user_may_create" => false,
            "user_may_edit" => false);
  private $sTemplatesDir;
  private $bShowOnlyEnabledChildren;
  private $bShowOnlyVisibleChildren;
  private $sLanguageId;
  private $sTreeLanguageId;
  
  /**
   * __constructor()
   * @param string navigation name
   * each navigation part needs configuration in section called 'navigation' in cms.yml
   * @return void / exception on missing configuration
   */
  public function __construct($mConfig, $sLinkPrefix=null, $sTemplatesDir = null) {
    if($sTemplatesDir === null) {
      $this->sTemplatesDir = array(DIRNAME_TEMPLATES, DIRNAME_NAVIGATION);
    } else {
      $this->sTemplatesDir = $sTemplatesDir;
    }
    if(is_string($mConfig)) {
      $this->aConfig = Settings::getSetting("navigations", $mConfig, null);
    } else if(is_array($mConfig)) {
      $this->aConfig = $mConfig;
    }
    if($this->aConfig === null) {
      throw new Exception("Navigation $mConfig not configured");
    }
    if($sLinkPrefix===null) {
      $sLinkPrefix = Util::link();
    }
    if(!Util::endsWith($sLinkPrefix, "/")) {
      $sLinkPrefix .= "/";
    }
    $this->sLinkPrefix = $sLinkPrefix;
    $this->iMaxLevel = max(array_keys($this->aConfig));
    if(!is_numeric($this->iMaxLevel) || isset($this->aConfig['all'])) {
      $this->iMaxLevel = null;
    }
    $this->bShowOnlyEnabledChildren = isset($this->aConfig["show_inactive"]) ? ($this->aConfig["show_inactive"] !== true) : true;
    $this->bShowOnlyVisibleChildren = isset($this->aConfig["show_hidden"]) ? ($this->aConfig["show_hidden"] !== true) : true;
    $this->sLanguageId = isset($this->aConfig["language"]) ? $this->aConfig["language"] : Session::language();
    $this->sTreeLanguageId = array_key_exists("tree_language", $this->aConfig) ? $this->aConfig["tree_language"] : $this->sLanguageId;
  } // __construct()

  /**
   * parse()
   */  
  public function parse() {
    if (PagePeer::getRootPage() !== null) {
      return $this->parseTree(array(PagePeer::getRootPage()), 0);
    }
    
    // FIXME the whole redirection in case of a missing rootelement
    Util::redirectToManager(array('pages', 'newPage'));
  } // parse()
  
  /**
   * parseTree()
   * @param array of Page objects
   * @param int level of navigation
   * @return string parsed navigation
   */
  private function parseTree($aPages, $iLevel) {
    if($this->iMaxLevel !== null && $iLevel > $this->iMaxLevel) {
      return null;
    }
    $sResult = new Template(TemplateIdentifier::constructIdentifier('content'), null, true);
    $bNoPagesDisplayed = true;
    foreach($aPages as $oPage) { 
      $oBooleanParser = new BooleanParser(self::$BOOLEAN_PARSER_DEFAULT_VALUES);
      $bHasChildren = ( $this->bShowOnlyVisibleChildren &&  $this->bShowOnlyEnabledChildren && $oPage->hasEnabledAndVisibleChildren($this->sTreeLanguageId))
                   || (!$this->bShowOnlyVisibleChildren &&  $this->bShowOnlyEnabledChildren && $oPage->hasEnabledChildren($this->sTreeLanguageId))
                   || ( $this->bShowOnlyVisibleChildren && !$this->bShowOnlyEnabledChildren && $oPage->hasVisibleChildren($this->sTreeLanguageId))
                   || (!$this->bShowOnlyVisibleChildren && !$this->bShowOnlyEnabledChildren && $oPage->hasChildren($this->sTreeLanguageId));

      if($bHasChildren) {
        $oBooleanParser->has_children = true;
      }
      if($oPage->isCurrent()) {
        $oBooleanParser->is_current = true;
      }
      if($oPage->isActive()) {
        $oBooleanParser->is_active = true;
      }
      if($oPage->getIsInactive()) {
        $oBooleanParser->is_disabled = true;
      }
      if($oPage->getIsHidden()) {
        $oBooleanParser->is_hidden = true;
      }
      if($oPage->getIsProtected() && (!Session::getSession()->isAuthenticated() || !Session::getSession()->getUser()->mayViewPage($oPage))) {
        $oBooleanParser->is_inaccessible = true;
      }
      if($oPage->isSiblingOfCurrent()) {
        $oBooleanParser->is_sibling_of_current = true;
      }
      if($oPage->isSiblingOfActive()) {
        $oBooleanParser->is_sibling_of_active = true;
      }
      if($oPage->isChildOfCurrent()) {
        $oBooleanParser->is_child_of_current = true;
      }
      if($oPage->isDescendantOfCurrent()) {
          $oBooleanParser->is_descendant_of_current = true;
      }
      if($oPage->isFolder()) {
          $oBooleanParser->is_folder = true;
      }
      if(Session::getSession()->isAuthenticated()) {
        $oUser = Session::getSession()->getUser();
        if($oUser->mayCreateChildren($oPage)) {
          $oBooleanParser->user_may_create = true;
        }
        if($oUser->mayEditPageDetails($oPage)) {
          $oBooleanParser->user_may_edit = true;
        }
      }
      
      $sTemplateName = $this->getConfigForPage("template", $iLevel, $oBooleanParser);
      
      //Don’t show page (and subpages) in navigation if show===false
      if($this->getConfigForPage("show", $iLevel, $oBooleanParser) === false) {
        continue;
      }
      
      if($sTemplateName === null && ($this->iMaxLevel !== null && $iLevel+1 > $this->iMaxLevel)) {
        continue;
      }
      
      $bNoPagesDisplayed = false;
      
      $oTemplate = $this->getTemplate($sTemplateName);
      
      $sLanguageWarning = '';
      $oPageString = $oPage->getPageStringByLanguage($this->sLanguageId);
      if($oPageString === null) {
        $oPageString = $oPage->getActivePageString();
        $oWriter = new TagWriter('span', array('title' => StringPeer::getString("page.translation_missing")), '[!]');
        $sLanguageWarning = $oWriter->parse();
      }
      $oTemplate->replaceIdentifier('name', $oPage->getName());
      $sDocStatus = $oPage->getIsFolder() ? 'is_folder': 'is_doc';
      $oTemplate->replaceIdentifier('doc_status', StringPeer::getString($sDocStatus . '_description'));

      $oTemplate->replaceIdentifier('class_doc_status', $sDocStatus);
      $sNewPageIcon = $oPage->getIsFolder() ? 'folder_new' : 'page_new';
      if(!$oPage->getIsFolder()) {
        if($oPage->getIsInactive() && $oPage->getIsHidden()) {
          $sNewPageIcon = 'new_inactive_hidden';
        } elseif($oPage->getIsInactive()) {
          $sNewPageIcon = 'new_inactive';
        } elseif($oPage->getIsHidden()) {
          $sNewPageIcon = 'new_hidden';
        }
      } elseif($oPage->getIsFolder()) {
        if($oPage->getIsInactive() && $oPage->getIsHidden()) {
          $sNewPageIcon = 'new_folder_inactive_hidden';
        } elseif($oPage->getIsInactive()) {
          $sNewPageIcon = 'new_folder_inactive';
        } elseif($oPage->getIsHidden()) {
          $sNewPageIcon = 'new_folder_hidden';
        }
      }
      $oTemplate->replaceIdentifier("new_page", $sNewPageIcon);
      $oTemplate->replaceIdentifier('long_title', $oPageString->getPageTitle());
      $oTemplate->replaceIdentifier('language_warning', $sLanguageWarning);
      $oTemplate->replaceIdentifier('title', $oPageString->getLinkText());
      $oTemplate->replaceIdentifier('page_name', $oPage->getName());
      $oTemplate->replaceIdentifier('link_prefix', $this->sLinkPrefix);
      $oTemplate->replaceIdentifier('link', implode('/', $oPage->getLink()));
      $oTemplate->replaceIdentifier('full_link', $this->sLinkPrefix.implode('/', $oPage->getLink()));
      $oTemplate->replaceIdentifier('id', $oPage->getId());
      $oTemplate->replaceIdentifier('level', $iLevel);
      $oTemplate->replaceIdentifier('is_inactive', $oPage->getIsInactive() ? ' inactive' : '');
      
      if($oBooleanParser->is_current) {
        $oTemplate->replaceIdentifier('status', "current");
      }
      if($oBooleanParser->is_active) {
        $oTemplate->replaceIdentifier('status', "active");
      }
      if($oBooleanParser->is_sibling_of_current) {
        $oTemplate->replaceIdentifier('status', "sibling_of_current");
      }
      if($oBooleanParser->is_sibling_of_active) {
        $oTemplate->replaceIdentifier('status', "sibling_of_active");
      }
      if($oBooleanParser->is_child_of_current) {
        $oTemplate->replaceIdentifier('status', 'child_of_current');
      }
      if($oBooleanParser->is_descendant_of_current) {
        $oTemplate->replaceIdentifier('status', 'descendant_of_current');
      }
      $oTemplate->replaceIdentifier('status', "default");
      
      if($oTemplate->hasIdentifier('children') && $bHasChildren && !($this->iMaxLevel !== null && $iLevel+1 > $this->iMaxLevel)) {
        if($this->bShowOnlyEnabledChildren) {
          if($this->bShowOnlyVisibleChildren) {
            $aChildren = $oPage->getEnabledAndVisibleChildren($this->sTreeLanguageId);
          } else {
            $aChildren = $oPage->getEnabledChildren($this->sTreeLanguageId);
          }
        } else {
          if($this->bShowOnlyVisibleChildren) {
            $aChildren = $oPage->getVisibleChildren($this->sTreeLanguageId);
          } else {
            $aChildren = $oPage->getChildren($this->sTreeLanguageId);
          }
        }
        $oTemplate->replaceIdentifier('children', $this->parseTree($aChildren, $iLevel+1));
      }
      
      $sResult->replaceIdentifierMultiple("content", $oTemplate);
    }
    if($bNoPagesDisplayed) {
      return null;
    }
    return $sResult;
  } // parseTree()
  
  private function getTemplate($sTemplateName) {
    if(!isset(self::$TEMPLATES[$sTemplateName])) {
      if($sTemplateName === null) {
        self::$TEMPLATES[$sTemplateName] = new Template(TemplateIdentifier::constructIdentifier('children'), null, true);
      } else {
        self::$TEMPLATES[$sTemplateName] = new Template($sTemplateName, $this->sTemplatesDir);
      }
    }
    return clone self::$TEMPLATES[$sTemplateName];
  }
  
  /**
   * getConfigForPage()
   * @param string config var name
   * @param int level of navigation
   * @return string parsed navigation
   */  
  private function getConfigForPage($sConfigName, $iLevel, $oBooleanParser) {
    $aConfigToCheck = @$this->aConfig[$iLevel];
    if($aConfigToCheck === null) {
      if(!isset($this->aConfig['all'])) {
        return null;
      }
      $aConfigToCheck = $this->aConfig['all'];
    }
    foreach($aConfigToCheck as $aConfig) {
      if(!isset($aConfig['on']) || $oBooleanParser->parse($aConfig['on'])) {
        return @$aConfig[$sConfigName];
      }
    }
    return null;
  } // getConfigForPage()
  
  
  public static function getLanguageChooser() {
    $aSettings = Settings::getSetting('meta_navigation', 'language_chooser', array('template' => 'language'));
    $oTemplate = new Template(TemplateIdentifier::constructIdentifier('languages'), null, true);
    $oLanguageTemplate = new Template($aSettings['template'], array(DIRNAME_TEMPLATES, DIRNAME_NAVIGATION));
    $sLinkSeparator = Settings::getSetting("meta_navigation", 'meta_link_separator', ' | ');
    $oLanguageActiveTemplate = $oLanguageTemplate;
    $bShowActiveLanguage = isset($aSettings['show_active_language']) && $aSettings['show_active_language'];
    
    if(isset($aSettings['template_active']) && $bShowActiveLanguage) {
      $oLanguageActiveTemplate = new Template($aSettings['template_active'], array(DIRNAME_TEMPLATES, DIRNAME_NAVIGATION));
    }
    
    //Find request variables
    $aParameters = array_diff_assoc($_REQUEST, $_COOKIE);
    unset($aParameters['path']);
    unset($aParameters['content_language']);
    
    // check whether manager needs language to be included
    $bCurrentPathIncludesLanguage = call_user_func(array(Util::getManagerClassNormalized(null), 'shouldIncludeLanguageInLink'));
    $aRequestPath = explode("/", Manager::getRequestedPath());

    $aLanguages = LanguagePeer::getLanguages(true, true);
    foreach($aLanguages as $i => $oLanguage) {
      $oCurrrentTemplate = null;
      if($oLanguage->getId() === Session::language()) {
        if(!$bShowActiveLanguage) continue;
        $oCurrrentTemplate = clone $oLanguageActiveTemplate;
      } else {
        $oCurrrentTemplate = clone $oLanguageTemplate;
      }
      // if language is included, replace it by oLanguage->getId() and set include_language param to false
      if($bCurrentPathIncludesLanguage) {
        $aRequestPath[0] = $oLanguage->getId();  
        $oCurrrentTemplate->replaceIdentifier('link', Util::link($aRequestPath, null, $aParameters, false));
      } else {
        $oCurrrentTemplate->replaceIdentifier('link', Util::link($aRequestPath, null, array_merge($aParameters, array('content_language' => $oLanguage->getId()))));
      }
      $oCurrrentTemplate->replaceIdentifier('language_id', $oLanguage->getId());
      $oCurrrentTemplate->replaceIdentifier('title', @$aSettings['display_fullname'] ? $oLanguage->getLanguageName($oLanguage->getId()) : $oLanguage->getId());
      $oCurrrentTemplate->replaceIdentifier('link_title', $oLanguage->getLanguageName($oLanguage->getId()));
      $oTemplate->replaceIdentifierMultiple('languages', $oCurrrentTemplate, null, Template::NO_NEWLINE);
      if(($i+1) < count($aLanguages)) {
        $oTemplate->replaceIdentifierMultiple('languages', $sLinkSeparator, null, Template::NO_HTML_ESCAPE|Template::NO_NEWLINE);
      }
    }
    return $oTemplate;
  } // getLanguageChooser()
  
} // end class Navigation