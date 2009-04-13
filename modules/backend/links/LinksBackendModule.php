<?php
/**
 * @package modules.backend
 */
class LinksBackendModule extends BackendModule {
  
  private $oLink = null;
  private $sSelectedTagName;
  private $oListHelper;
  private $bUntaggedItemsOnly = false; //get tagged items if exist
  
  public function __construct() {
    if(Manager::hasNextPathItem()) {
      $this->oLink = LinkPeer::retrieveByPk(Manager::usePath()); 
    }
    
    $this->oListHelper = new ListHelper($this);
  }
  
  public function getChooser() {
    $oTemplate = $this->constructTemplate('list');
    
    $aTagsUsedInLinkModule = TagPeer::getTagsUsedInModel($this->getModelName());
    $oTemplate->replaceIdentifierMultiple('filter_selector', $this->oListHelper->getFilterSelectForTagFilter());
    $oTemplate->replaceIdentifierMultiple('filter_selector', $this->oListHelper->getFilterSelect(LinkPeer::URL, LinkPeer::getProtocolsWithLinksAssoc(), StringPeer::getString('links.all_protocols'), null, ListHelper::SELECTION_TYPE_BEGINS));
    
    $oTemplate->replaceIdentifierMultiple("sort_link", $this->oListHelper->getSortColumn(LinkPeer::NAME, 'name', true));
    $oTemplate->replaceIdentifierMultiple("sort_link", $this->oListHelper->getSortColumn(LinkPeer::UPDATED_AT, 'date'));
    
    $oCriteria = new Criteria();
    $this->oListHelper->handle($oCriteria);
    $aLinks = LinkPeer::doSelect($oCriteria);

    $this->parseTree($oTemplate, $aLinks, $this->oLink);
    return $oTemplate;
  }
  
  public function getDetail() {
    if(!$this->oLink) {
      $oTemplate = $this->constructTemplate("module_info");
      $oTemplate->replaceIdentifier('create_link', TagWriter::quickTag('a', array('href' => LinkUtil::link('links', null, array('action' => 'create'))), StringPeer::getString('links.create')));
      return $oTemplate;
    }
    $oTemplate = $this->constructTemplate("detail");
    $oTemplate->replaceIdentifier('module_info_link', TagWriter::quickTag('a', array('title' => StringPeer::getString('module_info'), 'class' => 'help', 'href' => LinkUtil::link('links'))));
    
    if(!$this->oLink->isNew()) {
      // Reference Handling needs to be checked, maybe used not only in pages, might be other objects too?
      $aReferences = ReferencePeer::getReferences($this->oLink);
      $bHasReferences = count($aReferences) > 0;
      if($bHasReferences) {
        $oTemplate->replaceIdentifier('references', $this->getReferenceMessages($aReferences));
        $oDeleteTemplate = $this->constructTemplate("delete_button_inactive", true);
        $sDeleteItemMessage = "delete_item_inactive";
        $oDeleteTemplate->replaceIdentifier("message_js", StringPeer::getString('document.has_references'));
      } else {
        $oDeleteTemplate = $this->constructTemplate("delete_button", true);
      }
      $oDeleteTemplate->replacePstring("delete_item", array('name' => $this->oLink->getName()));
      $oTemplate->replaceIdentifier("delete_button", $oDeleteTemplate, null, Template::LEAVE_IDENTIFIERS);
    }
    $oTemplate->replaceIdentifier("id", $this->oLink->getId());
    $oTemplate->replaceIdentifier("name", $this->oLink->getName());
    $oTemplate->replaceIdentifier("url", $this->oLink->getUrl());
    $oTemplate->replaceIdentifier("description", $this->oLink->getDescription());
    
    if($this->oLink->getOwnerId() > 0 && $this->oLink->getUserRelatedByOwnerId() !== null) {
      $oTemplate->replaceIdentifier("owner", $this->oLink->getUserRelatedByOwnerId()->getUsername());
    }
    if($this->oLink->getUpdatedAt() != null) {
      $oTemplate->replaceIdentifier("created_at", $this->oLink->getUpdatedAt());
    }
    
    $oTemplate->replaceIdentifier("action", $this->link($this->oLink->getId()));    
    return $oTemplate;
  }
  
  public function create() {
    $this->oLink = new Link();
    $this->oLink->setCreatedBy(Session::getSession()->getUserId());
    $this->oLink->setCreatedAt(date('c'));
  }
  
  public function delete() {
    //Try to avoid an printing exception when references are still used
    try {
      $this->oLink->delete();
      LinkUtil::redirect($this->link());
    } catch (Exception $e) {
      Flash::getFlash()->addMessage('link_delete_has_references');
      Flash::getFlash()->finishReporting();
    }
  }
  
  protected function validateForm($oFlash) {
    $oFlash->checkForValue('name');
    $oFlash->checkForValue('url');
  }

  public function save() {
    if($this->oLink === null) {
      $this->create();
    }
    if(Flash::noErrors()) {
      $this->oLink->setUpdatedBy(Session::getSession()->getUserId());
      $this->oLink->setOwnerId(isset($_REQUEST['owner_id']) && $_REQUEST['owner_id'] != '' ? $_REQUEST['owner_id'] : Session::getSession()->getUserId());
      $this->oLink->setUpdatedAt(date('c'));
      $this->oLink->setName($_POST['name']);
      $this->oLink->setUrl(LinkUtil::getUrlWithProtocolIfNotSet($_POST['url']));
      $this->oLink->setDescription($_POST['description']);
      $this->oLink->save();
      LinkUtil::redirect($this->link($this->oLink->getId()));
    }
  }
  
  public function getNewEntryActionParams() {
    return array('action' => $this->link('new'));
  }
  
  public function hasSearch() {
    return true;
  }
  
  public function getModelName() {
    return "Link";
  }
  
  public function getCurrentId() {
    if(!$this->oLink) {
      return null;
    }
    return $this->oLink->getId();
  }
}
