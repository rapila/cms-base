<?php
/**
 * class FrontendManager
 * @package manager
 */
class FrontendManager extends Manager {
  
  private $oTemplate;
  private $aPathRequestParams;
  private $bIsNotFound;
  private $oPageType;
  
  /**
   * __construct()
   */
  public function __construct() {
    parent::__construct();
    $this->aPathRequestParams = array();
    $this->bIsNotFound = false;
    if(self::hasNextPathItem() && LanguagePeer::languageIsActive(self::peekNextPathItem())) {
        Session::getSession()->setLanguage(self::usePath());
    } else {
      if(!LanguagePeer::languageIsActive(Session::language())) {
        Session::getSession()->resetAttribute(Session::SESSION_LANGUAGE_KEY);
      }
      if(!LanguagePeer::languageIsActive(Session::language())) {
        LinkUtil::redirectToManager('', "BackendManager");
      }
      LinkUtil::redirectToLanguage();
    }

    // Find requested page
    $oMatchingPage = PagePeer::getRootPage(); 
    if($oMatchingPage === null) {
      echo "please create root node in database! <br />"; 
      echo "to backend: <a href=\"".LinkUtil::link('pages', "BackendManager")."\">Pages</a>"; exit;
    }
     
    while(self::hasNextPathItem()) {
      $oNextPage = $oMatchingPage->getChildByName(self::usePath());
      if($oNextPage !== null) {
        if($oNextPage->getIsInactive()) {
          self::unusePath();
          break;
        }
        $oMatchingPage = $oNextPage;
      } else {
        self::unusePath();
        break;
      }
    }
    
    // Transfer unused path parts from the end of the path array as key/value-pairs to the $_REQUEST global
    $iTimesUsed = 0;
    while(self::hasNextPathItem()) {
      $sKey = self::usePath();
      $iTimesUsed++;
      $sValue = null;
      if(self::hasNextPathItem()) {
        $sValue = self::usePath();
        $iTimesUsed++;
      }
      $this->aPathRequestParams[] = $sKey;
      if(!isset($_REQUEST[$sKey])) {
        $_REQUEST[$sKey] = $sValue;
      }
    }
    for($i=1;$i<=$iTimesUsed;$i++) {
      self::unusePath();
    }
    
    if($oMatchingPage->getIsFolder()) {
      $oFirstChild = $oMatchingPage->getFirstEnabledChild(Session::language());
      if($oFirstChild !== null) {
        LinkUtil::redirectToManager($oFirstChild->getLink());
      } else {
        $this->bIsNotFound = true;
      }
    }
    
    if($oMatchingPage->getIsProtected()) {
      if(!(Session::getSession()->isAuthenticated() && Session::getSession()->getUser()->mayViewPage($oMatchingPage))) {
        $oLoginPage = $oMatchingPage->getLoginPage();
        Session::getSession()->setAttribute('login_referrer', LinkUtil::link($oMatchingPage->getFullPathArray(), "FrontendManager"));
        if($oLoginPage === null) {
          LinkUtil::redirect(LinkUtil::link('', "LoginManager"));
        }
        $oMatchingPage = $oLoginPage;
      }
    }
    
    FilterModule::getFilters()->handlePageHasBeenSet($oMatchingPage, $this->bIsNotFound);
    self::setCurrentPage($oMatchingPage);
  }
  
  /**
   * render()
   */
  public function render() {
    FilterModule::getFilters()->handleRequestStarted();
    $bIsDynamic = false;
    $aAllowedParams = array();
    
    $bIsAjaxRequest = isset($_REQUEST['container_only']) && Manager::isXMLHttpRequest();
    
    $sPageType = self::getCurrentPage()->getPageType();
    $this->oPageType = PageTypeModule::getModuleInstance($sPageType, self::getCurrentPage());
    $this->oPageType->setIsDynamicAndAllowedParameterPointers($bIsDynamic, $aAllowedParams, isset($_REQUEST['container_only']) ? array($_REQUEST['container_only']) : null);
    
    $bIsDynamic = $bIsDynamic || !Settings::getSetting('general', 'use_full_page_cache', true);
    
    $this->bIsNotFound = $this->bIsNotFound || count(array_intersect($this->aPathRequestParams, $aAllowedParams)) !== count($this->aPathRequestParams);
    
    if($this->bIsNotFound) {
      FilterModule::getFilters()->handlePageNotFound();
      header("HTTP/1.0 404 Not Found");
      $sErrorPageName = Settings::getSetting('error_pages', 'not_found', null);
      $oPage = null;
      if($sErrorPageName) {
        $oPage = PagePeer::getPageByName($sErrorPageName);
      }
      if($oPage === null) {
        die(StringPeer::getString('page.not_found'));
      }
      self::setCurrentPage($oPage);
      //Set correct page type of 404 page
      $sPageType = self::getCurrentPage()->getPageType();
      $this->oPageType = PageTypeModule::getModuleInstance($sPageType, self::getCurrentPage());
    }
    
    if(!$bIsAjaxRequest) {
      $oOutput = new XHTMLOutput();
      $oOutput->render();
    }
    
    $sPageIdentifier = self::getCurrentPage()->getId().'_'.Session::language();
    if($bIsAjaxRequest) {
      $sPageIdentifier .= '_'.$_REQUEST['container_only'];
    }
    
    $oCache = null;
    
    $bIsCached = false;
    if(!$bIsDynamic && !Session::getSession()->isAuthenticated() && !$this->bIsNotFound) {
      $oCache = new Cache($sPageIdentifier, DIRNAME_FULL_PAGE);
    
      $bIsCached = $oCache->cacheFileExists();
      $bIsOutdated = false;
    
      if($bIsCached) {
        $bIsOutdated = $oCache->isOlderThan(self::getCurrentPage()->getTimestamp());
      }
      if($bIsCached && !$bIsOutdated) {
        return print $oCache->getContentsAsString();
      }
    }
    
    // Init the template
    if($bIsAjaxRequest) {
      $this->oTemplate = new Template(TemplateIdentifier::constructIdentifier('container', $_REQUEST['container_only']), null, true, true);
    } else {
      $this->oTemplate = self::getCurrentPage()->getTemplate(true);
    }
    // FilterModule::getFilters()->handleBeforePageFill(self::getCurrentPage(), $this->oTemplate);

    if(!$bIsAjaxRequest) {
      $this->fillAttributes(self::getCurrentPage()->getTopNavigationPage());
      $this->fillNavigation();
    }
    $this->fillContent();
    
    $this->oTemplate->render();
    if($oCache !== null) {
      $oCache->setContents($this->oTemplate->getSentOutput());
    }
    ob_flush();
    FilterModule::getFilters()->handleRequestFinished(array(self::getCurrentPage(), $bIsDynamic, $bIsAjaxRequest, $bIsCached));
  }

