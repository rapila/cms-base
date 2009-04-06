<?php
/**
 * @package modules.backend
 */
class LinksBackendModule extends BackendModule {
  
  private $oLink = null;
  private $sSortField;
  private $sSortOrder;
  private $sSelectedTagName;
  private $sProtocol;
  private $bUntaggedItemsOnly = false; //get tagged items if exist
  
  const SELECTED_TAG_NONE = '__null';
  const SELECTED_TAG_WITHOUT = '__without';
  const SELECTED_PROTOCOL_ALL = '__all';

  public function __construct() {
    if(Manager::hasNextPathItem()) {
      $this->oLink=LinkPeer::retrieveByPk(Manager::usePath()); 
    }
    // selected_tag options: all tags that exist for the modul, plus opions links without tags and all links
    if(isset($_REQUEST['selected_tag_name']) && $_REQUEST['selected_tag_name'] != null) {
      if($_REQUEST['selected_tag_name'] === self::SELECTED_TAG_WITHOUT) {
        $this->bUntaggedItemsOnly = true;
      } else {
        $this->bUntaggedItemsOnly = false;
      }
      $this->sSelectedTagName = $_REQUEST['selected_tag_name'];
      Session::getSession()->setAttribute('selected_tag_name', $this->sSelectedTagName);
      Session::getSession()->setAttribute('only_untagged_items', $this->bUntaggedItemsOnly);
    } else {
      $this->sSelectedTagName = Session::getSession()->getAttribute('selected_tag_name');
      $this->bUntaggedItemsOnly = Session::getSession()->getAttribute('only_untagged_items') !== null ? Session::getSession()->getAttribute('only_untagged_items') : false;
    }
    // find by protocol: http, ftp, mailto etc
    if(isset($_REQUEST['selected_protocol'])) {
      $this->sProtocol = $_REQUEST['selected_protocol'] === self::SELECTED_PROTOCOL_ALL ? null : $_REQUEST['selected_protocol'];
      Session::getSession()->setAttribute('selected_protocol', $this->sProtocol);
    } else {
      $this->sProtocol = Session::getSession()->getAttribute('selected_protocol');
    }
    $this->sSortField  = @$_REQUEST['sort_field'] ? $_REQUEST['sort_field'] : 'name';
    $this->sSortOrder  = @$_REQUEST['sort_order'] ? $_REQUEST['sort_order'] : 'asc';
  }
  
  public function getChooser() {
    $oTemplate = $this->constructTemplate();
    $sSearch = isset($_REQUEST['search']) && $_REQUEST['search'] != null ? $_REQUEST['search'] : null;
    $aTagsUsedInLinkModule = TagPeer::getTagsUsedInModel($this->getModelName());
    $oTemplate->replaceIdentifier("selected_tag_names_options", TagWriter::optionsFromObjects($aTagsUsedInLinkModule, 'getName', 'getName',$this->sSelectedTagName, array(self::SELECTED_TAG_NONE => StringPeer::getString('all_entries'), self::SELECTED_TAG_WITHOUT => StringPeer::getString('link.without_tags'))));

    $oTemplate->replaceIdentifier("selected_protocol_options", TagWriter::optionsFromArray(LinkPeer::getProtocolsWithLinksAssoc(),  @$_REQUEST['selected_protocol'], null, array(self::SELECTED_PROTOCOL_ALL => StringPeer::getString('links.all_protocols'))));
    
    // fix SELECTED_TAG_WITHOUT for criteria
    if($this->sSelectedTagName === self::SELECTED_TAG_WITHOUT || $this->sSelectedTagName === self::SELECTED_TAG_NONE) {
      $this->sSelectedTagName = null;
    }
    $aLinks = LinkPeer::getLinksByTagNameBackend($sSearch, $this->sProtocol, $this->sSelectedTagName, $this->sSortField, $this->sSortOrder,  !$this->bUntaggedItemsOnly);
    
    $sSortOrderName = $this->sSortField == 'name' ? $this->sSortOrder == 'asc' ? 'desc' : 'asc' : 'asc';
    $sSortOrderUpdatedBy = $this->sSortField == 'updated_at' ? $this->sSortOrder == 'asc' ? 'desc' : 'asc' : 'asc';
    $oTemplate->replaceIdentifier("link_name", Util::linkToSelf(null, array('sort_field' => 'name', 'sort_order' => $sSortOrderName)));
    $oTemplate->replaceIdentifier("link_date", Util::linkToSelf(null, array('sort_field' => 'updated_at', 'sort_order' => $sSortOrderUpdatedBy)));
    $oTemplate->replaceIdentifier("link_name_class", $this->sSortField == 'name' ? 'sort_'.$this->sSortOrder : 'sort_blind');
    $oTemplate->replaceIdentifier("link_date_class", $this->sSortField == 'updated_at' ? 'sort_'.$this->sSortOrder : 'sort_blind');
    $oTemplate->replaceIdentifier("change_category_action", $this->link());

    $this->parseTree($oTemplate, $aLinks, $this->oLink);
    return $oTemplate;
  }
  
  public function getDetail() {
    if(!$this->oLink) {
      $oTemplate = $this->constructTemplate("module_info");
      $oTemplate->replaceIdentifier('create_link', TagWriter::quickTag('a', array('href' => Util::link('links', null, array('action' => 'create'))), StringPeer::getString('links.create')));
      return $oTemplate;
    }
    $oTemplate = $this->constructTemplate("link_detail");
    $oTemplate->replaceIdentifier('module_info_link', TagWriter::quickTag('a', array('title' => StringPeer::getString('module_info'), 'class' => 'help', 'href' => Util::link('links'))));
    
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
      Util::redirect($this->link());
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
      $this->oLink->setUrl(Util::getUrlWithProtocolIfNotSet($_POST['url']));
      $this->oLink->setDescription($_POST['description']);
      $this->oLink->save();
      Util::redirect($this->link($this->oLink->getId()));
    }
  }
  
  public function getNewEntryActionParams() {
    return array('action' => $this->link('new', array('selected_tag_name' => $this->sSelectedTagName)));
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
