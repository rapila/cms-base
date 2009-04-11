<?php
/**
 * @package modules.backend
 */
class ContentBackendModule extends BackendModule {

  private $oCurrentPage = null;
  private $oPageTypeModule = null;

  public function __construct() {
    if(Manager::hasNextPathItem()) {
      $this->oCurrentPage = PagePeer::retrieveByPk(Manager::usePath());
      BackendManager::setCurrentPage($this->oCurrentPage);
    }
    if($this->oCurrentPage !== null) {
      $this->oPageTypeModule = PageTypeModule::getModuleInstance($this->oCurrentPage->getPageType(), $this->oCurrentPage);
      $this->oPageTypeModule->backendInit();
    }
  }

  public function getChooser() {
    $oTemplate = null;
    
    /**
    * @todo fix issue with caching and showing current link
    */
    // $oCache = new Cache(self::PAGES_SESSION_KEY.BackendManager::getContentEditLanguage(), DIRNAME_BACKEND);
    // if($oCache->cacheFileExists() && !$oCache->isOlderThan(PagePeer::getLastUpdatedTimestamp())) {
    //   $oTemplate = $oCache->getContentsAsVariable();
    // }
    
    if($oTemplate === null) {
      $oCriteria = new Criteria();
      $oCriteria->addAlias("children", PagePeer::TABLE_NAME);
      $oCriteria->addJoin(PagePeer::ID, "children.parent_id", Criteria::LEFT_JOIN);
      $oCriteria->add("children.id", null, Criteria::ISNULL);
      $aPages = PagePeer::doSelect($oCriteria);
    
      $iMaxLevel = 0;
      foreach($aPages as $oPage) {
        $iMaxLevel = max($oPage->getLevel(), $iMaxLevel);
      }

      $aNavigationConfig = array();
      $aNavigationConfig["show_inactive"] = true;
      $aNavigationConfig["show_hidden"] = true;
      $aNavigationConfig["language"] = BackendManager::getContentEditLanguage();
      $aNavigationConfig["tree_language"] = null;
      for($i=0;$i<=$iMaxLevel;$i++) {
        $aNavigationConfig[$i] = array();
        $aNavigationConfig[$i][] = array("template" => "content_be_edit", "on" => 'user_may_edit');
        $aNavigationConfig[$i][] = array("template" => "content_be_no_edit");
      }
      $oTemplate = $this->constructTemplate('list');
      $oNavigation = new Navigation($aNavigationConfig, LinkUtil::link($this->getModuleName()).'/');
    
      $oTemplate->replaceIdentifier("tree", $oNavigation->parse());
    
      // $oCache->setContents($oTemplate);
    }
    // $oTemplate->replaceIdentifier("current_page_id", $this->oCurrentPage->getId());
    return $oTemplate;
  }

  public function getDetail() {
    if($this->oCurrentPage === null) {
      $oTemplate = $this->constructTemplate("message", true);
      $oTemplate->replaceIdentifier("default_message", StringPeer::getString('content.choose_or_create'), null, Template::NO_HTML_ESCAPE);
      return $oTemplate;
    }
    return $this->oPageTypeModule->backendDisplay();
  }

  public function save() {
    $this->oPageTypeModule->backendSave();
  }

  public function __call($sMethod, $aArgs) {
    if (!method_exists($this->oPageTypeModule, $sMethod)) {
        return;
    }
    return call_user_func_array(array($this->oPageTypeModule, $sMethod), $aArgs);
  }

  /**
  * Returns the class name of the main model that is being modified at the moment by the backend module
  * Used only to assign tags using the tag panel
  * Default is null
  */
  public function getModelName() {
    if($this->oPageTypeModule === null) {
      return null;
    }
    return $this->oPageTypeModule->getModelName();
  }
  
  /**
  * Returns the primary key value of the main model ({@link getModelName}) row that is being modified at the moment by the backend module
  * Used only to assign tags using the tag panel
  * Default is null
  */
  public function getCurrentId() {
    if($this->oPageTypeModule === null) {
      return null;
    }
    return $this->oPageTypeModule->getCurrentId();
  }

  public function customJs() {
    if($this->oPageTypeModule !== null) {
      return $this->oPageTypeModule->backendCustomJs;
    }
    return "";
  }
  
  public function getAjax($aPath) {
    $iPageId = $_REQUEST['page_id'];
    $oPage = PagePeer::retrieveByPk($iPageId);
    if(!Session::getSession()->getUser()->mayEditPageContents($oPage)) {
      BackendAjaxFrontendModule::printError(BackendAjaxFrontendModule::ERROR_NOT_PERMITTED);
    }
    $oPageTypeModule = PageTypeModule::getModuleInstance($oPage->getPageType(), $oPage);
    $oPageTypeModule->getAjax($aPath);
  }
}
