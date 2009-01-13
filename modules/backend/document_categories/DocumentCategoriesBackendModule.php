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
    $oTemplate = $this->constructTemplate();
    $aDocumentCategories = DocumentCategoryPeer::getDocumentCategoriesSorted();
    $this->parseTree($oTemplate, $aDocumentCategories, $this->oDocCategory);
    return $oTemplate;
  }
  
  public function getDetail() {
    if($this->oDocCategory === null) {
      return;
    }
    
    $oTemplate = $this->constructTemplate("document_category_detail");

    if(!$this->oDocCategory->isNew()) {
      $oDeleteTemplate = $this->constructTemplate("delete_button", true);
      $oDeleteTemplate->replacePstring("delete_item", array('name' => $this->oDocCategory->getName()));
      $oTemplate->replaceIdentifier("delete_button", $oDeleteTemplate, null, Template::LEAVE_IDENTIFIERS);
    }
    $oTemplate->replaceIdentifier("id", $this->oDocCategory->getId());
    $oTemplate->replaceIdentifier("name", $this->oDocCategory->getName());
    $oTemplate->replaceIdentifier("name_title", $this->oDocCategory->getName() != '' ? $this->oDocCategory->getName() : '[Neu]');
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
    Util::redirect($this->link());
  }
  
  public function save() {
    if($this->oDocCategory === null) {
      $this->create();
    }
    $this->oDocCategory->setName($_POST['name']);
    // $this->oDocCategory->setSort($_POST['sort']);
    $this->oDocCategory->setMaxWidth($_POST['max_width']);
    $this->oDocCategory->setIsInactive(isset($_POST['is_inactive']));
    $this->oDocCategory->save();
    Util::redirect($this->link($this->oDocCategory->getId()));
  }

  public function getNewEntryActionParams() {
    if(!$this->oDocCategory || !$this->oDocCategory->isNew()) {
      return array('action' => $this->link()); 
    }
  }
}
