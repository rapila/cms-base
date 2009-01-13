<?php
/**
 * @package modules.backend
 */

define('DOCUMENT_DEFAULT_KIND', 'application');

class DocumentsBackendModule extends BackendModule {

  private $oDocument = null;
  private $sDocumentKind = 'application';
  private $oDocumentType = null;
  private $sDocumentCategory;
  private $sSortField;
  private $sSortOrder;
  
  const ALL_CATEGORIES = 'all';
  const WITHOUT_CATEGORY = '';

  public function __construct() {
    
    // document_kind = text, application, image etc
    if(isset($_REQUEST['document_kind'])) {
      $this->sDocumentKind = $_REQUEST['document_kind'] !== '' ? $_REQUEST['document_kind'] : null;
      Session::getSession()->setAttribute('document_kind', $this->sDocumentKind);
    } else {
      $sDefaultDocumentKind = DocumentTypePeer::documentKindExists($this->sDocumentKind) ? $this->sDocumentKind : null;
      $this->sDocumentKind = Session::getSession()->getAttribute('document_kind') !== null ? Session::getSession()->getAttribute('document_kind') : $sDefaultDocumentKind;
    }
    // document_category_id can be specific int, all, without category
    if(isset($_REQUEST['document_category_id'])) {
      if($_REQUEST['document_category_id'] == self::ALL_CATEGORIES) {
        $this->sDocumentCategory = null;
      } else {
        $this->sDocumentCategory = is_numeric($_REQUEST['document_category_id']) ? (int) $_REQUEST['document_category_id'] : '';
      }
      Session::getSession()->setAttribute('document_category_id', $this->sDocumentCategory);
    } else {
      $this->sDocumentCategory = Session::getSession()->getAttribute('document_category_id') !== null ? Session::getSession()->getAttribute('document_category_id') : null;
    }
    
    // order
    $this->sSortField  = @$_REQUEST['sort_field'] ? $_REQUEST['sort_field'] : 'name';
    $this->sSortOrder  = @$_REQUEST['sort_order'] ? $_REQUEST['sort_order'] : 'asc';
    
    // if there is a key and a document
    if(Manager::hasNextPathItem()) {
      $iId = Manager::peekNextPathItem();
      $this->oDocument = DocumentPeer::retrieveByPk($iId);
    }
    // if there are no document types, then load default entries from 'document_types.insert.yml'
    if(!DocumentTypePeer::hasDocTypesPreset()) {
      InstallUtil::loadToDbFromYamlFile('document_types');
    }
  }

