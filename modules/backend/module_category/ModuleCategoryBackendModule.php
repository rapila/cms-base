<?php
/**
 * @package modules.backend
 * @todo
 * - update strings module.backend.module_categories, general.module_name and 'Params for execution' in all languages
 * - discuss and process params_for_execution
 * - option to make module_names dynamic?
 * - test module
 * - experiment with new id, class, template naming conventions
 * - migration issues: sql, check method and site module message
 */
class ModuleCategoryBackendModule extends BackendModule {
  
  private $oModuleCategory = null;
  private $aModuleName;

  public function __construct() {
    if(Manager::hasNextPathItem()) {
      $this->oModuleCategory=ModuleCategoryPeer::retrieveByPk(Manager::usePath()); 
    }
    $this->aModuleNames = array( 'global', 'document', 'link');
  }
  
  public function getChooser() {
    $oTemplate = $this->constructTemplate('list');
    $aModuleCategories = ModuleCategoryPeer::getDocumentCategories();
    $this->parseTree($oTemplate, $aModuleCategories, $this->oModuleCategory);
    return $oTemplate;
  }
  
  public function getDetail() {
    if($this->oModuleCategory === null) {
      return $this->constructTemplate("module_info");
    }
    $oTemplate = $this->constructTemplate("detail");
    if(!$this->oModuleCategory->isNew()) {
      $oDeleteTemplate = $this->constructTemplate("delete_button", true);
      $oDeleteTemplate->replacePstring("delete_item", array('name' => $this->oModuleCategory->getName()));
      $oTemplate->replaceIdentifier("delete_button", $oDeleteTemplate, null, Template::LEAVE_IDENTIFIERS);
    }
    $oTemplate->replaceIdentifier("id", $this->oModuleCategory->getId());
    $oTemplate->replaceIdentifier("name", $this->oModuleCategory->getName());
    $oTemplate->replaceIdentifier("module_name_options", Util::optionsFromArray(Util::arrayWithValuesAsKeys($this->aModuleNames), $this->oModuleCategory->getModuleName(), null, array()));
    $oTemplate->replaceIdentifier("name_title", $this->oModuleCategory->getName() != '' ? $this->oModuleCategory->getName() : '[Neu]');
    // how to process them? serialize
    $oTemplate->replaceIdentifier("params_for_execution", $this->oModuleCategory->getParamsForExecution());
    $oTemplate->replaceIdentifier("action", $this->link($this->oModuleCategory->getId()));
    
    return $oTemplate;
  }
  
  public function create() {
    $this->oModuleCategory = new ModuleCategory();
    $this->oModuleCategory->setIsInactive(false);
  }
  
  public function delete() {
    $this->oModuleCategory->delete();
    $this->oModuleCategory=null;
    Util::redirect($this->link());
  }
  
  public function save() {
    if($this->oModuleCategory === null) {
      $this->create();
    }
    $this->oModuleCategory->setName($_POST['name']);
    if($_POST['params_for_execution'] === '') {
      $this->oModuleCategory->setParamsForExecution(null);
    } else {
      // how to process
      $this->oModuleCategory->setParamsForExecution($_POST['params_for_execution']);
    }
    $this->oModuleCategory->setModuleName($_POST['module_name']);
    $this->oModuleCategory->save();
    Util::redirect($this->link($this->oModuleCategory->getId()));
  }

  public function getNewEntryActionParams() {
    if(!$this->oModuleCategory || !$this->oModuleCategory->isNew()) {
      return array('action' => $this->link()); 
    }
  }
}
