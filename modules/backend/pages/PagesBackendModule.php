<?php
/**
 * @package modules.backend
 */

class PagesBackendModule extends BackendModule {
  
  private static $NEW_PAGE_DEFAULT_NAME = '';
  
  private $aAllowedParentPages = array();
  private $oPage = null;
  private $bMayDeletePageTree = false;
  private $bMayDeleteMoveOrphans = false;
  
  const ON_DELETE_CHILDREN_DELETE   = 'children_delete';
  const ON_DELETE_CHILDREN_INHERIT  = 'children_inherit';
  
  public function __construct() { 
    if(Manager::hasNextPathItem()) {
      $iPageId = Manager::usePath();
      if($iPageId === '') {
        $this->oPage = new Page();
      } else {
        $this->oPage = PagePeer::retrieveByPk($iPageId);
      }
      if($this->oPage !== null) {
        BackendManager::setCurrentPage($this->oPage);
        $this->bMayDeletePageTree = Settings::getSetting('backend', 'delete_pagetree_enable', false) === true;
        $this->bMayDeleteMoveOrphans = Settings::getSetting('backend', 'inherit_children_enable', false) === true;
        return;
      }
    }
    //No page was found
    if(PagePeer::doCount(new Criteria()) === 0) {
      $aPages = array(PagePeer::initialiseRootPage());
    }
  }
  
  public function getChooser() {
    $aNavigationConfig = array();
    $aNavigationConfig["show_inactive"] = true;
    $aNavigationConfig["show_hidden"] = true;
    $aNavigationConfig["language"] = BackendManager::getContentEditLanguage();
    $aNavigationConfig["tree_language"] = null;
    $aNavigationConfig['all'] = array();
    $aNavigationConfig['all'][] = array("template" => "main_be_with_create_link", "on" => 'user_may_create&user_may_edit');
    $aNavigationConfig['all'][] = array("template" => "main_be_unlinked_with_create_link", "on" => 'user_may_create');
    $aNavigationConfig['all'][] = array("template" => "main_be_no_new", "on" => 'user_may_edit');
    $aNavigationConfig['all'][] = array("template" => "main_be_unlinked");
    $oTemplate = $this->constructTemplate();
    $oNavigation = new Navigation($aNavigationConfig, LinkUtil::link($this->getModuleName()).'/');

    $oTemplate->replaceIdentifier("tree", $oNavigation->parse());
    return $oTemplate;
  }
  
