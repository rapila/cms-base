<?php
/**
 * @package modules.frontend
 */
class RelatedFrontendModule extends DynamicFrontendModule {
  
  private static $TEXT_ENCODING = "utf-8";
  
  public function __construct($oLanguageObject, $aRequestPath = null) {
    parent::__construct($oLanguageObject, $aRequestPath);
  }
  
  public function renderFrontend() {
    $tmpl = $this->constructTemplate();
    $sTags = $this->getData();
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
        $sDocumentsTemp = $this->constructTemplate("document");
        $sDocumentsTemp->replaceIdentifier("name", $oCorrespondingDocument->getName());
        $sDocumentsTemp->replaceIdentifier("link", $oCorrespondingDocument->getLink());
        $sDocumentsTemp->replaceIdentifier("description", $oCorrespondingDocument->getDescription());
        $sDocumentsTemp->replaceIdentifier("type", $oCorrespondingDocument->getDocumentType()->getExtension());
        $sDocumentsTemp->replaceIdentifier("doctype", strtoupper($oCorrespondingDocument->getDocumentType()->getExtension()));
        $sDocumentsTemp->replaceIdentifier("size", Util::getDocumentSize($oCorrespondingDocument->getData()->getContents(), 'kb'));
        $tmpl->replaceIdentifierMultiple("documents", $sDocumentsTemp);
      }
      
      $aCorrespondingLinks = $oTag->getAllCorrespondingDataEntries("Link");
      foreach($aCorrespondingLinks as $oCorrespondingLink) {
        if($oCorrespondingLink->getLanguageId() !== null && $oCorrespondingLink->getLanguageId() !== Session::language()) {
          continue;
        }
        $bDocumentFound = true;
        $sLinksTemp = $this->constructTemplate("link");
        $sLinksTemp->replaceIdentifier("name", $oCorrespondingLink->getName());
        $sLinksTemp->replaceIdentifier("link", Template::htmlEncode($oCorrespondingLink->getUrl()));
        $sLinksTemp->replaceIdentifier("description", $oCorrespondingLink->getDescription());
        $tmpl->replaceIdentifierMultiple("links", $sLinksTemp);
      }
      
      $aCorrespondingPages = $oTag->getAllCorrespondingDataEntries("Page");
      foreach($aCorrespondingPages as $oCorrespondingPage) {
        if(Manager::getCurrentPage() !== null && $oCorrespondingPage->getId() === Manager::getCurrentPage()->getId()) {
          continue;
        }
        $bDocumentFound = true;
        $oRelatedPagesTemp = $this->constructTemplate("page");
        $oRelatedPagesTemp->replaceIdentifier("name", $oCorrespondingPage->getPageTitle());
        $oRelatedPagesTemp->replaceIdentifier("link", Util::link($oCorrespondingPage->getLink()));
        $oRelatedPagesTemp->replaceIdentifier("link_text", $oCorrespondingPage->getLinkText());
        $tmpl->replaceIdentifierMultiple("pages", $oRelatedPagesTemp);
      }
    }
    if(!$bDocumentFound) {
      $tmpl = $this->constructTemplate("empty");
    }
    return $tmpl;
  }
  
  public function renderBackend() {
    $tmpl = $this->constructTemplate('main_admin');
    $tmpl->replaceIdentifier("text", Util::encodeForBrowser($this->getData(), self::$TEXT_ENCODING));
    return $tmpl;
  }
  
  public function getJsForBackend() {
    return $this->constructTemplate('js');
  }
  
  public function save(Blob $oData) {
    $sText = $_POST['data'];
    $oData->setContents($sText);
  }
}