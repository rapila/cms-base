<?php
/**
 * @package modules.frontend
 */

include_once('propel/query/Criteria.php');

class MediaObjectFrontendModule extends FrontendModule {
  
  public function __construct($oLanguageObject = null, $aRequestPath = null, $iId = 1) {
    parent::__construct($oLanguageObject, $aRequestPath, $iId);
  }

  public function renderFrontend() {
    $aOptions = @unserialize($this->getData());
    $oTemplate = new Template(TemplateIdentifier::constructIdentifier("content"), null, true);
    foreach($aOptions as $aDocumentInfo) {
      $oDocument = DocumentPeer::retrieveByPK($aDocumentInfo['document_id']);
      $sMimeType = null;
      $sSrc = null;
      
      if($oDocument !== null) {
        $sSrc = $oDocument->getDisplayUrl();
        $sMimeType = $oDocument->getMimetype();
      } else if ((@$aDocumentInfo['url']) != '') {
        $sSrc = @$aDocumentInfo['url'];
        $aHeaders = get_headers($sSrc, true);
        $sMimeType = $aHeaders['Content-Type'];
      } else {
        continue;
      }
      $oSubTemplate = null;
      try {
        $oSubTemplate = $this->constructTemplate($sMimeType);
      } catch (Exception $e) {
        $oSubTemplate = $this->constructTemplate("generic");
      }
      if($aDocumentInfo['width'] != '') {
        $oSubTemplate->replaceIdentifier('width', $aDocumentInfo['width']);
      }
      if($aDocumentInfo['height'] != '') {
        $oSubTemplate->replaceIdentifier('height', $aDocumentInfo['height']);
      }
      $oSubTemplate->replaceIdentifier('src', $sSrc);
      $oSubTemplate->replaceIdentifier('mimeType', $sMimeType);
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
        $oMediaItemTemplate->replaceIdentifier("url", @$aDocumentInfo['url']);
        $oMediaItemTemplate->replaceIdentifier("width", $aDocumentInfo['width']);
        $oMediaItemTemplate->replaceIdentifier("height", $aDocumentInfo['height']);
        $this->replaceDocumentOptions($oMediaItemTemplate, (int)$aDocumentInfo['document_id']);
        $oTemplate->replaceIdentifierMultiple("documents", $oMediaItemTemplate);
      }
    }
    $this->replaceDocumentOptions($oTemplate);
    return $oTemplate;
  }
  
  public function getJsForBackend() {
    return $this->constructTemplate("backend.js")->render();
  }
  
  public function getSaveData() {
    $aResults = array();
    foreach($_POST['document_id'] as $iKey => $sId) {
      if($sId === '' && $_POST['url'][$iKey] === '') {
        continue;
      }
      $aResults[] = array("document_id" => $sId, 'url' => $_POST['url'][$iKey], "width" => $_POST["width"][$iKey], "height" => $_POST["height"][$iKey]);
    }
    return serialize($aResults);
  }
  
  public static function getContentInfo($oLanguageObject) {
    if(!$oLanguageObject) {
      return null;
    }
    $aData = @unserialize(stream_get_contents($oLanguageObject->getData()));
    if(!$aData && !isset($aData[0])) {
      return null;
    }
    $aData = $aData[0];
    $oDocument = DocumentPeer::retrieveByPK($aData['document_id']);
    return Util::nameForObject($oDocument);
  }
  
  private function replaceDocumentOptions($oTemplate, $iSelectedId = null) {
    $oTemplate->replaceIdentifier("available_documents", TagWriter::optionsFromObjects(DocumentPeer::getDocumentsByKindAndCategory(), "getId", "getNameAndExtension", $iSelectedId));
  }
}
?>