<?php
/**
 * @package modules.backend
 */
class DocumentCategoriesBackendModule extends BackendModule {
  
  private $oDocCategory = null;
  
  public function __construct() {
    if(Manager::hasNextPathItem()) {
      $this->oDocCategory=DocumentCategoryPeer::retrieveByPk(Manager::usePath()); 
    }
  }
  
  public function getChooser() {
    $oTemplate = $this->constructTemplate('list');
    $aDocumentCategories = DocumentCategoryPeer::getDocumentCategoriesSorted();
    $this->parseTree($oTemplate, $aDocumentCategories, $this->oDocCategory);
    return $oTemplate;
  }
  
  public function getDetail() {
    if($this->oDocCategory === null) {
      $oTemplate = $this->constructTemplate("module_info");
      $oTemplate->replaceIdentifier('create_link', TagWriter::quickTag('a', array('href' => LinkUtil::link('document_categories', null, array('action' => 'create'))), StringPeer::getString('document_categories.create')));
      $oTemplate->replaceIdentifier("display_style", isset($_REQUEST['get_module_info']) ? 'block' : 'none');
      $oTemplate->replaceIdentifier("toggler_style", isset($_REQUEST['get_module_info']) ? ' open' : '');
      return $oTemplate;
    }  
    $oTemplate = $this->constructTemplate("detail");
    $oTemplate->replaceIdentifier('module_info_link', TagWriter::quickTag('a', array('title' => StringPeer::getString('module_info'), 'class' => 'help', 'href' => LinkUtil::link('document_categories', null, array('get_module_info' => 'true')))));

    if(!$this->oDocCategory->isNew()) {
      $oDeleteTemplate = $this->constructTemplate("delete_button", true);
      $oDeleteTemplate->replacePstring("delete_item", array('name' => $this->oDocCategory->getName()));
      $oDeleteTemplate->replaceIdentifier("delete_label", StringPeer::getString('delete'));
      $oTemplate->replaceIdentifier("delete_button", $oDeleteTemplate, null, Template::LEAVE_IDENTIFIERS);
    }
    $oTemplate->replaceIdentifier("id", $this->oDocCategory->getId());
    $oTemplate->replaceIdentifier("name", $this->oDocCategory->getName());
    $oTemplate->replaceIdentifier("name_title", $this->oDocCategory->getName() != '' ? $this->oDocCategory->getName() : null);
    $oTemplate->replaceIdentifier("sort", $this->oDocCategory->getSort());
    $oTemplate->replaceIdentifier("max_width", $this->oDocCategory->getMaxWidth());
    $sIsInactive = $this->oDocCategory->getIsInactive() === true ? 'checked="checked"' :'';
    $oTemplate->replaceIdentifier("is_inactive", $sIsInactive, null, Template::NO_HTML_ESCAPE);
    $oTemplate->replaceIdentifier("action", $this->link($this->oDocCategory->getId()));
    
    return $oTemplate;
  }
  
  public function create() {
    $this->oDocCategory = new DocumentCategory();
    $this->oDocCategory->setIsInactive(false);
  }
  
  public function delete() {
    $this->oDocCategory->delete();
    $this->oDocCategory=null;
    LinkUtil::redirect($this->link());
  }
  
  public function save() {
    if($this->oDocCategory === null) {
      $this->create();
    }
    $this->oDocCategory->setName($_POST['name']);
    // $this->oDocCategory->setSort($_POST['sort']);
    if($_POST['max_width'] === '') {
      $this->oDocCategory->setMaxWidth(null);
    } else {
      $this->oDocCategory->setMaxWidth($_POST['max_width']);
    }
    $this->oDocCategory->setIsInactive(isset($_POST['is_inactive']));
    $this->oDocCategory->save();
    LinkUtil::redirect($this->link($this->oDocCategory->getId()));
  }

  public function getNewEntryActionParams() {
    if(!$this->oDocCategory || !$this->oDocCategory->isNew()) {
      return array('action' => $this->link()); 
    }
  }
}
