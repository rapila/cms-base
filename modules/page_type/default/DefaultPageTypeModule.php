<?php
/**
  * @package modules.page_type
  */
class DefaultPageTypeModule extends PageTypeModule {
  
  private $oFrontendTemplate;
  private $iModuleId;
  
  private static $COMPARISONS = array("eq" => "==",
                                      "ne" => "!==",
                                      "gt" => ">",
                                      "gte" => ">=",
                                      "lt" => "<",
                                      "lte" => "<=",
                                      "~" => "~",
                                      "contains" => "contains",
                                      "file_exists" => "file_exists");
  
  public function __construct(Page $oPage) {
    parent::__construct($oPage);
  }
  
  //Frontend stuff
  public function display(Template $oTemplate) {
    $this->oFrontendTemplate = $oTemplate;
    $this->iModuleId = 1;
    $this->oFrontendTemplate->replaceIdentifierCallback("container", $this, "fillContainer", Template::NO_HTML_ESCAPE);
  }
  
  public function fillContainer($oTemplateIdentifier, $iFlags) {
    if($oTemplateIdentifier->hasParameter('autofill')) {
      $oTemplate = new Template(TemplateIdentifier::constructIdentifier('container'), null, true);
      $oModule = FrontendModule::getModuleInstance($oTemplateIdentifier->getParameter('autofill'), $oTemplateIdentifier->getParameter('data'));
      $oTemplate->replaceIdentifierMultiple("container", $oModule->renderFrontend(), null, Template::NO_HTML_ESCAPE);
      $oTemplate->replaceIdentifierMultiple("custom_css", $oModule->getCssForFrontend());
      $oTemplate->replaceIdentifierMultiple("custom_js", $oModule->getJsForFrontend());
      return $oTemplate;
    }
    
    $bInheritContainer = Settings::getSetting("frontend", "inherit_contents", false);
    $sExpectedSetting = BooleanParser::stringForBoolean(!$bInheritContainer);
    if($oTemplateIdentifier->getParameter("inherit") === $sExpectedSetting) {
      $bInheritContainer = !$bInheritContainer;
    }
    $sContainerName = $oTemplateIdentifier->getValue();
    $aPageObjects = $this->oPage->getObjectsForContainer($sContainerName);
    if(count($aPageObjects) === 0 && $bInheritContainer) {
      $aPageObjects = array();
      $oParent = $this->oPage;
      do {
        $aPageObjects = $oParent->getObjectsForContainer($sContainerName);
      } while (($oParent = $oParent->getParent()) !== null && count($aPageObjects) === 0);
    }
    if(count($aPageObjects) === 0) {
      return null;
    }
    
    $aObjectTypes = array();
    $oTemplate = new Template(TemplateIdentifier::constructIdentifier('container'), null, true);
    foreach($aPageObjects as $oContainer) {
      if($this->fillContainerWithModule($oContainer, $oTemplate, $this->iModuleId) === false) {
        continue;
      }
      // FilterModule::getFilters()->handleDefaultPageTypeFilledContainer($oContainer, $this->oPage, $oTemplate, $this->oFrontendTemplate, $this->iModuleId);
      $this->iModuleId++;
      
      if(isset($aObjectTypes[$oContainer->getObjectType()])) {
        $aObjectTypes[$oContainer->getObjectType()]++;
      } else {
        $aObjectTypes[$oContainer->getObjectType()] = 1;
      }
    }
    $this->oFrontendTemplate->replaceIdentifier("container_filled_types", implode(',', array_keys($aObjectTypes)), $sContainerName);
    
    if(count($aObjectTypes) === 0) {
      return null;
    }
    
    return $oTemplate;
  } // fillOneContainer()
      