  public function getDetail() {
    if(!$this->oPage) {
      // if a error404 happens the page has been redirected to list view without id, so display the message
      // this action should not happen anyway????
      if(isset($_REQUEST['error404'])) {
        $oTemplate = $this->constructTemplate("error404");
        $oTemplate->replaceIdentifier("error_message", StringPeer::getString('page.error_403'), null, Template::NO_HTML_ESCAPE);
      } else {
        $oTemplate = $this->constructTemplate("message", true);
        $oTemplate->replaceIdentifier("default_message", StringPeer::getString('page.choose_or_create'), null, Template::NO_HTML_ESCAPE);
      }
      return $oTemplate;
    }

    $oTemplate = $this->constructTemplate("page_detail");
    if ($this->oPage->getId() != PagePeer::getRootPage()->getId() && !$this->oPage->isNew()) {
      $oTemplate->replaceIdentifier("parent_id", $this->oPage->getParentId());
      $oTemplate->replaceIdentifier("link_prefix", LinkUtil::link('pages'));
      if(Session::getSession()->getUser()->mayEditPageDetails($this->oPage->getParent())) {
        $oTemplate->replaceIdentifier("parent_title", PagePeer::getRootPage()->getName());
      }
    }

    if ($this->oPage->getId() != PagePeer::getRootPage()->getId()) {
      $oTemplate->replaceIdentifier("dummy", 'ja');
    }
    $oTemplate->replaceIdentifier("action", $this->link($this->oPage->getId()));
    $oTemplate->replaceIdentifier("name", $this->oPage->getName());
    $oTemplate->replaceIdentifier("id", $this->oPage->getId());
    $oTemplate->replaceIdentifier("level", $this->oPage->getLevel());
    $oTemplate->replaceIdentifier("hide_if_needed", $this->oPage->isNew() || $this->oPage->isRoot() ? ' style="visibility:hidden;" ' : '', null, Template::NO_HTML_ESCAPE);
    
    // if not new and if user mayEditPageDetails
    if(!$this->oPage->isNew() && Session::getSession()->getUser()->mayEditPageDetails($this->oPage)) {
      $oContentLinkTemplate = $this->constructTemplate("page_edit_content");
      $sContentLink = LinkUtil::link(array("content", "show", $this->oPage->getId()));
      $oContentLinkTemplate->replaceIdentifier("content_link", $sContentLink);
      $oTemplate->replaceIdentifier("edit_content", $oContentLinkTemplate);
    }
    $aOptions = array();
    foreach(Template::listTemplates() as $sTemplateName) {
      if (Settings::getSetting('frontend', 'main_template', 'general') == $sTemplateName) {
        continue;
      }
      $aOptions[$sTemplateName] = $sTemplateName;
    }

    $oTemplate->replaceIdentifier("template_name_options", TagWriter::optionsFromArray($aOptions, $this->oPage->getTemplateName() === null ? "" : $this->oPage->getTemplateName(), null, array('' => StringPeer::getString('default'))));
    
    $aPageTypeOptions = Module::listModulesByType(PageTypeModule::getType());
    $sPageType = $this->oPage->getPageType() !== null ? $this->oPage->getPageType() : 'default';
    
    /* @todo: fix missing display_name quickfix properly */
    foreach($aPageTypeOptions as $sKey => $aValues) {
      $aPageTypeOptions[$sKey] = isset($aValues['display_name']) ? $aValues['display_name'] : $aValues['name'];
    }
    $oTemplate->replaceIdentifier("page_type_options", TagWriter::optionsFromArray($aPageTypeOptions, $sPageType, null, array()));
    
    $aSortSelect = array();
    if($this->oPage->getId() !== null){
      $oTemplate->replaceIdentifier("title", $this->oPage->getPageTitle());
      
      // sortselect to null, do not show if not applicable (only one, or new etc)
      $aSortSelect = null;
      $aSiblingsForSort = $this->oPage->getSiblings(false);
      $bNeedsSortSelect = count($aSiblingsForSort) > 1;
      if($bNeedsSortSelect) {
        $iKey = 1;
        foreach($aSiblingsForSort as $oSibling) {
          if($oSibling->getSort() === 1 && $oSibling->getSort() < $this->oPage->getSort()) {
            $aSortSelect[$iKey] = StringPeer::getString("page.sort_as_first");
          } elseif($oSibling->getSort() == count($aSiblingsForSort) && $oSibling->getSort() > $this->oPage->getSort()) {
            $aSortSelect[$iKey] = StringPeer::getString('page.sort_as_last');
          } elseif($oSibling->getSort() === $this->oPage->getSort()) {
            $aSortSelect[$iKey] = StringPeer::getString("page.sort_none");
          } elseif($oSibling->getSort() > $this->oPage->getSort()) {
            $aSortSelect[$iKey] = StringPeer::getString("page.sort_after", null, null, array("name" => $oSibling->getLinkText(BackendManager::getContentEditLanguage())));
          } elseif($oSibling->getSort() < $this->oPage->getSort()) {
            $aSortSelect[$iKey] = StringPeer::getString("page.sort_before", null, null, array("name" => $oSibling->getLinkText(BackendManager::getContentEditLanguage())));
          } 
          $iKey ++;
        }
      } 
      if(!$this->oPage->isNew() && $bNeedsSortSelect) {
        $aSortSelect = TagWriter::optionsFromArray($aSortSelect, $this->oPage->getSort(), null, false);
      }
      // only Session users who mayEditPageDetails of parent of current page may change the sort value
      $oTemplate->replaceIdentifier("sort_option_disabled", (Session::getSession()->getUser()->mayEditPageDetails($this->oPage->getParent()) ? '' : ' disabled="disabled"'), null, Template::NO_HTML_ESCAPE);
      $oTemplate->replaceIdentifier("sort_options", $aSortSelect);
      
      // default delete action and message_js
      $sDeleteTemplate = "delete_button_page";
      $sAction = $this->link($this->oPage->getId());
      $sConfirmText = null;
      $sOnAction = 'onsubmit';
      if(Session::getSession()->getUser()->mayDelete($this->oPage)) {
        if($this->oPage->hasChildren() && !Settings::getSetting('backend','delete_pagetree_enable', false)) {
          $sAction = $this->oPage->hasChildren() ? $this->link($this->oPage->getId()) : '';
          $sConfirmText = StringPeer::getString('page.delete_has_children', null, null, array('name' => $this->oPage->getPageTitle()));
          $sOnAction = 'onclick';
          $sDeleteTemplate = "delete_button_inactive";
        } elseif($this->oPage->hasChildren() && Settings::getSetting('backend','inherit_children_enable', false)) {
          $sConfirmText = 'Diese Seite '.$this->oPage->getLinkText().' hat Kinder, diese werden dem Elternelement übergeben';
          if(Settings::getSetting('backend','delete_pagetree_enable', false)) {
            $sConfirmText = 'Diese Seite '.$this->oPage->getLinkText().' hat Kinder!';
          }
        }
      
        $oDeleteTemplate = $this->constructTemplate($sDeleteTemplate);
        $oDeleteTemplate->replaceIdentifier("action", $sAction);
        $oDeleteTemplate->replaceIdentifier("name", $this->oPage->getPageTitle());
        $oDeleteTemplate->replaceIdentifier("on_action", $sOnAction);
        $oDeleteTemplate->replaceIdentifier("message_js", $sConfirmText);
        $oDeleteTemplate->replaceIdentifier("delete_label", StringPeer::getString('delete_page_label'));
        $aDeleteOptions = array();
        if (Session::getSession()->getUser()->getIsAdmin()) {
          if (Settings::getSetting('backend','delete_pagetree_enable', false)) {
            $aDeleteOptions[self::ON_DELETE_CHILDREN_INHERIT] = "vererben!";
            $aDeleteOptions[self::ON_DELETE_CHILDREN_DELETE]  = "ganzer Ast löschen!";
            if($this->oPage->hasChildren()) { 
              $oDeleteTemplate->replaceIdentifier("options_delete_what", TagWriter::optionsFromArray($aDeleteOptions, self::ON_DELETE_CHILDREN_INHERIT,null, array()), null, Template::NO_HTML_ESCAPE);          
            }
          }
        }
        $oDeleteTemplate->replacePstring('delete_item', array('name' => $this->oPage->getPageTitle()));
        $oDeleteTemplate->replacePstring('delete_item_inactive', array('name' => $this->oPage->getPageTitle()));
        $oTemplate->replaceIdentifier("delete_button_page", $oDeleteTemplate);
      }

    }
    // get all Pages for select parent_id
    // @jmg only display optional parent pages if the session user has the right for the parent page too
    // otherwise just display the current parent_id and name
    if(!$this->oPage->isRoot()) {
      $aPagesForParentSelect = $this->getParentIdSelect();
    } else {
      $aPagesForParentSelect = array();
    }
    
    // should be mayEditSectionDetail() ?
    if($this->oPage->isNew() || (Session::getSession()->getUser()->mayEditPageDetails($this->oPage))) {
      $oTemplate->replaceIdentifier("may_edit_page", 'true');
    }
    
    // only Session users who are admin or mayEditPageDetails of all the pages may change the parent_id
    $oTemplate->replaceIdentifier("parent_id_option_disabled", (Session::getSession()->getUser()->mayEditPageDetails(PagePeer::getRootPage()) ? '' : ' disabled="disabled"'), null, Template::NO_HTML_ESCAPE);

    $oTemplate->replaceIdentifier("parent_id_options", TagWriter::optionsFromArray($aPagesForParentSelect, $this->oPage->getParentId(), '_', false));
    $oTemplate->replaceIdentifier("lang", Session::getSession()->getLanguage());
    $sIsInactive = $this->oPage->getIsInactive() === true ? 'checked="checked"' :'';
    $oTemplate->replaceIdentifier("status_is_inactive", $this->oPage->getIsInactive() ? ' inactive' : ' active', null, Template::NO_HTML_ESCAPE);
    $oTemplate->replaceIdentifier("is_inactive", $sIsInactive, null, Template::NO_HTML_ESCAPE);
    $sIsHidden = $this->oPage->getIsHidden() === true ? 'checked="checked"' :'';
    $oTemplate->replaceIdentifier("status_is_hidden", $this->oPage->getIsHidden() ? ' inactive' : ' active', null, Template::NO_HTML_ESCAPE);
    $oTemplate->replaceIdentifier("is_hidden", $sIsHidden, null, Template::NO_HTML_ESCAPE);
    $sIsProtected = $this->oPage->getIsProtected() === true ? 'checked="checked"' :'';
    $oTemplate->replaceIdentifier("status_is_protected", $this->oPage->getIsProtected() ? ' inactive' : ' active', null, Template::NO_HTML_ESCAPE);
    $oTemplate->replaceIdentifier("is_protected", $sIsProtected, null, Template::NO_HTML_ESCAPE);
    
    $sIsFolder = $this->oPage->getIsFolder() === true ? 'checked="checked"' :'';
    $oTemplate->replaceIdentifier("is_folder", $sIsFolder, null, Template::NO_HTML_ESCAPE);
    
    // page properties, if are set in backend.yml or if they exist
    if(Settings::getSetting('backend', 'page_properties_allow', false) || (count($this->oPage->getPageProperties()) > 0)) {
      $oPropertyTemplate = $this->constructTemplate("page_properties");
      
      //Properties
      $aPageProperties = $this->oPage->getPageProperties();
      foreach($aPageProperties as $oPageProperty) {
        $oPagePropertyTemplate = $this->constructTemplate("page_detail_property");
        $oPagePropertyTemplate->replaceIdentifier("id", $oPageProperty->getId());
        $oPagePropertyTemplate->replaceIdentifier("name", $oPageProperty->getName());
        $oPagePropertyTemplate->replaceIdentifier("value", $oPageProperty->getValue());
        $oPropertyTemplate->replaceIdentifierMultiple("properties", $oPagePropertyTemplate);
      }
      
      $oPageTemplate = $this->oPage->getTemplate();
      $aPagePropertiyIdentifiers = $oPageTemplate->identifiersMatching("pageProperty", Template::$ANY_VALUE);
     
      if(count($aPagePropertiyIdentifiers) > 0) {
        $oPropertyTemplate->replaceIdentifier("page_properties_title", StringPeer::getString('page.properties_info'));
        foreach($aPagePropertiyIdentifiers as $oPageProperty) {
          $oPagePropertyIdentifierTemplate = $this->constructTemplate("page_property_identifiers");
          $oPagePropertyIdentifierTemplate->replaceIdentifier("property_name", $oPageProperty->getValue());
          $oPagePropertyIdentifierTemplate->replaceIdentifier("default_value", $oPageProperty->getParameter('defaultValue'));
          $oPropertyTemplate->replaceIdentifierMultiple("page_property_identifiers", $oPagePropertyIdentifierTemplate);
        }
      } else {
        $oPropertyTemplate->replaceIdentifier("page_properties_title", StringPeer::getString('page.properties_no_identifiers'));
      }
      $oTemplate->replaceIdentifier("page_properties", $oPropertyTemplate);
    }
    
    //Page strings
    $aLanguages=LanguagePeer::getLanguages(false, true);
    if($aLanguages != null) {
      foreach($aLanguages as $oLanguage) {
        $oPageString = $this->oPage->getPageStringByLanguage($oLanguage->getId());
        $oTitleTemplate = $this->constructTemplate("page_title");
        if($oPageString !== null) {
          $oTitleTemplate->replaceIdentifier("title", $oPageString->getTitle());
          $oTitleTemplate->replaceIdentifier("long_title", $oPageString->getLongTitle());
          $oTitleTemplate->replaceIdentifier("keywords", $oPageString->getKeywords());
        }
        $oTitleTemplate->replaceIdentifier("language_id", $oLanguage->getId());
        $oTitleTemplate->replaceIdentifier("language", StringPeer::getString('language.'.$oLanguage->getId()));
        $oTitleTemplate->replaceIdentifier("display_class", BackendManager::getContentEditLanguage() == $oLanguage->getId() ? ' open' : '');
        $oTitleTemplate->replaceIdentifier("display_style", BackendManager::getContentEditLanguage() == $oLanguage->getId() ? 'block' : 'none');
      
        $oTemplate->replaceIdentifierMultiple("titles", $oTitleTemplate);
      }
    }
    
    //References
    $oTemplate->replaceIdentifier('references', $this->getReferenceMessages(ReferencePeer::getReferences($this->oPage)));
    return $oTemplate;
  }
  
