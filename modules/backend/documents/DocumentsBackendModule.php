<?php
/**
 * @package modules.backend
 */

define('DOCUMENT_DEFAULT_KIND', 'application');

class DocumentsBackendModule extends BackendModule {

  private $oDocument = null;
  private $oDocumentCategories;
  private $bHasUploadedFile = false;
  private $aReferences = array();
  
  private $oListHelper;

  public function __construct() {
    if(Manager::hasNextPathItem()) {
      $iId = Manager::peekNextPathItem();
      $this->oDocument = DocumentPeer::retrieveByPK($iId);
      if($this->oDocument) {
        $this->aReferences = ReferencePeer::getReferences($this->oDocument);
      }
    }
    $this->oDocumentCategories = DocumentCategoryPeer::getDocumentCategoriesBackend();
    // if there are no document types, then load default entries from 'document_types.insert.yml'
    if(!DocumentTypePeer::hasDocTypesPreset()) {
      InstallUtil::loadToDbFromYamlFile('document_types');
    }
    $this->oListHelper = new ListHelper($this);
  }

  public function getChooser() {
    $oTemplate = $this->constructTemplate("list");
    if(isset($_REQUEST['selected_document_category_id'])) {
      $this->oListHelper->getListSettings()->setFilterColumnValue(DocumentPeer::DOCUMENT_CATEGORY_ID, (int) $_REQUEST['selected_document_category_id']);
    }
    // document categories select is only displayed when there are categories available
    $oTemplate->replaceIdentifierMultiple('filter_selector', $this->oListHelper->getFilterSelect(DocumentPeer::DOCUMENT_CATEGORY_ID, $this->oDocumentCategories, StringPeer::getString('documents.all_categories'), StringPeer::getString('document.without_category')));
    
    $oTemplate->replaceIdentifierMultiple('filter_selector', $this->oListHelper->getFilterSelect(DocumentTypePeer::MIMETYPE, DocumentTypePeer::getAllDocumentKindsWhereDocumentsExist(), StringPeer::getString('document.all_kinds'), null, ListHelper::SELECTION_TYPE_BEGINS));
    
    $oTemplate->replaceIdentifierMultiple("sort_link", $this->oListHelper->getSortColumn(DocumentPeer::NAME, 'name', true));
    $oTemplate->replaceIdentifierMultiple("sort_link", $this->oListHelper->getSortColumn(DocumentPeer::UPDATED_AT, 'date'));
    
    $oCriteria = DocumentPeer::getDocumentsCriteria(true);
    $this->oListHelper->handle($oCriteria);
    $aDocuments = DocumentPeer::doSelect($oCriteria);

    if(count($aDocuments) === 0) {
      $oTemplate->replaceIdentifier("has_no_entries", StringPeer::getString('has_no_entries'));
    }
    
    $oLinkTemplatePrototype = $this->constructTemplate("list_item");
    foreach($aDocuments as $oDocument) {
      $oLinkTemplate = clone $oLinkTemplatePrototype;
      $oLinkTemplate->replaceIdentifier("link", $this->link($oDocument->getId()));
      $oLinkTemplate->replaceIdentifier("name", StringUtil::truncate($oDocument->getName(), 29));
      $oLinkTemplate->replaceIdentifier("doc_type", ' ['.$oDocument->getExtension().']');
      if($this->oDocument && ($this->oDocument->getId() == $oDocument->getId())) {
        $oLinkTemplate->replaceIdentifier('class_active', ' active');
      }
      $oLinkTemplate->replaceIdentifier('title', $oDocument->getName() .'  ['.$oDocument->getExtension().'/'.DocumentUtil::getDocumentSize($oDocument->getDataSize()).']');
      $oTemplate->replaceIdentifierMultiple("result", $oLinkTemplate, null);
    }
    
    return $oTemplate;
  }