  /**
   * fillContainerWithModule()
   */
  private function fillContainerWithModule($oContentObject, $oTemplate, $iModuleId) {
    $oPageContents = $oContentObject->getActiveLanguageObject();
    if($oPageContents === null) {
      return false;
    }
    if($oContentObject->getConditionSerialized() && $oContentObject->getConditionSerialized()->getContents()) {
      $oConditionTemplate = unserialize($oContentObject->getConditionSerialized()->getContents());
      if($oConditionTemplate->render() === '') {
        return false;
      }
    }
    $oModule = FrontendModule::getModuleInstance($oContentObject->getObjectType(), $oPageContents, $iModuleId);
    $sFrontentContents = $this->getModuleContents($oModule);
    if($sFrontentContents === null) {
      return false;
    }
    FilterModule::getFilters()->handleDefaultPageTypeFilledContainerWithModule($oContentObject, $oModule, $oTemplate, $this->oFrontendTemplate, $this->iModuleId);
    $oTemplate->replaceIdentifierMultiple("container", $sFrontentContents, null, Template::NO_HTML_ESCAPE);
    $this->oFrontendTemplate->replaceIdentifierMultiple("custom_css", $oModule->getCssForFrontend());
    $this->oFrontendTemplate->replaceIdentifierMultiple("custom_js", $oModule->getJsForFrontend());
    
    if(Session::getSession()->isAuthenticated() && Session::getSession()->getUser()->mayEditPageContents($oContentObject->getPage())) {
      //Print Edit link
      $sEditImage = TagWriter::quickTag("img", array('src' => INT_IMAGES_DIR_FE.'/admin/edit_fe.gif', 'alt'=> StringPeer::getString("edit")));
      
      $oTag = TagWriter::quickTag("a", array("href" => Util::link(array('content', $oContentObject->getPage()->getId(), 'edit', $oContentObject->getId()), "BackendManager"), 'style' => 'float:left;z-index=1000;margin:-20px 0 0 -20px;padding:0;margin:0;display:block;text-decoration:none;border:none;line-height:0;font-size:1px;', "title" => StringPeer::getString("content_edit")), $sEditImage);
      $oTemplate->replaceIdentifierMultiple("container", $oTag);
    }
    return true;
  } // fillContainerWithModule()
  
  protected function getModuleContents($oModule) {
    return $oModule->renderFrontend();
  }
  
  public function setIsDynamicAndAllowedParameterPointers(&$bIsDynamic, &$aAllowedParams) {
    foreach($this->oPage->getContentObjects() as $oContentObject) {
      $sModuleName = Module::getClassNameByTypeAndName(FrontendModule::getType(), $oContentObject->getObjectType());
      if(call_user_func(array($sModuleName, "isDynamic"))) {
        $bIsDynamic = true;
        $aAllowedParams = array_merge($aAllowedParams, call_user_func(array($sModuleName, "acceptedRequestParams")));
      }
    }
  }
  
  //Backend stuff
  private $oCurrentContentObject = null;
  private $oCurrentLanguageObject = null;
  protected $sMethod = "show";
  private $aAllPages = array();
  
  private $bBackupOverride = false;
  
  private $oModuleInstance = null;
  
  public function backendInit() {
    if(Manager::hasNextPathItem()) {
      $this->sMethod = Manager::usePath();
    }
    if(Manager::hasNextPathItem()) {
      $this->oCurrentContentObject = ContentObjectPeer::retrieveByPk(Manager::usePath());
    }
  }
  
  public function backendDisplay() {
    if($this->sMethod !== null) {
      switch($this->sMethod) {
        case "show":
          return $this->executeShow();
        case "edit":
          return $this->executeEdit();
      }
    }
  }