  /**
   * fillNavigation()
   */
  private function fillNavigation() {
    $aNavigations = $this->oTemplate->listValuesByIdentifier("navigation");
    foreach($aNavigations as $sNavigationName) {
      $oNavigation = new Navigation($sNavigationName);
      $this->oTemplate->replaceIdentifier("navigation", $oNavigation->parse(), $sNavigationName);
    }
  }
  
  /**
   * fillContent()
   */
  private function fillContent() { 
    // FilterModule::getFilters()->handleBeforePageTypeDisplay(self::getCurrentPage(), $this->oPageType, $this->oTemplate);
    $this->oPageType->display($this->oTemplate);
  }
      
  /**
   * fillAttributes()
   */
  private function fillAttributes() { 
    $oTopNavigationPage = self::getCurrentPage()->getTopNavigationPage();
    FilterModule::getFilters()->handleFillTopNavigationPageAttribute($oTopNavigationPage, $this->oTemplate);
    $this->oTemplate->replaceIdentifier("top_navigation", $oTopNavigationPage->getName());
    $this->oTemplate->replaceIdentifier("top_navigation_linktext", $oTopNavigationPage->getLinkText());
    $this->oTemplate->replaceIdentifier("navigation_level", self::getCurrentPage()->getLevel());
    $oSearchPage = PagePeer::getPageByName(Settings::getSetting('special_pages', 'search_result', 'search'));
    if($oSearchPage !== null) {
      $this->oTemplate->replaceIdentifier("search_action", LinkUtil::link($oSearchPage->getLink()));
    }
    
    $this->oTemplate->replaceIdentifier("meta_keywords", self::getCurrentPage()->getConsolidatedKeywords());
    $this->oTemplate->replaceIdentifier("link_text", self::getCurrentPage()->getLinkText());
    $this->oTemplate->replaceIdentifier("title", self::getCurrentPage()->getPageTitle());
    $this->oTemplate->replaceIdentifier("page_name", self::getCurrentPage()->getName());
    foreach(self::getCurrentPage()->getPageProperties() as $oPageProperty) {
      $this->oTemplate->replaceIdentifier('pageProperty', $oPageProperty->getValue(), $oPageProperty->getName());
    }
    $this->oTemplate->replaceIdentifier("page_id", self::getCurrentPage()->getId());
    $this->oTemplate->replaceIdentifierCallback("page_link", 'FrontendManager', 'replacePageLinkIdentifier');
    if(Settings::getSetting('general', 'multilingual', false) && $this->oTemplate->hasIdentifier('language_chooser')) {
      $this->oTemplate->replaceIdentifier("language_chooser", Navigation::getLanguageChooser(), null, Template::NO_HTML_ESCAPE);
    }
    FilterModule::getFilters()->handleFillAttributesFinished(self::getCurrentPage(), $this->oTemplate);
  }

  /**
   * replacePageLinkIdentifier()
   * @param object TemplateIdentifier
   * @return object Template
   * used in fillAttributes to replace page_link identifiers
   * - get a page by name
   * - get nearest neighbour page {@link PagePeer::getPageByName()}
   */
  public static function replacePageLinkIdentifier($oTemplateIdentifier) {
    $oPage = null;
    $sName = $oTemplateIdentifier->getParameter('name');
    if($sName !== null) {
      if($oTemplateIdentifier->hasParameter('nearest_neighbour')) {
        $oPage = self::getCurrentPage()->getPageOfName($sName);
      } else {
        $oPage = PagePeer::getPageByName($sName);
      }
    }
    $iId = $oTemplateIdentifier->getParameter('id');
    if($iId !== null) {
      $oPage = PagePeer::retrieveByPk($iId);
    }
    if($oPage === null) {
      return null;
    }
    if(self::getCurrentPage() !== null && self::getCurrentPage()->getId() == $oPage->getId()) {
      return TagWriter::quickTag('span', array('class' => "meta_navigation {$oPage->getName()}", 'title' => $oPage->getPageTitle()), $oPage->getLinkText());
    }
    return TagWriter::quickTag('a', array('class' => "meta_navigation {$oPage->getName()}", 'href' => LinkUtil::link($oPage->getLink()), 'title' => $oPage->getPageTitle()), $oPage->getLinkText());
  }
  
  public static function shouldIncludeLanguageInLink() {
    return Settings::getSetting('general', 'multilingual', true);
  }
}