  private function setParentPagesPerLevel($oPage, $iLevel=0, $bExcludeCurrent=true) {
    if(!$bExcludeCurrent  || ($this->oPage->getId() !== $oPage->getId())) {
      $this->aAllowedParentPages[$oPage->getId()]['name'] = $oPage->getName();
      $this->aAllowedParentPages[$oPage->getId()]['level'] = $iLevel;
    }
    $aChildren = $oPage->getChildren();
    if(count($aChildren)> 0) {
      foreach($aChildren as $oChild) {
        $this->setParentPagesPerLevel($oChild, $iLevel+1);
      }
    }
  }
  
  private function getParentIdSelect() {
    $this->setParentPagesPerLevel(PagePeer::getRootPage(), 0);
    $aPagesForParentSelect = array();
    foreach($this->aAllowedParentPages as $iId => $aPage) {
      $sIndent = '';
      for($i=0; $i <$aPage['level']; $i++) {
        $sIndent .= '_';
      }
      $aPagesForParentSelect[$iId]=$sIndent.$aPage['name'];
    }
    return $aPagesForParentSelect;
  }
  
  public function create() {
    $this->oPage = new Page();
    $this->oPage->setParentId((int)$_REQUEST['parent_id']);
    $this->oPage->setName(self::$NEW_PAGE_DEFAULT_NAME);
    $this->oPage->setIsInactive(true);
    $this->oPage->setIsHidden(false);
    $this->oPage->setIsFolder(false);
  }

