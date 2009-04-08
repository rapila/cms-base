<?php
/**
 * @package modules.backend
 */
class DocumentTypesBackendModule extends BackendModule {
  
  private $oDocumentType = null;
  
  public function __construct() {
    if(Manager::hasNextPathItem()) {
      $this->oDocumentType=DocumentTypePeer::retrieveByPk(Manager::usePath());
    }
  }
  
  public function getChooser() {
    $oTemplate = $this->constructTemplate();
    $aStrings = DocumentTypePeer::doSelect(new Criteria());
    $this->parseTree($oTemplate, $aStrings, $this->oDocumentType);
    return $oTemplate;
  }
  
	public function getDetail() {
	  if($this->oDocumentType === null) {
	    return;
	  }
    $oTemplate = $this->constructTemplate("detail");
	  
	  if($this->oDocumentType->getId() !== null) {
      $oDeleteTemplate = $this->constructTemplate("delete_button", true);
	    $oDeleteTemplate->replacePstring("delete_item", array('name' => $this->oDocumentType->getExtension()));
      $oTemplate->replaceIdentifier("delete_button", $oDeleteTemplate, null, Template::LEAVE_IDENTIFIERS);
	  }
	  
    $oTemplate->replaceIdentifier("id", $this->oDocumentType->getId());
    $oTemplate->replaceIdentifier("action", $this->link($this->oDocumentType->getId()));
    $oTemplate->replaceIdentifier("extension", $this->oDocumentType->getExtension());
    $oTemplate->replaceIdentifier("mimetype", $this->oDocumentType->getMimetype());
    $sIsOfficeDoc = $this->oDocumentType->getIsOfficeDoc() === true ? 'checked="checked" ' :'';
    $oTemplate->replaceIdentifier("is_office_doc", $sIsOfficeDoc, null, Template::NO_HTML_ESCAPE);
    return $oTemplate;
	}
  
  public function create() {
    $this->oDocumentType = new DocumentType();
	  $this->oDocumentType->setIsOfficeDoc(false);
  }
  
  public function delete() {
	  if($this->oDocumentType !== null) {
	    $this->oDocumentType->delete();
	    $this->oDocumentType=null;
	  }
  }
  
  public function save() {
	  if($this->oDocumentType === null) {
	    $this->create();
	  }
	  $this->oDocumentType->setExtension($_POST['extension']);
	  $this->oDocumentType->setMimetype($_POST['mimetype']);
	  $this->oDocumentType->setIsOfficeDoc(isset($_POST['is_office_doc']));
	  $this->oDocumentType->save();
  }
  
  public function getNewEntryActionParams() {
    return array('action' => $this->link());
  }
  
}