  public function getChooser() {
    $bHasAnyDocuments = DocumentPeer::doCount(new Criteria()) !== 0;
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

    // document categories select is only displayed when there are categories available
    $aDocumentCategoryOptions = null;
    $aDocumentCategories = DocumentCategoryPeer::getDocumentCategoriesSorted();
    if (count($aDocumentCategories) > 0 && $bHasAnyDocuments) {
      $aDocumentCategoryOptions =  Util::optionsFromObjects($aDocumentCategories, 'getId', 'getName', $this->sDocumentCategory, array(self::ALL_CATEGORIES => StringPeer::getString('all_entries'), self::WITHOUT_CATEGORY => StringPeer::getString('documents_get_undefined_categories')));
    } else {
      $oTemplate->replaceIdentifier("no_document_message", StringPeer::getString('no_document_message', null, '[Keine Dokumente]'));
    }
    $oTemplate->replaceIdentifier("document_categories_options", $aDocumentCategoryOptions);
    
    // document_kind_options are only displayed if there are any documents
    $aDocumentKindOptions = null;
    if ($bHasAnyDocuments) {
      $aDocumentKindOptions =  Util::optionsFromArray(DocumentTypePeer::getAllDocumentKindsWhereDocumentsExist(), $this->sDocumentKind);
    }
    $oTemplate->replaceIdentifier("document_kind_options", $aDocumentKindOptions);
    $oLinkTemplatePrototype = $this->constructTemplate("document_list_item");

    if($bHasAnyDocuments) {
      foreach($aDocuments as $oDocument) {
        $oLinkTemplate = clone $oLinkTemplatePrototype;
        $oLinkTemplate->replaceIdentifier("link", $this->link($oDocument->getId()));
        $oLinkTemplate->replaceIdentifier("name", Util::truncate($oDocument->getName(),29));
        $oLinkTemplate->replaceIdentifier("doc_type", ' ['.$oDocument->getExtension().']');
        if($this->oDocument && ($this->oDocument->getId() == $oDocument->getId())) {
          $oLinkTemplate->replaceIdentifier('class_active', ' active');
        }
        $oLinkTemplate->replaceIdentifier('title', $oDocument->getName() .'  ['.$oDocument->getExtension().'/'.Util::getDocumentSize($oDocument->getData()->getContents()).']');
        $oTemplate->replaceIdentifierMultiple("result", $oLinkTemplate, null);
      }
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
      $oTemplate = $this->constructTemplate("message", true);
      $oTemplate->replaceIdentifier("default_message", StringPeer::getString('default_message_upload'), null, Template::NO_HTML_ESCAPE);
      $oTemplate->replaceIdentifier("document_types", Util::array2HtmlList(DocumentTypePeer::getDocumentTypesList()), null, Template::NO_HTML_ESCAPE);
      return $oTemplate;
    }

    if($this->oDocument !== null) {
      $oTemplate = $this->constructTemplate("document_detail");
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
        $oTemplate->replaceIdentifier("doc_category_options", Util::optionsFromObjects(DocumentCategoryPeer::getDocumentCategoriesSorted(), 'getId', 'getName', $this->oDocument->getDocumentCategoryId()));
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

        //delete button
        $sDeleteButtenTemplate = "delete_button";
        $sDeleteItemMessage = "delete_item";
        $sDeleteAlertMessage = StringPeer::getString("delete_confirm");
        if($this->mayNotDelete()) {
          $sDeleteButtenTemplate = "delete_button_inactive";
          $sDeleteItemMessage = "delete_item_inactive";
          $sDeleteAlertMessage = StringPeer::getString('no_permission_for_action');
        }
        $oDeleteTemplate = $this->constructTemplate($sDeleteButtenTemplate);
        $oDeleteTemplate->replaceIdentifier("action", $sActionLink);
        $oDeleteTemplate->replaceIdentifier("message_js", $sDeleteAlertMessage);
        $oDeleteTemplate->replacePstring($sDeleteItemMessage, array('name' => $this->oDocument->getName()));

        $oTemplate->replaceIdentifier("delete_button", $oDeleteTemplate, null, Template::LEAVE_IDENTIFIERS);
      }
      return $oTemplate;
    }
  }

  public function validateForm($oFlash) {
    try {
      $this->oDocumentType = DocumentTypePeer::getDocumentTypeForUpload('document_upload');
      if($this->oDocumentType === null) {
        $oFlash->addMessage('document_type');
      }
    } catch(Exception $e) {
      if($e->getCode() !== UPLOAD_ERR_NO_FILE) {
        $oFlash->addMessage('upload_error');
      } elseif($this->oDocument === null) {
        $oFlash->addMessage('no_upload_in_new_document');
      }
    }
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
    if($this->oDocumentType !== null) {
      $aName = explode(".", $_FILES["document_upload"]['name']);
      if(count($aName) > 1) {
        array_pop($aName);
      }

      $this->oDocument->getData()->readFromFile($_FILES["document_upload"]['tmp_name']);
      $this->oDocument->setName($this->oDocument->getName() != '' ? $this->oDocument->getName() : implode(".", $aName));
      $this->oDocument->setData($this->oDocument->getData());
      $this->oDocument->setDocumentType($this->oDocumentType);
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
      Util::redirect($this->link($this->oDocument->getId(),array('document_category_id' => $this->sDocumentCategory, 'document_kind' => $this->sDocumentKind)));
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
    if($this->oDocument !== null && !$this->mayNotDelete()) {
      $this->oDocument->delete();
    }
    Util::redirectToManager("documents", null, array('document_category_id' => $this->sDocumentCategory));
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
    return array('action' => $this->link('new', array('document_kind' => $this->sDocumentKind, 'document_category_id' => $this->sDocumentCategory)));
  }

  public function hasSearch() {
    return true;
  }
}
