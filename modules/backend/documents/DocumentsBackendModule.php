<?php
/**
 * @package modules.backend
 */

define('DOCUMENT_DEFAULT_KIND', 'application');

class DocumentsBackendModule extends BackendModule {

  private $oDocument = null;
  private $sDocumentKind;
  private $bHasUploadedFile = false;
  private $sDocumentCategory;
  private $sSortField;
  private $sSortOrder;
  private $aReferences = array();

  public function __construct() {
    
    // selected_document_kind = text, application, image etc
    if(isset($_REQUEST['selected_document_kind'])) {
      $this->sDocumentKind = $_REQUEST['selected_document_kind'] !== DocumentPeer::ALL_KINDS ? $_REQUEST['selected_document_kind'] : null;
      Session::getSession()->setAttribute('selected_document_kind', $this->sDocumentKind);
    } else {
      $this->sDocumentKind = Session::getSession()->getAttribute('selected_document_kind');
    }
    
    // selected_document_category_id can be specific int, all, without category
    if(isset($_REQUEST['selected_document_category_id']) && $_REQUEST['selected_document_category_id'] !== '') {
      $this->sDocumentCategory = is_numeric($_REQUEST['selected_document_category_id']) ? (int) $_REQUEST['selected_document_category_id'] : $_REQUEST['selected_document_category_id'];
      Session::getSession()->setAttribute('selected_document_category_id', $this->sDocumentCategory);
    } else {
      
      // change default category in case the number of internally managed files exceed a number
      if(Session::getSession()->getAttribute('selected_document_category_id') === null 
        && DocumentPeer::countDocumentsExceedsLimit(40)) {
        $this->sDocumentCategory = DocumentPeer::WITHOUT_CATEGORY;
        Session::getSession()->setAttribute('selected_document_category_id', $this->sDocumentCategory);
      } else {
        $this->sDocumentCategory = Session::getSession()->getAttribute('selected_document_category_id');
      }
    }
    
    // order
    $this->sSortField  = @$_REQUEST['sort_field'] ? $_REQUEST['sort_field'] : 'name';
    $this->sSortOrder  = @$_REQUEST['sort_order'] ? $_REQUEST['sort_order'] : 'asc';
    
    // if there is a key and a document
    if(Manager::hasNextPathItem()) {
      $iId = Manager::peekNextPathItem();
      $this->oDocument = DocumentPeer::retrieveByPk($iId);
      if($this->oDocument) {
        if($this->sDocumentKind !== DocumentPeer::ALL_KINDS && $this->oDocument->getDocumentType()->getDocumentKind() !== $this->sDocumentKind) {
          $this->sDocumentKind = $this->oDocument->getDocumentType()->getDocumentKind();
        }
        $this->aReferences = ReferencePeer::getReferences($this->oDocument);
      }
    }
    // if there are no document types, then load default entries from 'document_types.insert.yml'
    if(!DocumentTypePeer::hasDocTypesPreset()) {
      InstallUtil::loadToDbFromYamlFile('document_types');
    }
  }