  private function executeShow() {
    $bMayEditContents = Session::getSession()->getUser()->mayEditPageContents($this->oPage);
    $oTemplate = $this->constructTemplate("content_show".($bMayEditContents ? "" : "_forbidden"));
    
    $oTemplate->replaceIdentifier("title", $this->oPage->getPageTitle(BackendManager::getContentEditLanguage()));
    $this->backendCustomJs = $this->constructTemplate("show.js")->render();

    if($bMayEditContents) {
      $oPageTemplate = $this->oPage->getTemplate();
      $oTemplate->replaceIdentifier("template_name_used", $this->oPage->getTemplateNameUsed());
      $aContainers = $oPageTemplate->identifiersMatching("container", Template::$ANY_VALUE);
      asort($aContainers);
        
      foreach($aContainers as $oContainer) {
        if($oContainer->hasParameter('autofill')) {
          continue;
        }
        $sContainerName = $oContainer->getValue();
        $oContainerTemplate = $this->constructTemplate("content_container");
        $oContainerTemplate->replaceIdentifier("inherit_info", $oContainer->getParameter('inherit') ? StringPeer::getString('container.inherit_message') : null);
        $oContainerTemplate->replaceIdentifier("container_name", $sContainerName);
        $oContainerTemplate->replaceIdentifier("new_link", $this->backendLink(array($this->oPage->getId(), "edit", $sContainerName)));
      
        $aContentModuleNames = FrontendModule::listContentModules();
        $aAllowedItems = array();
        if($oContainer->hasParameter("allowed_modules")) {
          foreach(Util::trimStringsInArray(explode(",", $oContainer->getParameter("allowed_modules"))) as $sAllowedModuleName) {
            if(isset($aContentModuleNames[$sAllowedModuleName])) {
              $aAllowedItems[$sAllowedModuleName] = $aContentModuleNames[$sAllowedModuleName];
            }
          }
        } else {
          $aAllowedItems = $aContentModuleNames;
        }
        // order by displayName and add choose
        asort($aAllowedItems);
        $oContainerTemplate->replaceIdentifier("module_name_options", Util::optionsFromArray($aAllowedItems, null, null));
        $oContainerTemplate->replaceIdentifier("container_name", $sContainerName);
        
        $aObjects = $this->oPage->getObjectsForContainer($sContainerName);
        $bHasNoObjects = count($aObjects) === 0;
        foreach($aObjects as $iCount => $oObject) {
          $oObjectTemplate = $this->constructTemplate("content_object");
          if($iCount === 0) {
            $oContainerTemplate->replaceIdentifierMultiple("arrow_up", TagWriter::quickTag('div', array('class' => 'up_arrow placeholder'), new Template("&nbsp;", null, true)));
          } else {
            $oContainerTemplate->replaceIdentifierMultiple("arrow_up", TagWriter::quickTag('div', array('class' => 'up_arrow', 'container' => $sContainerName, 'page_id' => $this->oPage->getId()), TagWriter::quickTag('img', array('src' => INT_IMAGES_DIR_FE.'/admin/arrow_up.png'))));
          }
          $oLanguageObject = $oObject->getActiveLanguageObjectBe();
          $oObjectTemplate->replaceIdentifier("title", $oObject->getContainerName());
          $oObjectTemplate->replaceIdentifier("type", $oObject->getObjectTypeName());
          $oObjectTemplate->replaceIdentifier("edit_link", $this->backendLink(array($this->oPage->getId(), "edit", $oObject->getId())));
          $oObjectTemplate->replaceIdentifier("action", $this->backendLink(array($this->oPage->getId(), "show", $oObject->getId())));
          if($oLanguageObject === null) {
            $oObjectTemplate->replaceIdentifier("content_info", TagWriter::quickTag('em', array(), StringPeer::getString('empty')));
          } else {
            $sFrontendModuleClass = FrontendModule::getClassNameByName($oObject->getObjectType());
            $mContentInfo = call_user_func(array($sFrontendModuleClass, 'getContentInfo'), $oLanguageObject);
            if($mContentInfo) {
              $oObjectTemplate->replaceIdentifier("content_info", $mContentInfo);
            }
          }
          $oContainerTemplate->replaceIdentifierMultiple("objects", $oObjectTemplate);
          $iCount++;
        }
        if($bHasNoObjects) {
          $oContainerTemplate->replaceIdentifierMultiple("objects", StringPeer::getString('objects.no_entries_message'));
        }
        $oTemplate->replaceIdentifierMultiple("containers", $oContainerTemplate);
      }
    }
    return $oTemplate;
  }

  private function newContentObject() {
    $this->oCurrentContentObject = new ContentObject();
    $this->oCurrentContentObject->setPage($this->oPage);
    $this->oCurrentContentObject->setContainerName(Manager::unusePath());
    $this->oCurrentContentObject->setObjectType(isset($_REQUEST['module_name']) ? $_REQUEST['module_name'] : '');
    $this->oCurrentContentObject->setSort(99); //High value so that the new object will appear at the bottom – until re-sorted, that is. If a new object is created before that, it will have a higher ID and thus appear even later in sort order
  }