  public function delete() {
    $oFlash = Flash::getFlash();
    if(!Session::getSession()->getUser()->mayDelete($this->oPage)){
      $oFlash->addMessage('page_delete_forbidden');
    }
    try {
      $oParent = $this->oPage->getParent();
      $iRedirectId = $oParent === null ? "" : $oParent->getId();
      if($this->oPage->hasChildren() && isset($_POST['delete_what'])) {
        if($_POST['delete_what'] == self::ON_DELETE_CHILDREN_DELETE && Session::getSession()->getUser()->getIsAdmin()) {
          $this->oPage->deletePageAndDescendants();
          LinkUtil::redirect($this->link());
          
        } elseif($_POST['delete_what'] == self::ON_DELETE_CHILDREN_INHERIT) {
          $iNewParentId = $this->oPage->getParentId();
          foreach($this->oPage->getChildren() as $oChild) {
            $oChild->setParentId($iNewParentId);
            $oChild->save();
          }
        }
      }
      
      $this->oPage->delete();
      $this->oPage = null;
      if($oParent->hasChildren()) {
        foreach($oParent->getChildren() as $i => $oChild) {
          $oChild->setSort($i+1);
          $oChild->save();
        }
      }
      
    } catch (Exception $e) {
      if($e->getCode() == Page::DELETE_NOT_ALLOWED_CODE) {
        $oFlash->addMessage('page_delete_has_children');
      } else if ($e->getCode() == Page::REFERENCE_EXISTS_CODE) {
        $oFlash->addMessage('page_delete_has_references');
      } else {
        throw $e;
      }
    }
    $oFlash->finishReporting();
    if(Flash::noErrors()) {
      LinkUtil::redirect($this->link());
    }
  }
  
