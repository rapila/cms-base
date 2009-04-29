<?php
/**
 * @package modules.backend
 */
class DocumentCategoriesBackendModule extends BackendModule {
  
  private $oDocumentCategory = null;
  
  public function __construct() {
    if(Manager::hasNextPathItem()) {
      $this->oDocumentCategory=DocumentCategoryPeer::retrieveByPk(Manager::usePath()); 
    }
  }
  
  public function getChooser() {
    $oTemplate = $this->constructTemplate('list');
    $aDocumentCategories = DocumentCategoryPeer::getDocumentCategoriesSorted(false, Session::getSession()->getUser()->getIsAdmin() ? null : false);
    foreach($aDocumentCategories as $oDocumentCategory) {
      $oItemTemplate = $this->constructTemplate('list_item');
      $sExternallyManaged = '';      
      if($oDocumentCategory->getIsExternallyManaged()) {
        $sExternallyManaged = ' [EM]';
      }
      $oItemTemplate->replaceIdentifier('title', $oDocumentCategory->getName().$sExternallyManaged);
      $oItemTemplate->replaceIdentifier('link', LinkUtil::link('document_categories/'.$oDocumentCategory->getId()));
      if($this->oDocumentCategory && ($this->oDocumentCategory->getId() == $oDocumentCategory->getId())) {
        $oItemTemplate->replaceIdentifier('class_active', ' active');
      }      
      if($oDocumentCategory->getIsInactive()) {
        $oItemTemplate->replaceIdentifier('edit_inactive', ' edit_inactive');
      }
      $oTemplate->replaceIdentifierMultiple('tree', $oItemTemplate);
    }
    return $oTemplate;
  }
  
  public function getDetail() {
    if($this->oDocumentCategory === null) {
      $oTemplate = $this->constructTemplate("module_info");
      $oTemplate->replaceIdentifier('create_link', TagWriter::quickTag('a', array('href' => LinkUtil::link('document_categories', null, array('action' => 'create'))), StringPeer::getString('document_categories.create')));
      $oTemplate->replaceIdentifier("display_style", isset($_REQUEST['get_module_info']) ? 'block' : 'none');
      $oTemplate->replaceIdentifier("toggler_style", isset($_REQUEST['get_module_info']) ? ' open' : '');
      return $oTemplate;
    }  
    $oTemplate = $this->constructTemplate("detail");
    $oTemplate->replaceIdentifier('module_info_link', TagWriter::quickTag('a', array('title' => StringPeer::getString('module_info'), 'class' => 'help', 'href' => LinkUtil::link('document_categories', null, array('get_module_info' => 'true')))));

    if(!$this->oDocumentCategory->isNew()) {
      $oDeleteTemplate = $this->constructTemplate("delete_button", true);
      $oDeleteTemplate->replacePstring("delete_item", array('name' => $this->oDocumentCategory->getName()));
      $oDeleteTemplate->replaceIdentifier("delete_label", StringPeer::getString('delete'));
      $oTemplate->replaceIdentifier("delete_button", $oDeleteTemplate, null, Template::LEAVE_IDENTIFIERS);
    }
    $oTemplate->replaceIdentifier("id", $this->oDocumentCategory->getId());
    $oTemplate->replaceIdentifier("name", $this->oDocumentCategory->getName());
    $oTemplate->replaceIdentifier("name_title", $this->oDocumentCategory->getName() != '' ? $this->oDocumentCategory->getName() : null);
    $oTemplate->replaceIdentifier("sort", $this->oDocumentCategory->getSort());
    $oTemplate->replaceIdentifier("max_width", $this->oDocumentCategory->getMaxWidth());
    $sChecked = ' checked="checked"';
    $sIsInactive = $this->oDocumentCategory->getIsInactive() === true ? $sChecked : '';
    $oTemplate->replaceIdentifier("is_inactive", $sIsInactive, null, Template::NO_HTML_ESCAPE);
    if(Session::getSession()->getUser()->getIsAdmin()) {
      $oTemplate->replaceIdentifier("is_externally_managed_checked", $this->oDocumentCategory->getIsExternallyManaged() ? $sChecked : '', null, Template::NO_HTML_ESCAPE);
    }
    $oTemplate->replaceIdentifier("action", $this->link($this->oDocumentCategory->getId()));
    
    return $oTemplate;
  }
  
  public function create() {
    $this->oDocumentCategory = new DocumentCategory();
    $this->oDocumentCategory->setIsInactive(false);
  }
  
  public function delete() {
    $this->oDocumentCategory->delete();
    $this->oDocumentCategory=null;
    LinkUtil::redirect($this->link());
  }
  
  public function save() {
    if($this->oDocumentCategory === null) {
      $this->create();
    }
    $this->oDocumentCategory->setName($_POST['name']);
    // $this->oDocumentCategory->setSort($_POST['sort']);
    if($_POST['max_width'] === '') {
      $this->oDocumentCategory->setMaxWidth(null);
    } else {
      $this->oDocumentCategory->setMaxWidth($_POST['max_width']);
    }
    if(Session::getSession()->getUser()->getIsAdmin()) {
      $this->oDocumentCategory->setIsExternallyManaged(isset($_POST['is_externally_managed']));
    }

    $this->oDocumentCategory->setIsInactive(isset($_POST['is_inactive']));
    $this->oDocumentCategory->save();
    LinkUtil::redirect($this->link($this->oDocumentCategory->getId()));
  }

  public function getNewEntryActionParams() {
    if(!$this->oDocumentCategory || !$this->oDocumentCategory->isNew()) {
      return array('action' => $this->link()); 
    }
  }
}