  private function getLanguageObject() {
    if($this->oCurrentContentObject === null) {
      $this->newContentObject();
    }
    if($this->oCurrentLanguageObject !== null) {
      return $this->oCurrentLanguageObject;
    }
    $this->oCurrentLanguageObject = $this->oCurrentContentObject->getActiveLanguageObjectBe();
    if($this->oCurrentLanguageObject === null) {
      $this->oCurrentLanguageObject = new LanguageObject();
      $this->oCurrentLanguageObject->setCreatedBy(Session::getSession()->getUserId());
      $this->oCurrentLanguageObject->setCreatedAt(date('c'));
      $this->oCurrentLanguageObject->setLanguageId(BackendManager::getContentEditLanguage());
      $this->oCurrentLanguageObject->setContentObject($this->oCurrentContentObject);
      $this->oCurrentLanguageObject->setData(new Blob());
    }
    return $this->oCurrentLanguageObject;
  }
  
  private function getFrontendModuleInstance() {
    if($this->oModuleInstance === null) {
      $this->oModuleInstance = FrontendModule::getModuleInstance($this->oCurrentContentObject->getObjectType(), $this->getLanguageObject());
    }
    return $this->oModuleInstance;
  }

  private function executeEdit() {
    $oLanguageObject = $this->getLanguageObject();
    $aLanguageObjectRevisions = LanguageObjectHistoryPeer::getHistoryByLanguageObject($oLanguageObject);
    $oLanguageObject->revertToHistory(@$_REQUEST['language_object_revision_id']);
    
    $oModule = $this->getFrontendModuleInstance();
    $this->backendCustomJs = $oModule->getJsForBackend();
    
    $oTemplate = $this->constructTemplate("content_edit");
    $oTemplate->replaceIdentifier('is_new', $this->oCurrentContentObject->isNew());
    if($this->oCurrentContentObject->isNew()) {
      $oTemplate->replaceIdentifier("action", $this->backendLink(array($this->oPage->getId(), "edit", $this->oCurrentContentObject->getContainerName())));
    } else {
      $oTemplate->replaceIdentifier("action", $this->backendLink(array($this->oPage->getId(), "edit", $this->oCurrentContentObject->getId())));
      $oTemplate->replaceIdentifier('timestamp', $oLanguageObject->getTimestamp());
      if($this->bBackupOverride) {
        $oTemplate->replaceIdentifier("readonly_history_override", true);
      }
    }
    $oTemplate->replaceIdentifier("show_url", $this->backendLink(array($this->oPage->getId(), "show")));
    $oTemplate->replaceIdentifier("content", $oModule->renderBackend(), null, Template::NO_HTML_ESCAPE);
    
    //Condition-management
    $sComparatorValue = null;
    if($this->oCurrentContentObject->getConditionSerialized() && $this->oCurrentContentObject->getConditionSerialized()->getContents()) {
      $oConditionTemplate = unserialize($this->oCurrentContentObject->getConditionSerialized()->getContents());
      $oIfIdentifier = $oConditionTemplate->identifiersMatching('if', Template::$ANY_VALUE);
      $oIfIdentifier = $oIfIdentifier[0];
      $oTemplate->replaceIdentifier("comparison_1", $oIfIdentifier->getParameter('1'));
      $oTemplate->replaceIdentifier("comparison_2", $oIfIdentifier->getParameter('2'));
      $sComparatorValue = $oIfIdentifier->getValue();
    }
    $oTemplate->replaceIdentifier("comparator_options", Util::optionsFromArray(self::$COMPARISONS, $sComparatorValue, null, null));
    
    // handle revisions select
    if(!$oLanguageObject->isNew() && count($aLanguageObjectRevisions) > 0) {
      $sSelected = null;
      $sDefaultOptionString = 'choose';
      if(isset($_REQUEST['language_object_revision_id']) && $_REQUEST['language_object_revision_id'] !== '') {
        $sSelected = (int)$_REQUEST['language_object_revision_id'];
        $sDefaultOptionString = 'revert_to_current';
      } 
      $oTemplate->replaceIdentifier("language_object_revisions", Util::optionsFromObjects($aLanguageObjectRevisions, 'getRevision', 'getName', $sSelected, array( '' => StringPeer::getString($sDefaultOptionString))));
    }
    
    $oTemplate->replaceIdentifier("page_title", $this->oPage->getLinkText());   
    $oTemplate->replaceIdentifier("module_name", $this->oCurrentContentObject->getObjectType());   
    $oTemplate->replaceIdentifier("container_name", $this->oCurrentContentObject->getContainerName());   
    return $oTemplate;
  }
  