  protected function validateForm($oFlash) {
    if($this->oPage === null) {
      if(!Session::getSession()->getUser()->mayCreateChildren(PagePeer::retrieveByPk($_POST['parent_id']))){
        $oFlash->addMessage('page_create_forbidden');
      }
      $this->create();
    } elseif (!Session::getSession()->getUser()->mayEditPageDetails($this->oPage)){
      $oFlash->addMessage('page_detail_forbidden');
    }
    
    if($this->oPage->isRoot()) {
      $_POST['parent_id'] = $this->oPage->getParentId();
    }
    
    // if moved page onto itself
    if((int)$_POST['parent_id'] === $this->oPage->getId()) {
      $oFlash->addMessage('parent_id_is_self');
    }
    
   
    // write path name if it is missing long_title is filled in
    $sContentEditLanguage = BackendManager::getContentEditLanguage();
    if($_POST['name'] == '') {
      if(isset($_POST['title'][$sContentEditLanguage]) && $_POST['title'][$sContentEditLanguage] !== '') {
        $_POST['name'] = StringUtil::normalize($_POST['title'][$sContentEditLanguage]);
      } else if(isset($_POST['long_title'][$sContentEditLanguage])) {
        $_POST['name'] = StringUtil::normalize($_POST['long_title'][$sContentEditLanguage]);
      }
    }
    
    if(!$this->oPage->isRoot()) {
      // strangely given a non-numeric parent id
      $oFlash->checkForNumber('parent_id', 'parent_id_numeric');
    
      // if page is moved check if user may do so for the target page
      if($_POST['parent_id'] != $this->oPage->getParentId()) { 
         if(!Session::getSession()->getUser()->mayCreateChildren(PagePeer::retrieveByPk($_POST['parent_id']))){
          $oFlash->addMessage('parent_id_forbidden');
          $_POST['parent_id'] = $this->oPage->getParentId();
        }
      }
    }
    // check for uniqueness of name and parent_id
    if(PagePeer::pageIsNotUnique(StringUtil::normalize($_POST['name']), $_POST['parent_id'], $this->oPage->getId())) {
      $oFlash->addMessage('page_name_duplicated');
    }
    
    // page name validation
    try {
      if(strlen(StringUtil::normalize($_POST['name'])) < 3){
        $oFlash->addMessage('page_name');
      }
    } catch(Exception $e) {
      $oFlash->addMessage('page_name');
      $_POST['name'] = $this->oPage->getName();
    }
    
    // the currently edited page long_title has to be correctly enteres
    if(isset($_POST['long_title'][$sContentEditLanguage]) && $_POST['long_title'][$sContentEditLanguage] === '') {
      $oFlash->addMessage('page_title');
    }
  }
  