  public function getDetail() {
    if ($this->oDocument === null) {
      $oTemplate = $this->constructTemplate("module_info");
      $aCreateParams = array('action' => 'create');
      if(isset($_REQUEST['selected_document_category_id'])) {
        $aCreateParams = array_merge($aCreateParams, array('selected_document_category_id' => $_REQUEST['selected_document_category_id']));
      }
      $oTemplate->replaceIdentifier('create_link', TagWriter::quickTag('a', array('class' => 'edit_related_link highlight', 'href' => LinkUtil::link('documents/new', null, $aCreateParams)), StringPeer::getString('documents.create')));
      $oTemplate->replaceIdentifier("default_message", StringPeer::getString('document.choose_or_create'), null, Template::NO_HTML_ESCAPE);
      $aDocumentTypesList = array();
      foreach(DocumentTypePeer::getDocumentTypesByCategory() as $oDocumentType) {
        $aDocumentTypesList[] = array('extension' => $oDocumentType->getExtension(), 'mimetype' => $oDocumentType->getMimetype(), 'office_use' => ($oDocumentType->getIsOfficeDoc() ? '✔' : '✗'));
      }
      $oTemplate->replaceIdentifier("document_types", TagWriter::tableFromArray($aDocumentTypesList));
      $oTemplate->replaceIdentifier("display_style", isset($_REQUEST['get_module_info']) ? 'block' : 'none');
      $oTemplate->replaceIdentifier("toggler_style", isset($_REQUEST['get_module_info']) ? ' open' : '');
      $bMayEditModule = true;
      if($bMayEditModule) {
        $oTemplate->replaceIdentifier("document_types_link", TagWriter::quickTag('a', array('href' => LinkUtil::link(array('document_types')), 'class' => 'edit_related_link'), StringPeer::getString('module.backend.document_types')));
      }
      return $oTemplate;
    }
    
    $oTemplate = $this->constructTemplate("detail");
    $oTemplate->replaceIdentifier('module_info_link', TagWriter::quickTag('a', array('title' => StringPeer::getString('module_info'), 'class' => 'info', 'href' => LinkUtil::link('documents', null, array('get_module_info' => 'true')))));
    $sActionLink = $this->link($this->oDocument->getId());
    $oTemplate->replaceIdentifier("action", $sActionLink);
    $oTemplate->replaceIdentifier("id", $this->oDocument->getId());
    $oTemplate->replaceIdentifier("name", $this->oDocument->getName() != '' ? $this->oDocument->getName() : null);
    $oTemplate->replaceIdentifier("file_name", $this->oDocument->getName());
    $oTemplate->replaceIdentifier("description", $this->oDocument->getDescription());
    
    $bHasValidUser = false;
    if($this->oDocument->getOwnerId() > 0 && $this->oDocument->getUserRelatedByOwnerId() !== null) {
      $oTemplate->replaceIdentifier("owner", $this->oDocument->getUserRelatedByOwnerId()->getUsername());
      $bHasValidUser = true;
    }
    
    $oTemplate->replaceIdentifier("date_updated", $this->oDocument->getUpdatedAt('Y-m-d h:m:s'));
    $oTemplate->replaceIdentifier("is_protected", $this->oDocument->getIsProtected());
    $oTemplate->replaceIdentifier("is_protected_checked", ($this->oDocument->getIsProtected() ? ' checked="checked"' : ''), null, Template::NO_HTML_ESCAPE);

    if(Settings::getSetting('general', 'multilingual', false)) {
      $oTemplate->replaceIdentifier("available_language_options", TagWriter::optionsFromArray(LanguagePeer::getLanguagesAssoc(), $this->oDocument->getLanguageId(), '', array("" => StringPeer::getString("international"))));
    }

    if(DocumentCategoryPeer::hasDocumentCategories()) {
      $iDocumentCategoryId = $this->oDocument->isNew() ? (int) $this->oListHelper->getListSettings()->getFilterColumnValue(DocumentPeer::DOCUMENT_CATEGORY_ID) : $this->oDocument->getDocumentCategoryId();
      $oTemplate->replaceIdentifier("doc_category_options", TagWriter::optionsFromObjects($this->oDocumentCategories, 'getId', 'getName', $iDocumentCategoryId));
    }
    $oTemplate->replaceIdentifier("edit_document_category_link", TagWriter::quickTag('a', array('href' => LinkUtil::link('document_categories', null, array('selected_document_cateogory_id' => $this->oDocument->getDocumentCategoryId())), 'class' => 'edit_related_link highlight'), StringPeer::getString('document_categories.edit')));
    
    if(!$this->oDocument->isNew()) {
      $oTemplate->replaceIdentifier("document_type", $this->oDocument->getDocumentType()->getMimetype());
      $oTemplate->replaceIdentifier("document_type_info", '['.$this->oDocument->getDocumentType()->getExtension().' | '.$this->oDocument->getDocumentType()->getMimetype().']');
      if($this->oDocument->isImage()) {
        $oImageTemplate = new Template('<p><img src="{{link}}"/></p>', null, true);
        $oImageTemplate->replaceIdentifier('link', LinkUtil::link(array("display_document", $this->oDocument->getId()), "FileManager", array("max_width" => 500, 'timestamp' => time())));
        $oTemplate->replaceIdentifier("image", $oImageTemplate);
      }
      $sDocLink = $this->oDocument->getName() != '' ? '<a href="'.LinkUtil::link(array('display_document', $this->oDocument->getId()), 'FileManager').'" title="anschauen" target="_blank">view</a>' : '';
      $oTemplate->replaceIdentifier("document_link", $sDocLink, null, Template::NO_HTML_ESCAPE);

      // Reference Handling needs to be checked, maybe used not only in pages, might be other objects too?
      $bHasReferences = count($this->aReferences) > 0;
      if($bHasReferences) {
        $oTemplate->replaceIdentifier('references', $this->getReferenceMessages($this->aReferences));
      }
      
      //delete button
      $sDeleteAlertMessage = StringPeer::getString("delete_confirm");
      if($this->mayNotDelete() || $bHasReferences) {
        $oDeleteTemplate = $this->constructTemplate("delete_button_inactive", true);
        $sDeleteItemMessage = "delete_item_inactive";
      } else {
        $oDeleteTemplate = $this->constructTemplate("delete_button", true);
        $sDeleteItemMessage = "delete_item";
      }
      $oDeleteTemplate->replaceIdentifier("action", $sActionLink);
      $oDeleteTemplate->replaceIdentifier("delete_label", StringPeer::getString('delete'));
      $oDeleteTemplate->replaceIdentifier("message_js", StringPeer::getString($this->mayNotDelete() ? 'user.no_permission_for_action' : 'document.has_references'));
      $oDeleteTemplate->replacePstring($sDeleteItemMessage, array('name' => $this->oDocument->getName()));
      $oTemplate->replaceIdentifier("delete_button", $oDeleteTemplate, null, Template::LEAVE_IDENTIFIERS);
    }
    return $oTemplate;
  }
  
