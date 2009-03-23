<?php
/**
 * @package modules.frontend
 */
class RelatedFrontendModule extends DynamicFrontendModule {
  
  private static $LIST_TYPES = array('documents', 'links', 'pages');
  
  public function __construct($oLanguageObject, $aRequestPath = null) {
    parent::__construct($oLanguageObject, $aRequestPath);
  }
  
  public function renderFrontend() {
    $aData = $this->getData();
    $oTemplate = new Template($aData['template']);
    $sTags = $aData['tags'];
    $bDocumentFound = false;
    
    $aTags = explode(",", $sTags);
    foreach($aTags as $sTag) {
      $oTag = TagPeer::retrieveByName($sTag);
      
      if($oTag === null) {
        continue;
      }
      
      $aCorrespondingDocuments = $oTag->getAllCorrespondingDataEntries("Document");
      foreach($aCorrespondingDocuments as $oCorrespondingDocument) {
        if($oCorrespondingDocument->getLanguageId() !== null && $oCorrespondingDocument->getLanguageId() !== Session::language()) {
          continue;
        }
        $bDocumentFound = true;
        $sDocumentsTemp = new Template($aData['template'].'_item');
        $sDocumentsTemp->replaceIdentifier('model', 'Document');
        $sDocumentsTemp->replaceIdentifier("name", $oCorrespondingDocument->getName());
        $sDocumentsTemp->replaceIdentifier("link_text", $oCorrespondingDocument->getName());
        $sDocumentsTemp->replaceIdentifier("title", $oCorrespondingDocument->getName());
        $sDocumentsTemp->replaceIdentifier("description", $oCorrespondingDocument->getDescription());
        $sDocumentsTemp->replaceIdentifier("extension", $oCorrespondingDocument->getExtension());
        $sDocumentsTemp->replaceIdentifier("mimetype", $oCorrespondingDocument->getMimetype());
        $sDocumentsTemp->replaceIdentifier("url", $oCorrespondingDocument->getLink());
        $sDocumentsTemp->replaceIdentifier('category_id', $oCorrespondingDocument->getDocumentCategoryId());
        $sDocumentsTemp->replaceIdentifier("size", Util::getDocumentSize($oCorrespondingDocument->getData()->getContents(), 'kb'));
        $oTemplate->replaceIdentifierMultiple("items", $sDocumentsTemp);
      }
      
      $aCorrespondingLinks = $oTag->getAllCorrespondingDataEntries("Link");
      foreach($aCorrespondingLinks as $oCorrespondingLink) {
        if($oCorrespondingLink->getLanguageId() !== null && $oCorrespondingLink->getLanguageId() !== Session::language()) {
          continue;
        }
        $bDocumentFound = true;
        $sLinksTemp = new Template($aData['template'].'_item');
        $sLinksTemp->replaceIdentifier('model', 'Link');
        $sLinksTemp->replaceIdentifier("name", $oCorrespondingLink->getName());
        $sLinksTemp->replaceIdentifier("link_text", $oCorrespondingLink->getName());
        $sLinksTemp->replaceIdentifier("title", $oCorrespondingLink->getName());
        $sLinksTemp->replaceIdentifier("description", $oCorrespondingLink->getDescription());
        $sLinksTemp->replaceIdentifier("url", Template::htmlEncode($oCorrespondingLink->getUrl()));
        $oTemplate->replaceIdentifierMultiple("items", $sLinksTemp);
      }
      
      $aCorrespondingPages = $oTag->getAllCorrespondingDataEntries("Page");
      foreach($aCorrespondingPages as $oCorrespondingPage) {
        if(Manager::getCurrentPage() !== null && $oCorrespondingPage->getId() === Manager::getCurrentPage()->getId()) {
          continue;
        }
        $bDocumentFound = true;
        $oRelatedPagesTemp = new Template($aData['template'].'_item');
        $oRelatedPagesTemp->replaceIdentifier('model', 'Page');
        $oRelatedPagesTemp->replaceIdentifier("name", $oCorrespondingPage->getName());
        $oRelatedPagesTemp->replaceIdentifier("link_text", $oCorrespondingPage->getLinkText());
        $oRelatedPagesTemp->replaceIdentifier("title", $oCorrespondingPage->getPageTitle());
        $oRelatedPagesTemp->replaceIdentifier("description", $oCorrespondingPage->getPageTitle());
        $oRelatedPagesTemp->replaceIdentifier("url", Util::link($oCorrespondingPage->getLink()));
        $oTemplate->replaceIdentifierMultiple("items", $oRelatedPagesTemp);
      }
    }
    if(!$bDocumentFound) {
      return null;
    }
    return $oTemplate;
  }
  
  public function getData() {
    $aData = @unserialize(parent::getData());
    if($aData === false) {
      $aData = array('tags' => parent::getData(), 'types' => array(), 'template' => '');
    }
    return $aData;
  }
  
  public function renderBackend() {
    $aData = $this->getData();
    
    $oTemplate = $this->constructTemplate('backend');
    $oTemplate->replaceIdentifier("text", $aData['tags']);
    $aListTypes = array();
    foreach(self::$LIST_TYPES as $sName) {
      $aListTypes[] = StringPeer::getString('module.backend.'.$sName);
    }
    $oTemplate->replaceIdentifier("type_options", Util::optionsFromArray($aListTypes, $aData['types'], null, null));
    $oTemplate->replaceIdentifier("template_options", Util::optionsFromArray(BackendManager::getSiteTemplatesForListOutput(), $aData['template']));
    
    return $oTemplate;
  }
  
  public function getJsForBackend() {
    return $this->constructTemplate('js');
  }
  
  public function save(Blob $oData) {
    $aData = array();
    
    $aData['tags'] = $_POST['data'];
    $aData['types'] = $_POST['types'];
    $aData['template'] = $_POST['template'];
    
    $oData->setContents(serialize($aData));
  }
}