  private function sortPages() {
    $oCriteria=new Criteria();
    $oCriteria->add(PagePeer::PARENT_ID, $_POST['parent_id']);
    $oCriteria->addAscendingOrderByColumn(PagePeer::SORT);
    $aSiblingsToBeSorted = PagePeer::doSelect($oCriteria);
    $iCountSiblings = count($aSiblingsToBeSorted);

    // unset current sibling
    foreach($aSiblingsToBeSorted as $iKey => $oSibling) {
      if($oSibling->getId() === $this->oPage->getId()) {
        unset($aSiblingsToBeSorted[$iKey]);
        break;
      }
    }

    // add current sibling at new position
    $aSiblingsNewlySorted = array();
    $iCount = 1;
    $bIsFrst = false;
    foreach($aSiblingsToBeSorted as $iKey => $oSibling) {
      if(($_POST['sort'] == 1) && !$bIsFrst) {
        $bIsFrst = true;
        $aSiblingsNewlySorted[$iCount] = $this->oPage;
        $iCount++;
      }
      $aSiblingsNewlySorted[$iCount] = $oSibling;
      $iCount++;
  
      if(($_POST['sort'] == ($iCount)) && !$bIsFrst) {
        $aSiblingsNewlySorted[$iCount] = $this->oPage;
        $iCount++;
      }
    }

    // save newly ordered siblings
    foreach($aSiblingsNewlySorted as $iKey => $oNewSorted) {
      $oNewSorted->setSort($iKey);
      if(Flash::noErrors()) {
        $oNewSorted->save();
      }
    }
  }