  public function validateForm($oFlash) {
    $this->bHasUploadedFile = $oFlash->checkForFileUpload('document_upload', 'DocumentType', $this->oDocument !== null);
  }

  public function create() {
    $this->oDocument = new Document();
    $this->oDocument->setData(new Blob());
    $this->oDocument->setCreatedBy(Session::getSession()->getUserId());
    $this->oDocument->setCreatedAt(date('c'));
  }

  public function save() {
    if($this->oDocument === null) {
      $this->create();
    }
    
    $this->oDocument->setUpdatedBy(Session::getSession()->getUserId());
    if(@$_POST['language_id'] == "") {
      $_POST['language_id'] = null;
    }

    $this->oDocument->setLanguageId($_POST['language_id']);
    $this->oDocument->setDocumentCategoryId(@$_POST['document_category_id']); //Optional: hidden if no categories are defined
    $this->oDocument->setDescription($_POST['description']);
    $this->oDocument->setName($_POST['name']);
    $this->oDocument->setIsProtected(isset($_POST['is_protected']));

    //If has content type (a file was uploaded and validated)
    if($this->bHasUploadedFile === true) {
      $aName = explode(".", $_FILES["document_upload"]['name']);
      if(count($aName) > 1) {
        array_pop($aName);
      }

      $this->oDocument->getData()->readFromFile($_FILES["document_upload"]['tmp_name']);
      $this->oDocument->setName($this->oDocument->getName() != '' ? $this->oDocument->getName() : implode(".", $aName));
      $this->oDocument->setData($this->oDocument->getData());
      $this->oDocument->setDocumentType(DocumentTypePeer::getDocumentTypeForUpload("document_upload"));
    }

    if(Flash::noErrors()) {
      if($this->reduceSizeIfRequired()) {
        $iMaxWidth = $this->oDocument->getDocumentCategory()->getMaxWidth();
        $oImage = Image::imageFromData($this->oDocument->getData()->getContents());
        if($oImage->getOriginalWidth() > $this->oDocument->getDocumentCategory()->getMaxWidth()) {
          $oImage->setSize((int)$this->oDocument->getDocumentCategory()->getMaxWidth(), 200, Image::RESIZE_TO_WIDTH);
          ob_start();
          $oImage->render();
          $this->oDocument->getData()->setContents(ob_get_contents());
          ob_end_clean();
          $this->oDocument->setData($this->oDocument->getData());
        }
      }
      $this->oDocument->save();
      LinkUtil::redirect($this->link($this->oDocument->getId()));
    }
  }

  private function reduceSizeIfRequired() {
    return $this->oDocument->isImage()
        && $this->oDocument->getDocumentCategoryId() != null
        && $this->oDocument->getDocumentCategory()->getMaxWidth() != null;
  }

  private function mayNotDelete() {
    return !Session::getSession()->getUser()->getIsAdmin()
            && Settings::getSetting('backend', 'document_delete_allow_from_creator_only', false)
            && Session::getSession()->getUserId() !== $this->oDocument->getOwnerId()
            && UserPeer::userExists($this->oDocument->getOwnerId());
  }

  public function delete() {
    if($this->oDocument !== null && !$this->mayNotDelete() && count($this->aReferences) === 0) {
      $this->oDocument->delete();
    }
    LinkUtil::redirectToManager("documents");
  }

  public function getModelName() {
    return "Document";
  }

  public function getCurrentId() {
    if(!$this->oDocument) {
      return null;
    }
    return $this->oDocument->getId();
  }

  public function getNewEntryActionParams() {
    return array('action' => $this->link('new'));
  }

  public function hasSearch() {
    return true;
  }
}
