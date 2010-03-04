<?php
/**
 * @package modules.backend
 */
class StringsBackendModule extends BackendModule {
  
  private $oString = null;
  private $sNameSpace = null;
  private $sPath;
  
  public function __construct() { 
    if(Manager::hasNextPathItem()) {
      $this->sPath = Manager::usePath();
      $this->oString=StringPeer::retrieveByPK(BackendManager::getContentEditLanguage(), $this->sPath);
    }
    $this->sNameSpace = ListUtil::handleBackendChooserListSelection('namespace', false);
  }
  
  public function getChooser() {
    $aNamespaces = StringPeer::getNamespaces();
    $sSearch = isset($_REQUEST['search']) ? trim($_REQUEST['search']) : null;
    $aStrings = StringPeer::getStringsByLanguageId(BackendManager::getContentEditLanguage(), $sSearch, $this->sNameSpace);

    $oTemplate = $this->constructTemplate("list");
    $oTemplate->replaceIdentifier("change_select_action", $this->link());
    
    $aNamespaceOptions = null;
    if (count($aNamespaces) > 0) {
      $aNamespaceOptions =  TagWriter::optionsFromArray($aNamespaces, $this->sNameSpace, null, array(ListHelper::SELECT_ALL => StringPeer::getString('all_entries'), '0' => StringPeer::getString('strings.without_namespace')));
    } 
    $oTemplate->replaceIdentifier("namespace_options", $aNamespaceOptions);
    $oStringTemplatePrototype = $this->constructTemplate("list_item");
    
    foreach($aStrings as $oString) {
      $oStringTemplate = clone $oStringTemplatePrototype;
      $oStringTemplate->replaceIdentifier("link", $this->link($oString->getStringKey()));
      $oStringTemplate->replaceIdentifier("string_key", $oString->getStringKey());
      if($this->oString && ($this->oString->getStringKey() == $oString->getStringKey())) {
        $oStringTemplate->replaceIdentifier('class_active', ' active');
      }
      $oTemplate->replaceIdentifierMultiple("result", $oStringTemplate);
    }
    return $oTemplate;
  }
  
  public function getDetail() {
    if($this->oString === null) {
      $oTemplate = $this->constructTemplate("module_info");
      $oTemplate->replaceIdentifier('create_link', TagWriter::quickTag('a', array('href' => LinkUtil::link('strings', null, array('action' => 'create'))), StringPeer::getString('strings.create')));
      return $oTemplate;
    }
    $oTemplate = $this->constructTemplate("detail");
    if(Manager::isPost()) {
      $this->oString->setStringKey($_REQUEST['id']);
      $this->oString->setText($_REQUEST['text']);
    }
    
    if($this->oString->getStringKey() !== null) {
      $oDeleteTemplate = $this->constructTemplate("delete_button", true);
      $oDeleteTemplate->replacePstring("delete_item", array('name' => $this->oString->getStringKey()));
      $oDeleteTemplate->replaceIdentifier("delete_icon", 'delete');
      $oTemplate->replaceIdentifier("delete_button", $oDeleteTemplate, null, Template::LEAVE_IDENTIFIERS);
    }
    if(LanguagePeer::hasLanguageOptions()) {
      $oTemplate->replaceIdentifier("language_change_info", 'language_options');
    }
    
    $oTemplate->replaceIdentifier("id", $this->oString->getStringKey());
    $oTemplate->replaceIdentifier("action", $this->link($this->oString->getStringKey()));
    $oTemplate->replaceIdentifier("text", $this->oString->getOriginalText());
    $oTemplate->replaceIdentifier("language", $this->oString->getLanguageId());
    return $oTemplate;
  }
  
  public function create() {
    $this->oString = new String();
    $this->oString->setLanguageId(BackendManager::getContentEditLanguage());
  }
  
  public function delete() {
    if($this->oString !== null) {
      $this->oString->delete();
      $this->oString=null;
    }
    LinkUtil::redirect($this->link());
  }
  
  public function validateForm($oFlash) {
    $oFlash->checkForValue('text', 'string.text_required');
    if(trim($_POST['id']) == '') {
      $oFlash->addMessage('string.key_required');
    }
    if($this->oString === null || $this->oString->isNew() || $_POST['id'] !== $this->sPath) {
      if(StringPeer::retrieveByPK(BackendManager::getContentEditLanguage(), $_POST['id'])) {
        $oFlash->addMessage('string.key_exists');
      }
    }
  }
  
  public function save() {
    $sOldName = $this->oString === null ? null : $this->oString->getStringKey();
    $bHasNewId = $sOldName !== null && $sOldName !== $_POST['id'];
    if($bHasNewId && Flash::noErrors()) {
      $this->oString->delete();
      $this->create();
    }
    $bHasNewId = $sOldName !== $_POST['id'];
    if($this->oString === null) {
      $this->create();
    }
    if(Flash::noErrors()) {
      $this->oString->setStringKey($_POST['id']);
      $this->oString->setText($_POST['text']);
      $this->oString->save();
      LinkUtil::redirect($this->link($this->oString->getStringKey()));
    }
  }
  
  public function hasSearch() {
    return true;
  }
  
  public function getNewEntryActionParams() {
    return array('action' => $this->link());
  }
}