  public function save() {
    // Set parent_id, name and flags
    $iParentId = is_numeric($_POST['parent_id']) ? (int)$_POST['parent_id'] : null;
    $this->oPage->setParentId($iParentId);
    
    $this->oPage->setIsInactive(isset($_POST['is_inactive']));
    $this->oPage->setIsHidden(isset($_POST['is_hidden']));
    $this->oPage->setIsFolder(isset($_POST['is_folder']));
    $this->oPage->setIsProtected(isset($_POST['is_protected']));

    if($_POST['template_name'] === "") {
      $this->oPage->setTemplateName(null);
    } else {
      $this->oPage->setTemplateName($_POST['template_name']);
    }

    // set param 'sort', if page is new
    if($this->oPage->isNew()) { 
      $oCriteria=new Criteria();
      $oCriteria->add(PagePeer::PARENT_ID, $_POST['parent_id']);
      $iSort = PagePeer::doCount($oCriteria) + 1;
      $this->oPage->setSort($iSort); 
    } 
    // if param 'sort' has changed
    elseif (Session::getSession()->getUser()->mayEditPageDetails($this->oPage->getParent()) 
            && isset($_POST['sort']) 
            && ($this->oPage->getSort() != $_POST['sort'])) {
      $this->sortPages();
    }
    
    // set name
    $this->oPage->setName(StringUtil::normalize($_POST['name']));
    
    //set page type
    $this->oPage->setPageType($_POST['page_type']);
    
    // set page properties
    $this->setPageProperties();
    
    // save the title and description in all languages
    if(isset($_POST['long_title'])) {
      $aLanguages = LanguagePeer::doSelect(new Criteria());
      foreach($aLanguages as $oLanguage) {
        $oPageString = $this->oPage->getPageStringByLanguage($oLanguage->getId());
        //Delete all empty pagestrings
        if(isset($_POST['long_title'][$oLanguage->getId()]) && $_POST['long_title'][$oLanguage->getId()] == '') {
          if($oPageString && Flash::noErrors()) {
            $oPageString->delete();
          }
        } else if(isset($_POST['long_title'][$oLanguage->getId()])) {
          if($oPageString === null) {
            $oPageString = new PageString();
            $this->oPage->addPageString($oPageString);
            $oPageString->setLanguageId($oLanguage->getId());
          }

          $oPageString->setLongTitle($_POST['long_title'][$oLanguage->getId()]);

          if(isset($_POST['title']) && isset($_POST['title'][$oLanguage->getId()]) && $_POST['title'][$oLanguage->getId()] != '') {
            $oPageString->setTitle($_POST['title'][$oLanguage->getId()]);
          } else {
            $oPageString->setTitle(null);
          }

          if(isset($_POST['keywords']) && isset($_POST['keywords'][$oLanguage->getId()]) && $_POST['keywords'][$oLanguage->getId()] != '') {
            $oPageString->setKeywords($_POST['keywords'][$oLanguage->getId()]);
          } else {
            $oPageString->setKeywords(null);
          }

          if(Flash::noErrors()) {
            $oPageString->save();
          }
        }
      }
    }

    if(Flash::noErrors()) {
      $this->oPage->save();
      
      // set user rights for page
      $oUser = Session::getSession()->getUser();
      $aMissingRights = $oUser->getMissingRights($this->oPage, true);
      
      if(!$oUser->getIsAdmin() && count($aMissingRights)>0) {
        $oGroup = GroupPeer::getGroupByName($this->oPage->getName().'_manager');
        if($oGroup === null) {
          $oGroup = new Group();
          $oGroup->setName($this->oPage->getName().'_manager');
        }
        $oGroup->addUser($oUser);
        $oGroup->save();
        $oRight = new Right();
        $oRight->setPage($this->oPage);
        $oRight->setGroup($oGroup);
        foreach($aMissingRights as $sRightName) {
          call_user_func(array($oRight, 'setMay'.$sRightName), true);
        }
        $oRight->setIsInherited(true);
        $oRight->save();
      }

      LinkUtil::redirect($this->link($this->oPage->getId()));
    }
  }
  
