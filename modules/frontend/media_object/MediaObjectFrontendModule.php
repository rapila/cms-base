<?php
/**
 * @package modules.frontend
 */

include_once('propel/util/Criteria.php');

class MediaObjectFrontendModule extends FrontendModule {
  
  public function __construct($oLanguageObject = null, $aRequestPath = null, $iId = 1) {
    parent::__construct($oLanguageObject, $aRequestPath, $iId);
  }

  public function renderFrontend() {
    $aOptions = @unserialize($this->getData());
    $oTemplate = new Template(TemplateIdentifier::constructIdentifier("content"), null, true);
    foreach($aOptions as $aDocumentInfo) {
      $oDocument = DocumentPeer::retrieveByPk($aDocumentInfo['document_id']);
      if($oDocument === null) {
        continue;
      }
      $aMimeType = explode("/", $oDocument->getMimetype());
      $oSubTemplate = null;
      try {
        $oSubTemplate = $this->constructTemplate($aMimeType[0].'/'.$aMimeType[1]);
      } catch (Exception $e) {
        $oSubTemplate = $this->constructTemplate("generic");
      }
      if($aDocumentInfo['width'] != '') {
        $oSubTemplate->replaceIdentifier('width', $aDocumentInfo['width']);
      }
      if($aDocumentInfo['height'] != '') {
        $oSubTemplate->replaceIdentifier('height', $aDocumentInfo['height']);
      }
      $oSubTemplate->replaceIdentifier('src', $oDocument->getDisplayUrl());
      $oSubTemplate->replaceIdentifier('mimeType', $oDocument->getMimetype());
      $oTemplate->replaceIdentifier("content", $oSubTemplate, null, Template::LEAVE_IDENTIFIERS);
    }
    return $oTemplate;
  }
  
  public function renderBackend() {
    $aOptions = @unserialize($this->getData());
    $oTemplate = $this->constructTemplate('backend');
    // if($aOptions !== null) {
    if($aOptions) {
      foreach($aOptions as $iKey => $aDocumentInfo) {
        $oMediaItemTemplate = $this->constructTemplate("backend_media_item");
        $oMediaItemTemplate->replaceIdentifier("sequence_id", $iKey);
        $oMediaItemTemplate->replaceIdentifier("width", $aDocumentInfo['width']);
        $oMediaItemTemplate->replaceIdentifier("height", $aDocumentInfo['height']);
        $this->replaceDocumentOptions($oMediaItemTemplate, $aDocumentInfo['document_id']);
        $oTemplate->replaceIdentifierMultiple("documents", $oMediaItemTemplate);
      }
    }
    $this->replaceDocumentOptions($oTemplate);
    return $oTemplate;
  }
  
  public function getJsForBackend() {
    return $this->constructTemplate("backend.js")->render();
  }
  
  public function save(Blob $oData) {
    $aResults = array();
    foreach($_POST['document_id'] as $iKey => $sId) {
      if($sId === "") {
        continue;
      }
      $aResults[] = array("document_id" => $sId, "width" => $_POST["width"][$iKey], "height" => $_POST["height"][$iKey]);
    }
    $oData->setContents(serialize($aResults));
  }
  
  public static function getContentInfo($oLanguageObject) {
    if(!$oLanguageObject) {
      return null;
    }
    $aData = @unserialize($oLanguageObject->getData()->getContents());
    if(!$aData && !isset($aData[0])) {
      return null;
    }
    $aData = $aData[0];
    $oDocument = DocumentPeer::retrieveByPk($aData['document_id']);
    return Util::nameForObject($oDocument);
  }
  
  private function replaceDocumentOptions($oTemplate, $iSelectedId = null) {
    $oTemplate->replaceIdentifier("available_documents", Util::optionsFromObjects(DocumentPeer::getDocumentsByKindAndCategory(), "getId", "getNameAndExtension", $iSelectedId));
  }
}
?>