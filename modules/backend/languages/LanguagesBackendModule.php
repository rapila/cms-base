<?php
/**
 * @package modules.backend
 */
class LanguagesBackendModule extends BackendModule {
  
  private $oLanguage = null;
  
  public function __construct() {
    if(Manager::hasNextPathItem()) {
      $this->oLanguage=LanguagePeer::retrieveByPk(Manager::usePath()); 
    }
  }
  
  public function getChooser() {
    $oTemplate = $this->constructTemplate('list');
    $aLanguages = LanguagePeer::getLanguages();
    $this->parseTree($oTemplate, $aLanguages, $this->oLanguage);
    return $oTemplate;
  }
  
  public function getDetail() {
    if($this->oLanguage === null) {
      $oTemplate = $this->constructTemplate("module_info");
      $oTemplate->replaceIdentifier('create_link', TagWriter::quickTag('a', array('href' => LinkUtil::link('languages', null, array('action' => 'create'))), StringPeer::getString('language.create')));
      return $oTemplate;
    }
    
    $oTemplate = $this->constructTemplate("detail");
    $oTemplate->replaceIdentifier("id", $this->oLanguage->getId());
    $sIsActive = $this->oLanguage->getIsActive() === true ? 'checked="checked"' :'';
    $oTemplate->replaceIdentifier("sort", $this->oLanguage->getSort());
    $oTemplate->replaceIdentifier("is_active", $sIsActive, null, Template::NO_HTML_ESCAPE);
    if($this->oLanguage->getId() !== null && Session::getSession()->getUser()->getIsAdmin()) {
      $oDeleteTemplate = $this->constructTemplate("delete_button", true);
      $oDeleteTemplate->replacePstring("delete_item", array('name' => $this->oLanguage->getId()));
      $oTemplate->replaceIdentifier("delete_button", $oDeleteTemplate, null, Template::LEAVE_IDENTIFIERS);
    }
    
    $oTemplate->replaceIdentifier("action", $this->link($this->oLanguage->getId()));    
    return $oTemplate;
  }
  
  public function create() {
    $this->oLanguage = new Language();
    $this->oLanguage->setIsActive(false);
  }
  
  public function delete() {
    if($this->oLanguage  && Session::getSession()->getUser()->getIsAdmin()) {
      $this->oLanguage->delete();
      $this->oLanguage=null;
    }
  }
  
  public function validateForm($oFlash) {
    if(trim($_POST['id']) == '') {
      $oFlash->addMessage('language_id_required');
    }
  }
  
  public function save() {
    if($this->oLanguage === null) {
      $this->create();
    }
    $this->oLanguage->setId($_POST['id']);
    $this->oLanguage->setSort($_POST['sort']);
    $this->oLanguage->setIsActive(isset($_POST['is_active']));
    if(Flash::noErrors()) {
      $this->oLanguage->save();
      LinkUtil::redirect($this->link($this->oLanguage->getId()));
    }
  }
  
  public function getNewEntryActionParams() {
    return array('action' => $this->link());
  }
}
