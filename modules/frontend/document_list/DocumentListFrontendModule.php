<?php
/**
 * @package modules.frontend
 */

class DocumentListFrontendModule extends DynamicFrontendModule {
  
  const LIST_ITEM_POSTFIX = '_item';
  
  public function renderFrontend() {
    $aOptions = @unserialize($this->getData());
    $oCriteria = new Criteria();
    if(isset($aOptions['categories']) && is_array($aOptions['categories']) && (count($aOptions['categories']) > 0)) {
      $oCriteria->add(DocumentPeer::DOCUMENT_CATEGORY_ID, $aOptions['categories'], Criteria::IN);
      $oCriteria->addAscendingOrderByColumn(DocumentPeer::NAME);
    }
    $aDocuments = DocumentPeer::doSelect($oCriteria);
    
    try {
      $oListTemplate = new Template($aOptions['list_template']);
      foreach($aDocuments as $i => $oDocument) {
        $oItemTemplate = new Template($aOptions['list_template'].self::LIST_ITEM_POSTFIX);
        $oItemTemplate->replaceIdentifier('model', 'Document');
        $oItemTemplate->replaceIdentifier('name', $oDocument->getName());
        $oItemTemplate->replaceIdentifier('link_text', $oDocument->getName());
        $oItemTemplate->replaceIdentifier('title', $oDocument->getName());
        $oItemTemplate->replaceIdentifier('description', $oDocument->getDescription());
        $oItemTemplate->replaceIdentifier('extension', $oDocument->getExtension());
        $oItemTemplate->replaceIdentifier('mimetype', $oDocument->getMimetype());
        $oItemTemplate->replaceIdentifier('url', $oDocument->getDisplayUrl());
        $oItemTemplate->replaceIdentifier('category_id', $oDocument->getDocumentCategoryId());
        $oItemTemplate->replaceIdentifier("size", DocumentUtil::getDocumentSize($oDocument->getDataSize(), 'kb'));
        $oListTemplate->replaceIdentifierMultiple('items', $oItemTemplate);
      }
    } catch(Exception $e) {
      $oListTemplate = new Template("", null, true);
    }
    
    return $oListTemplate;
  }

  public function renderBackend() {
    $aOptions = @unserialize($this->getData());
    $aDocumentCategories = DocumentCategoryPeer::doSelect(new Criteria());
    $oTemplate = $this->constructTemplate('backend');
    $oTemplate->replaceIdentifier('categories', TagWriter::optionsFromObjects($aDocumentCategories, 'getId', 'getName', @$aOptions['categories'], false));
    
    if(isset($aOptions['categories']) && is_array($aOptions['categories'])) {
      foreach($aOptions['categories'] as $sCategoryId) {
        $oTemplate->replaceIdentifierMultiple('documents_edit_link', TagWriter::quickTag('a', array('class' => 'edit_related_link highlight', 'href' => LinkUtil::link(array('documents'), 'BackendManager', array('selected_document_category_id' => $sCategoryId))), StringPeer::getString('edit_module', null, null,array('module_name' => StringPeer::getString('documents'))).(' ['.DocumentCategoryPeer::getCategoryNameById($sCategoryId).']')));
      }
    }
    $aListTemplates = BackendManager::getSiteTemplatesForListOutput(self::LIST_ITEM_POSTFIX);
    $oTemplate->replaceIdentifier('list_templates', TagWriter::optionsFromArray($aListTemplates, @$aOptions['list_template'], false));
    return $oTemplate;
  } 
  
  public function save(Blob $oData) {
    $_POST['categories'] = is_array($_POST['categories']) ? $_POST['categories'] : array($_POST['categories']);
    foreach($_POST['categories'] as $sKey => $sValue) {
      settype($_POST['categories'][$sKey], 'integer');
    }
    $oData->setContents(serialize(array('categories' => $_POST['categories'], 'list_template' => $_POST['list_template'])));
  }
}
