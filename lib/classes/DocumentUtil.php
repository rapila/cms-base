<?php
/**
 * classname:   DocumentUtil
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
}