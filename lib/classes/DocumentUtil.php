<?php
/**
 * @package utils
 */
class DocumentUtil {
 /**
  * updateDocument()
  * @param string : uplaod input[type=file] name 
  * @param int : document_id if insert
  * @param int : optional document_category_id
  * @param string : optional document description
  * @param string : optional language_id (if not international)
  * 
  * @return int : document_id
  */                             
  public static function updateDocument($sUploadFileName, 
                                        $iDocumentId=null, 
                                        $sDocumentName=null, 
                                        $iDocumentCategoryId=null, 
                                        $sLanguageId=null) {

    // nice to have flash check integrated
    $oDocument = DocumentPeer::retrieveByPK($iDocumentId);
    if($oDocument === null || !$iDocumentId) {
      $oDocument = new Document();
      $oDocument->setData(new Blob());
      $oDocument->setOwnerId(Session::getSession()->getUser()->getId());
    }
    $oDocument->setDocumentCategoryId($iDocumentCategoryId);
    if($sLanguageId !== null) {
      $oDocument->setLanguageId($sLanguageId);
    }
    $oDocument->setDescription(null);
    
    $aFileName = explode(".", $_FILES[$sUploadFileName]['name']);
    if(count($aFileName) > 1) {
      array_pop($aFileName);
    }

    $oDocument->setName($sDocumentName.': '.implode(".", $aFileName));
    $oDocument->getData()->readFromFile($_FILES[$sUploadFileName]['tmp_name']);
    $oDocument->setData($oDocument->getData());
    $oDocumentType = DocumentTypePeer::getDocumentTypeForUpload($sUploadFileName);
    $oDocument->setDocumentType($oDocumentType);
    $oDocument->save();
    return $oDocument->getId();
  }

  public static function getDocumentSize($sDocContent=null, $sFormat = 'KiB', $bAutomatic = true) {
    $iDocLength = 0;
    if(is_string($sDocContent)) {
      $iDocLength = strlen($sDocContent); 
    } else if($sDocContent instanceof Blob) {
      $iDocLength = strlen($sDocContent->getContents()); 
    } else if(is_numeric($sDocContent)) {
      $iDocLength = $sDocContent;
    }
    $oOutputDividor = 1;
    switch($sFormat) {
      case "KiB":
      case "kB":
      case "kb":
      case "k":
      case "Kb":
        $oOutputDividor = 1024;
        break;
      case "MiB":
      case "MB":
      case "M":
        $oOutputDividor = 1024 * 1024;
        break;
      case "GiB":
      case "GB":
      case "Gb":
        $oOutputDividor = 1024 * 1024 * 1024;
        break;
    }
    if($bAutomatic && ($iDocLength > (1024*1024))) {
      $oOutputDividor =  1024 * 1024;
      $sFormat = 'MB';
    }
    return round($iDocLength/$oOutputDividor, 2)." ".$sFormat;
  }
}