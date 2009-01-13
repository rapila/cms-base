<?php

  // include base peer class
  require_once 'model/om/BaseDocumentTypePeer.php';
  
  // include object class
  include_once 'model/DocumentType.php';


/**
 * Skeleton subclass for performing query and update operations on the 'document_types' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package model
 */	
class DocumentTypePeer extends BaseDocumentTypePeer {
  
  public static function getAllDocumentKindsWhereDocumentsExist() {
    $oCriteria = new Criteria();
    $oCriteria->addJoin(self::ID, DocumentPeer::DOCUMENT_TYPE_ID, Criteria::INNER_JOIN);
    foreach(self::doSelect($oCriteria) as $oDocumentType) {
      $aKind = explode('/', $oDocumentType->getMimeType());
      $aResult[$aKind[0]] = StringPeer::getString('document_kind.'.$aKind[0]);
    }
    return $aResult;
  }
  
  public static function documentKindExists($sDocumentKind = 'application') {
    $oCriteria = new Criteria();
    $oCriteria->addJoin(self::ID, DocumentPeer::DOCUMENT_TYPE_ID, Criteria::INNER_JOIN);
    $oCriteria->add(self::MIMETYPE, "$sDocumentKind%", Criteria::LIKE);
    return self::doSelectOne($oCriteria) !== null;
  }
  
  public static function getDocumentTypeByMimetype($sMimetype=null) {
    $oC = new Criteria();
    $oC->add(self::MIMETYPE, $sMimetype);
    $oDocument = self::doSelectOne($oC);
    return $oDocument;
  }
  
  public static function getDocumentTypeByExtension($sExtension=null) {
    $oC = new Criteria();
    $oC->add(self::EXTENSION, $sExtension);
    $oDocument = self::doSelectOne($oC);
    return $oDocument;
  } // getDocumentTypeByExtension()
  
  public static function getDocumentTypeAndMimetypeByDocumentKind($sMimeTypeKind='image', $bLike=true) {
    $oC = new Criteria();
    $oC->add(self::MIMETYPE, "$sMimeTypeKind/%", $bLike ? Criteria::LIKE : Criteria::NOT_LIKE);
    $aResult = array();
    $aDocumentTypes = self::doSelect($oC);
    foreach($aDocumentTypes as $aDocumentType) {
      $aResult[$aDocumentType->getId()]=$aDocumentType->getMimetype();
    }
    return $aResult;
  } // getMimetypesByDocumentType()
  
  public static function getDocumentTypeForUpload($sFilesName) {
    if(!isset($_FILES[$sFilesName])) {
      throw new Exception("Exception in DocumentTypePeer::getDocumentTypeForUpload(): Invalid file upload specified, '$sFilesName'", UPLOAD_ERR_NO_FILE);
    }
    if($_FILES[$sFilesName]["error"] !== 0) {
      throw new Exception("Exception in DocumentTypePeer::getDocumentTypeForUpload(): File upload has Errors, '$sFilesName'", $_FILES[$sFilesName]["error"]);
    }
    
    $aDocTypeCompare = array();
    if(function_exists("finfo_open")) {
      $rFinfo = finfo_open(FILEINFO_MIME);
      $aDocTypeCompare['finfo'] = finfo_file($rFinfo, $_FILES[$sFilesName]['tmp_name']);
      finfo_close($rFinfo);
    }
    
    $aDocTypeCompare['uploaded'] = $_FILES[$sFilesName]['type'];
    
    $aName = explode(".", $_FILES[$sFilesName]['name']);
    if(count($aName) > 0) {
      $oExtensionDocType = self::getDocumentTypeByExtension($aName[count($aName)-1]);
      if($oExtensionDocType !== null) {
        $aDocTypeCompare['extension'] = $oExtensionDocType->getMimetype();
      }
    }
    
    if(function_exists("mime_content_type")) {
      $aDocTypeCompare['mime_content_type'] = mime_content_type($_FILES[$sFilesName]['tmp_name']);
    }
    
    $aSortedMimeTypes = array_count_values($aDocTypeCompare);
    arsort($aSortedMimeTypes);
    
    $iCount = null;
    foreach($aSortedMimeTypes as $sKey => $iTimes) {
      if($iCount === null) {
        $iCount = $iTimes;
      }
      if($iCount !== $iTimes) {
        unset($aSortedMimeTypes[$sKey]);
      }
    }
    
    foreach($aDocTypeCompare as $sKey => $sDocType) {
      if(isset($aSortedMimeTypes[$sDocType])) {
        $oDocType = self::getDocumentTypeByMimetype($sDocType);
        if($oDocType !== null) {
          return $oDocType;
        }
      }
    }
    
    //Try setting application/octet-stream
    return self::getDocumentTypeByMimetype('application/octet-stream');
  }
  
  public static function hasDocTypesPreset($iMinEntries = 0) {
    $iCount = self::doCount(new Criteria());
    return $iCount > $iMinEntries;
  } // hasDocTypesPreset()
  
  public static function insertRow($aArrayOfValues) {
    $oDocumentType = new DocumentType();
    foreach ($aArrayOfValues as $sFieldName => $mValue) {
      $sMethodName = 'set'.Util::camelize($sFieldName, true);
      $mValue = $mValue === true ? 1 : $mValue;
      $oDocumentType->$sMethodName($mValue);
    }
    $oDocumentType->save();
  } // insertRow()
  
  public static function getDocumentTypesList($bIsOfficeDocType = null) {
    $aResult = array();
    foreach(self::getDocumentTypesByCategory($bIsOfficeDocType) as $oDocumentType) {
      $aResult[] = array('extension' => $oDocumentType->getExtension(), 'mimetype' => $oDocumentType->getMimetype(), 'office_use' => ($oDocumentType->getIsOfficeDoc() ? 'x' : ''));
    }
    return $aResult;
  } // getDocumentTypesList()
  
  public static function getDocumentTypesByCategory($bIsOfficeDocType = null) {
    $oCriteria = new Criteria();
    if (is_bool($bIsOfficeDocType)) {
      $oCriteria->add(self::IS_OFFICE_DOC, $bIsOfficeDocType);
    }
    $oCriteria->addAscendingOrderByColumn(self::IS_OFFICE_DOC);
    $oCriteria->addAscendingOrderByColumn(self::EXTENSION);
    return self::doSelect($oCriteria);
  } // getDocumentTypesByCategory()
  
} // DocumentTypePeer
