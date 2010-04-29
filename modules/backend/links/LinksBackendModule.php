<?php
/**
 * @package modules.backend
 */
class LinksBackendModule extends BackendModule {
  
  private $oLink = null;
  private $sSelectedTagName;
  private $oListHelper;

  const USE_SELECTED_TAG = 'use_selected_tag';
  
  public function __construct() {
    if(Manager::hasNextPathItem()) {
      $this->oLink = LinkPeer::retrieveByPK(Manager::usePath()); 
    }

    $this->oListHelper = new ListHelper($this);
  }
  
  public function getChooser() {
    $oTemplate = $this->constructTemplate('list');
    
    $aTagsUsedInLinkModule = TagPeer::doSelect(TagPeer::getTagsUsedInModelCriteria($this->getModelName()));
    $oTemplate->replaceIdentifierMultiple('filter_selector', $this->oListHelper->getFilterSelectForTagFilter());
    $oTemplate->replaceIdentifierMultiple('filter_selector', $this->oListHelper->getFilterSelect(LinkPeer::URL, LinkPeer::getProtocolsWithLinksAssoc(), StringPeer::getString('links.all_protocols'), null, ListHelper::SELECTION_TYPE_BEGINS));
    
    $oTemplate->replaceIdentifierMultiple("sort_link", $this->oListHelper->getSortColumn(LinkPeer::NAME, 'name', true));
    $oTemplate->replaceIdentifierMultiple("sort_link", $this->oListHelper->getSortColumn(LinkPeer::UPDATED_AT, 'date'));
    
    $oCriteria = new Criteria();
    $this->oListHelper->handle($oCriteria);
    $aLinks = LinkPeer::doSelect($oCriteria);
    if(count($aLinks) === 0) {
      $oTemplate->replaceIdentifier("has_no_entries", StringPeer::getString('has_no_entries'));
    }

    $this->parseTree($oTemplate, $aLinks, $this->oLink);
    return $oTemplate;
  }
  
  public function getDetail() {
    if(!$this->oLink) {
      $oTemplate = $this->constructTemplate("module_info");
      $oTemplate->replaceIdentifier('create_link', TagWriter::quickTag('a', array('class' => 'edit_related_link highlight', 'href' => LinkUtil::link('links', null, array('action' => 'create'))), StringPeer::getString('links.create')));
      $oTemplate->replaceIdentifier("display_style", isset($_REQUEST['get_module_info']) ? 'block' : 'none');
      $oTemplate->replaceIdentifier("toggler_style", isset($_REQUEST['get_module_info']) ? ' open' : '');
      return $oTemplate;
    }
    $oTemplate = $this->constructTemplate("detail");
    $oTemplate->replaceIdentifier('module_info_link', TagWriter::quickTag('a', array('title' => StringPeer::getString('module_info'), 'class' => 'info', 'href' => LinkUtil::link('links', null, array('get_module_info' => 'true')))));
    
    if(!$this->oLink->isNew()) {
      // Reference Handling needs to be checked, maybe used not only in pages, might be other objects too?
      $aReferences = ReferencePeer::getReferences($this->oLink);
      $bHasReferences = count($aReferences) > 0;
      if($bHasReferences) {
        $oTemplate->replaceIdentifier('references', $this->getReferenceMessages($aReferences));
        $oDeleteTemplate = $this->constructTemplate("delete_button_inactive", true);
        $oDeleteTemplate->replaceIdentifier("message_js", StringPeer::getString('document.has_references'));
      } else {
        $oDeleteTemplate = $this->constructTemplate("delete_button", true);
      }
      $oDeleteTemplate->replacePstring("delete_item", array('name' => $this->oLink->getName()));
      $oTemplate->replaceIdentifier("delete_button", $oDeleteTemplate, null, Template::LEAVE_IDENTIFIERS);
    } else {
      $sTagName = $this->oListHelper->getListSettings()->getFilterColumnValue(LinkPeer::ID);
      if($sTagName !== ListHelper::SELECT_ALL && $sTagName !== ListHelper::SELECT_WITHOUT) {
        $oSelectedTag = TagWriter::quickTag('input', array('type' => 'checkbox', 'name' => self::USE_SELECTED_TAG, 'checked' => "checked", 'title' => 'set tag', 'style' => 'margin-right:.2em;'));
        $oTemplate->replaceIdentifier("use_selected_tag_checkbox", $oSelectedTag);
        $oTemplate->replacePstring("link.tag_selected", array('tag_name' => $sTagName));
      }
    }
    $oTemplate->replaceIdentifier("id", $this->oLink->getId());
    $oTemplate->replaceIdentifier("name", $this->oLink->getName());
    $oTemplate->replaceIdentifier("url", $this->oLink->getUrl());
    $oTemplate->replaceIdentifier("description", $this->oLink->getDescription());
    
    if($this->oLink->getUserRelatedByOwnerId() !== null) {
      $oTemplate->replaceIdentifier("updated_by", $this->oLink->getUserRelatedByUpdatedBy()->getUsername());
    }
    if($this->oLink->getUpdatedAt() != null) {
      $oTemplate->replaceIdentifier("updated_at", $this->oLink->getUpdatedAt('Y-m-d h:m:s'));
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
    $this->oLink->setName($_POST['name']);
    $this->oLink->setUrl(LinkUtil::getUrlWithProtocolIfNotSet($_POST['url']));
    $this->oLink->setDescription($_POST['description']);


    if(Flash::noErrors()) {
      $this->oLink->setUpdatedBy(Session::getSession()->getUserId());
      $this->oLink->setOwnerId(isset($_REQUEST['owner_id']) && $_REQUEST['owner_id'] != '' ? $_REQUEST['owner_id'] : Session::getSession()->getUserId());
      $this->oLink->setUpdatedAt(date('c'));
      
      $this->oLink->save();
      
      if(isset($_REQUEST[self::USE_SELECTED_TAG])) {
        TagInstancePeer::newTagInstance($this->oListHelper->getListSettings()->getFilterColumnValue(LinkPeer::ID), 'Link', $this->oLink->getId());
      }
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