  public function delete() {
    if(!Session::getSession()->getUser()->mayEditPageContents($this->oPage)) {
      return;
    }
    if($this->oCurrentContentObject !== null && $this->oCurrentContentObject->getActiveLanguageObjectBe() !== null) {
      $this->oCurrentContentObject->getActiveLanguageObjectBe ()->delete();
    }
    $oLanguageObjects = $this->oCurrentContentObject->getLanguageObjects();
    // should LanguageObjectHistory be deleted too?
    if(count($oLanguageObjects) === 0) {
      $this->oCurrentContentObject->delete();
    }
  }
  
  public function backendSave($sRedirectUrl=null) {
    $oLanguageObjectHistory = null;
    if(!Session::getSession()->getUser()->mayEditPageContents($this->oPage)) {
      return;
    }
    
    $iTimestamp = (int)$_POST['timestamp'];
    
    $oLanguageObject = $this->getLanguageObject();
    //Condition-management
    if(!$_POST['comparison_1']) {
      $this->oCurrentContentObject->setConditionSerialized(null);
    } else {
      $oTemplate = new Template("", null, true);
      $aTemplateContents = array();
      $oIf = new TemplateIdentifier("if", $_POST['comparator'], array(), $oTemplate);
      $oIf->setParameter('1', $_POST['comparison_1']);
      $oIf->setParameter('2', $_POST['comparison_2']);
      $aTemplateContents[] = $oIf;
      $aTemplateContents[] = "visible";
      $aTemplateContents[] = new TemplateIdentifier("endIf", null, array(), $oTemplate);
      $oTemplate = new Template($aTemplateContents, null, true);
      $this->oCurrentContentObject->setConditionSerialized(new Blob(serialize($oTemplate)));
    }
    unset($_POST['comparison_1']);
    unset($_POST['comparison_2']);
    unset($_POST['comparator']);
    unset($_POST['timestamp']);
    
    //Look at the timestamp
    if(!$oLanguageObject->isNew() && $iTimestamp !== $oLanguageObject->getTimestamp()) {
      $oFlash = Flash::getFlash();
      $oFlash->unfinishReporting();
      $oFlash->addMessage('page_content_changed_since');
      $oFlash->finishReporting();
      
      //Set all the properties correctly
      $this->bBackupOverride = true;
    }
    
    //Save history
    if(isset($_POST['create_history']) && !$oLanguageObject->isNew()) {
      $oLanguageObjectHistory = new LanguageObjectHistory();
      $oLanguageObjectHistory->setData(clone $oLanguageObject->getData());
    }
    
    //Save data
    $oModule = $this->getFrontendModuleInstance();
    $oModule->save($oLanguageObject->getData());
    $oLanguageObject->setData($oLanguageObject->getData());
    
    //Write object to db
    if(!Flash::noErrors()) {
      return;
    }
    $this->oCurrentContentObject->save();
    $oLanguageObject->save();
    ReferencePeer::saveUnsavedReferences();
    if($oLanguageObjectHistory !== null) {
      $oLanguageObjectHistory->setObjectId($oLanguageObject->getObjectId());
      $oLanguageObjectHistory->setLanguageId($oLanguageObject->getLanguageId());
      $oLanguageObjectHistory->save();
    }
    if($sRedirectUrl === null) {
      $sRedirectUrl = $this->backendLink(array($this->oPage->getId(), "edit", $this->oCurrentContentObject->getId()));
    }
    Util::redirect($sRedirectUrl);
  }
  
  public function getAjax($aPath) {
    $sContainerName = $_REQUEST['container'];
    $iItemNumber = $_REQUEST['item_number']+0;
    foreach($this->oPage->getObjectsForContainer($sContainerName) as $iCount => $oContentObject) {
      if($iItemNumber === $iCount+1) {
        $iCount++;
      } else if($iItemNumber === $iCount) {
        $iCount--;
      }
      $oContentObject->setSort($iCount);
      $oContentObject->save();
    }
    print <<<EOD
<success/>
EOD;
  }
}