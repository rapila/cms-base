<?php
/**
 * @package modules.backend
 */
class DocumentTypesBackendModule extends BackendModule {
  
  private $oDocumentType = null;
  private $oListHelper;
  
  public function __construct() {
    if(Manager::hasNextPathItem()) {
      $this->oDocumentType=DocumentTypePeer::retrieveByPK(Manager::usePath());
    }
    $this->oListHelper = new ListHelper($this);
  }
  
  public function getChooser() {
    $oTemplate = $this->constructTemplate('list');
    $oTemplate->replaceIdentifierMultiple('filter_selector', $this->oListHelper->getFilterSelect(DocumentTypePeer::MIMETYPE, DocumentTypePeer::getMimeTypesAssoc(), StringPeer::getString('document_types.all'), null, ListHelper::SELECTION_TYPE_BEGINS));
    $oCriteria = new Criteria();
    $oCriteria->addAscendingOrderByColumn(DocumentTypePeer::MIMETYPE);
    $this->oListHelper->handle($oCriteria);
    $aDocumentTypes = DocumentTypePeer::doSelect($oCriteria);

    foreach($aDocumentTypes as $oDocumentType) {
      $oDocTypeTemplate = $this->constructTemplate('list_item');
      if($this->oDocumentType && $oDocumentType->getId() === $this->oDocumentType->getId()) {
        $oDocTypeTemplate->replaceIdentifier('class_active', ' active');
      }
      $oDocTypeTemplate->replaceIdentifier('count', $oDocumentType->countDocuments() === 0 ? '-' : $oDocumentType->countDocuments());
      $oDocTypeTemplate->replaceIdentifier('link', $this->link($oDocumentType->getId()));
      $oDocTypeTemplate->replaceIdentifier('document_kind', $oDocumentType->getDocumentKind());
      $oDocTypeTemplate->replaceIdentifier('extension', $oDocumentType->getExtension());
      $oTemplate->replaceIdentifierMultiple('tree', $oDocTypeTemplate);
    }
    return $oTemplate;
  }
  
	public function getDetail() {
	  if($this->oDocumentType === null) {
      $oTemplate = $this->constructTemplate("module_info");
      $oTemplate->replaceIdentifier('create_link', TagWriter::quickTag('a', array('class' => 'edit_related_link highlight', 'href' => LinkUtil::link('document_types', null, array('action' => 'create'))), StringPeer::getString('document_types.create')));
      return $oTemplate;
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