  public function getChooser() {
    // document categories select is only displayed when there are categories available
    $aDocumentCategoryOptions = null;
    $aDocumentCategories = DocumentCategoryPeer::getDocumentCategories();
    if(count($aDocumentCategories) > 0) {
      $aDocumentCategoryOptions =  Util::optionsFromObjects($aDocumentCategories, 'getId', 'getName', $this->sDocumentCategory === null ? DocumentPeer::ALL_CATEGORIES : $this->sDocumentCategory, array(DocumentPeer::ALL_CATEGORIES => StringPeer::getString('documents.all_categories'), DocumentPeer::WITHOUT_CATEGORY => StringPeer::getString('document.without_category')));
    } else {
      //Clear document category
      $this->sDocumentCategory = DocumentPeer::ALL_CATEGORIES;
      Session::getSession()->setAttribute('selected_document_kind', $this->sDocumentKind);
    }
    
    $sDocumentName = isset($_REQUEST['search']) && $_REQUEST['search'] != null ? $_REQUEST['search'] : null;
    $aDocuments = DocumentPeer::getDocumentsByKindAndCategory($this->sDocumentKind, $this->sDocumentCategory, $this->sSortField, $this->sSortOrder, true, $sDocumentName);
    $oTemplate = $this->constructTemplate("documents");

    $sSortOrderName = $this->sSortField == 'name' ? $this->sSortOrder == 'asc' ? 'desc' : 'asc' : 'asc';
    $sSortOrderUpdatedBy = $this->sSortField == 'updated_at' ? $this->sSortOrder == 'asc' ? 'desc' : 'asc' : 'asc';
    $oTemplate->replaceIdentifier("link_name", Util::linkToSelf(null, array('sort_field' => 'name', 'sort_order' => $sSortOrderName)));
    $oTemplate->replaceIdentifier("link_date", Util::linkToSelf(null, array('sort_field' => 'updated_at', 'sort_order' => $sSortOrderUpdatedBy)));
    $oTemplate->replaceIdentifier("link_name_class", $this->sSortField == 'name' ? 'sort_'.$this->sSortOrder : 'sort_blind');
    $oTemplate->replaceIdentifier("link_date_class", $this->sSortField == 'updated_at' ? 'sort_'.$this->sSortOrder : 'sort_blind');
    $oTemplate->replaceIdentifier("change_category_action", $this->link());

    
    if(count($aDocuments) === 0) {
      $oTemplate->replaceIdentifier("no_document_message", StringPeer::getString('no_document_message', null, '[Keine Dokumente]'));
    }
    $oTemplate->replaceIdentifier("document_categories_options", $aDocumentCategoryOptions);
    
    // selected_document_kind_options are only displayed if there are any documents
    $aDocumentKindOptions = null;
    $aDocumentKindOptions =  Util::optionsFromArray(DocumentTypePeer::getAllDocumentKindsWhereDocumentsExist(), $this->sDocumentKind, null, array(DocumentPeer::ALL_KINDS => StringPeer::getString('document.all_kinds')));
    $oTemplate->replaceIdentifier("selected_document_kind_options", $aDocumentKindOptions);
    $oLinkTemplatePrototype = $this->constructTemplate("document_list_item");

    foreach($aDocuments as $oDocument) {
      $oLinkTemplate = clone $oLinkTemplatePrototype;
      $oLinkTemplate->replaceIdentifier("link", $this->link($oDocument->getId()));
      $oLinkTemplate->replaceIdentifier("name", Util::truncate($oDocument->getName(),29));
      $oLinkTemplate->replaceIdentifier("doc_type", ' ['.$oDocument->getExtension().']');
      if($this->oDocument && ($this->oDocument->getId() == $oDocument->getId())) {
        $oLinkTemplate->replaceIdentifier('class_active', ' active');
      }
      $oLinkTemplate->replaceIdentifier('title', $oDocument->getName() .'  ['.$oDocument->getExtension().'/'.Util::getDocumentSize($oDocument->getDataSize()).']');
      $oTemplate->replaceIdentifierMultiple("result", $oLinkTemplate, null);
    }
    return $oTemplate;
  }

