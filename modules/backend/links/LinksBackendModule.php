<?php
/**
 * @package modules.backend
 */
class LinksBackendModule extends BackendModule {
  
  private $oLink = null;
  private $sSortField;
  private $sSortOrder;
  private $aReferences;
  
  public function __construct() {
    if(Manager::hasNextPathItem()) {
      $this->oLink=LinkPeer::retrieveByPk(Manager::usePath()); 
      if($this->oLink) {
        $this->aReferences = ReferencePeer::getReferences($this->oLink);
      }
    }
    $this->sSortField  = @$_REQUEST['sort_field'] ? $_REQUEST['sort_field'] : 'name';
    $this->sSortOrder  = @$_REQUEST['sort_order'] ? $_REQUEST['sort_order'] : 'asc';
  }
  
  public function getChooser() {
    $oTemplate = $this->constructTemplate();
    $sSearch = isset($_REQUEST['search']) && $_REQUEST['search'] != null ? $_REQUEST['search'] : null;
    
    $aLinks = LinkPeer::getLinksByName($sSearch, $this->sSortField, $this->sSortOrder);
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
      $oTemplate = $this->constructTemplate("message", true);
      $oTemplate->replaceIdentifier("default_message", StringPeer::getString('default_message_link'), null, Template::NO_HTML_ESCAPE);
      return $oTemplate;
    }
    $oTemplate = $this->constructTemplate("link_detail");
    
    if(!$this->oLink->isNew()) {
      // Reference Handling needs to be checked, maybe used not only in pages, might be other objects too?
      $bHasReferences = false;
      if(count($this->aReferences) > 0) {
        $bHasReferences = true;
        foreach($this->aReferences as $oReference) {
          $oLanguageObject = LanguageObjectPeer::getReferencedLanguageObject($oReference->getFromIdObjectId(), $oReference->getFromIdLanguageId());
          $oRefTemplate = $this->constructTemplate('references', true);
          $oRefTemplate->replaceIdentifier('page_name', $oLanguageObject->getContentObject()->getPage()->getName());
          $oRefTemplate->replaceIdentifier('container_name', $oLanguageObject->getContentObject()->getContainerName());
          $oRefTemplate->replaceIdentifier('edit_link', TagWriter::quickTag('a', array('href' => Util::link(array('content', $oLanguageObject->getContentObject()->getPage()->getId(), 'edit', $oLanguageObject->getId()))), 'edit'));
          $oTemplate->replaceIdentifierMultiple('references', $oRefTemplate);
        }
      }
      if($bHasReferences) {
        $oDeleteTemplate = $this->constructTemplate("delete_button_inactive", true);
        $sDeleteItemMessage = "delete_item_inactive";
        $oDeleteTemplate->replaceIdentifier("message_js", StringPeer::getString('document.has_references'));
      } else {
        $oDeleteTemplate = $this->constructTemplate("delete_button", true);
        $sDeleteButtenTemplate = "delete_button";
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
    if(count($this->aReferences) === 0) {
      $this->oLink->delete();
      $this->oLink=null;
      Util::redirect($this->link());
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
    return array('action' => $this->link());
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