  private function setPageProperties() {
    $aPropertyNames = array();
    
    // modify or delete existing properties
    foreach($this->oPage->getPageProperties() as $oPageProperty) {
      if(!isset($_POST["property_name_".$oPageProperty->getId()])) {
        continue;
      }
      $sName = $_POST["property_name_".$oPageProperty->getId()];
      $sValue = $_POST["property_value_".$oPageProperty->getId()];
      if(($sName === "" || in_array($sName, $aPropertyNames)) && Flash::noErrors()) {
        $oPageProperty->delete();
        continue;
      }
      $oPageProperty->setName($sName);
      $oPageProperty->setValue($sValue);
      if(Flash::noErrors()) {
        $aPropertyNames[] = $sName;
        $oPageProperty->save();
      }
    }
    
    // set new page properties
    if(isset($_POST['property_name_'])) {
      foreach($_POST['property_name_'] as $iNewPropertyIndex => $sNewPropertyName) {
        $sNewPropertyValue = $_POST['property_value_'][$iNewPropertyIndex];
        $oPageProperty = new PageProperty();
        $oPageProperty->setName($sNewPropertyName);
        $oPageProperty->setValue($sNewPropertyValue);
        $bKeyIsNew = (!in_array($sNewPropertyName, $aPropertyNames)) && $sNewPropertyName !== '';
        if(Flash::noErrors() && $bKeyIsNew) {
          $aPropertyNames[] = $sNewPropertyName;
          $oPageProperty->save();
        }
        if($bKeyIsNew) {
          $this->oPage->addPageProperty($oPageProperty);
        }
      }
    }
  }
  
  public function getModelName() {
    return "Page";
  }
  
  public function getCurrentId() {
    if(!$this->oPage) {
      return null;
    }
    return $this->oPage->getId();
  }
  
  public function getNewEntryActionParams() {
    if($this->oPage !== null && $this->oPage->isNew()) {
      return null;
    }
    $bShowSelect = true;
    $aOptionsArray = array();
    if($this->oPage !== null && $this->oPage->getId() !== PagePeer::getRootPage()->getId()
      && Session::getSession()->getUser()->mayCreateChildren(PagePeer::retrieveByPk($this->oPage->getParentId()))) {
      $sNameTruncated = StringUtil::truncate($this->oPage->getLinkTextIfExists(BackendManager::getContentEditLanguage()), 10);
      $iParentId = $this->oPage->getParentId();
      $aOptionsArray[$this->oPage->getParentId()] = StringPeer::getString('page.sibling_of').' '.$sNameTruncated;
      $aOptionsArray[$this->oPage->getId()] = StringPeer::getString('page.child_of').' '.$sNameTruncated;
    } else if (Session::getSession()->getUser()->mayCreateChildren(PagePeer::retrieveByPk(PagePeer::getRootPage()->getId()))) {
      $oRootPage = PagePeer::getRootPage();
      $iParentId = $oRootPage->getId();
      $aOptionsArray[$oRootPage->getId()] = StringPeer::getString('page.child_of').' '.StringUtil::truncate($oRootPage->getLinkTextIfExists(BackendManager::getContentEditLanguage()), 10);
    } else {
      $bShowSelect = false;
    }
    if($bShowSelect) {
      $sSelect = TagWriter::QuickTag('select', array('name' => 'parent_id'), TagWriter::optionsFromArray($aOptionsArray, $iParentId, null, array()));
      return array('action' => $this->link(), 'custom' => $sSelect);
    }
  }
}