  public function getDetail() {
    if(Manager::hasNextPathItem() && Manager::peekNextPathItem() === "new" && $this->oDocument === null) {
      $this->oDocument = new Document();
      $this->oDocument->setDocumentType(DocumentTypePeer::doSelectOne(new Criteria()));

      // preselect currently selected Document category for convenience
      $this->oDocument->setDocumentCategoryId($this->sDocumentCategory);
    } elseif ($this->oDocument === null) {
      $oTemplate = $this->constructTemplate("module_info");
      
      $oTemplate->replaceIdentifier('create_link', TagWriter::quickTag('a', array('href' => Util::link('documents', null, array('action' => 'create'))), StringPeer::getString('documents.create')));
      $oTemplate->replaceIdentifier("default_message", StringPeer::getString('default_message_upload'), null, Template::NO_HTML_ESCAPE);
      $oTemplate->replaceIdentifier("document_types", Util::array2HtmlList(DocumentTypePeer::getDocumentTypesList()), null, Template::NO_HTML_ESCAPE);
      $oTemplate->replaceIdentifier("display_style", isset($_REQUEST['get_module_info']) ? 'block' : 'none');
      $oTemplate->replaceIdentifier("toggler_style", isset($_REQUEST['get_module_info']) ? ' open' : '');
      
      return $oTemplate;
    }

    if($this->oDocument !== null) {
      $oTemplate = $this->constructTemplate("document_detail");
      $oTemplate->replaceIdentifier('module_info_link', TagWriter::quickTag('a', array('title' => StringPeer::getString('module_info'), 'class' => 'help', 'href' => Util::link('documents', null, array('get_module_info' => 'true')))));
      $sActionLink = $this->link($this->oDocument->getId(), array('document_category_id' => $this->sDocumentCategory));
      $oTemplate->replaceIdentifier("action", $sActionLink);
      $oTemplate->replaceIdentifier("id", $this->oDocument->getId());
      $oTemplate->replaceIdentifier("name", $this->oDocument->getName() != '' ? $this->oDocument->getName() : '[Neu]');
      $oTemplate->replaceIdentifier("file_name", $this->oDocument->getName());
      $oTemplate->replaceIdentifier("description", $this->oDocument->getDescription());
      $bHasValidUser = false;
      if($this->oDocument->getOwnerId() > 0 && $this->oDocument->getUserRelatedByOwnerId() !== null) {
        $oTemplate->replaceIdentifier("owner", $this->oDocument->getUserRelatedByOwnerId()->getUsername());
        $bHasValidUser = true;
      }
      $oTemplate->replaceIdentifier("is_protected", $this->oDocument->getIsProtected());
      $oTemplate->replaceIdentifier("is_protected_checked", ($this->oDocument->getIsProtected() ? ' checked="checked"' : ''), null, Template::NO_HTML_ESCAPE);

      if(Settings::getSetting('general', 'multilingual', false)) {
        $oTemplate->replaceIdentifier("available_language_options", Util::optionsFromArray(LanguagePeer::getLanguagesAssoc(), $this->oDocument->getLanguageId(), '', array("" => StringPeer::getString("international"))));
      }

      if(DocumentCategoryPeer::hasDocumentCategories()) {
        $oTemplate->replaceIdentifier("doc_category_options", Util::optionsFromObjects(DocumentCategoryPeer::getDocumentCategories(), 'getId', 'getName', $this->oDocument->getDocumentCategoryId()));
      }

      if(!$this->oDocument->isNew()) {
        $oTemplate->replaceIdentifier("document_type", $this->oDocument->getDocumentType()->getMimetype());
        $oTemplate->replaceIdentifier("document_type_info", '['.$this->oDocument->getDocumentType()->getExtension().' | '.$this->oDocument->getDocumentType()->getMimetype().']');
        if($this->oDocument->isImage()) {
          $oImageTemplate = new Template('<p><img src="{{link}}"/></p>', null, true);
          $oImageTemplate->replaceIdentifier('link', Util::link(array("display_document", $this->oDocument->getId()), "FileManager", array("max_width" => 500)));
          $oTemplate->replaceIdentifier("image", $oImageTemplate);
        }
        $sDocLink = $this->oDocument->getName() != '' ? '<a href="'.Util::link(array('display_document', $this->oDocument->getId()), 'FileManager').'" title="anschauen" target="_blank">view</a>' : '';
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
        $oDeleteTemplate->replaceIdentifier("message_js", StringPeer::getString($this->mayNotDelete() ? 'no_permission_for_action' : 'document.has_references'));
        $oDeleteTemplate->replacePstring($sDeleteItemMessage, array('name' => $this->oDocument->getName()));
        $oTemplate->replaceIdentifier("delete_button", $oDeleteTemplate, null, Template::LEAVE_IDENTIFIERS);
      }
      
      return $oTemplate;
    }
  }
  
  public function validateForm($oFlash) {
    $this->bHasUploadedFile = $oFlash->checkForFileUpload('document_upload', 'DocumentType', $this->oDocument !== null);
  }

  public function save() {
    if($this->oDocument === null) {
      $this->oDocument = new Document();
      $this->oDocument->setData(new Blob());
      $this->oDocument->setOwnerId(Session::getSession()->getUserId());
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
      
      // in case document kind is not "all" the document kind always has to be checked/updated in order to display the doc
      if($this->sDocumentKind !== DocumentPeer::ALL_CATEGORIES) {
        $this->sDocumentKind = $this->oDocument->getDocumentType()->getDocumentKind(); 
      }

      Util::redirect($this->link($this->oDocument->getId(),array('selected_document_category_id' => $this->sDocumentCategory, 'selected_document_kind' => $this->sDocumentKind)));
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
    Util::redirectToManager("documents", null, array('selected_document_category_id' => $this->sDocumentCategory));
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
    return array('action' => $this->link('new', array('selected_document_kind' => $this->sDocumentKind, 'selected_document_category_id' => $this->sDocumentCategory)));
  }

  public function hasSearch() {
    return true;
  }
}
