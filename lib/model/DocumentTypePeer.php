<?php

	// include base peer class
	require_once 'model/om/BaseDocumentTypePeer.php';
	
	// include object class
	include_once 'model/DocumentType.php';

/**
 * @package model
 */ 
class DocumentTypePeer extends BaseDocumentTypePeer {
	
	public static function getAllDocumentKindsWhereDocumentsExist() {
		$oCriteria = new Criteria();
		$oCriteria->addJoin(self::ID, DocumentPeer::DOCUMENT_TYPE_ID, Criteria::INNER_JOIN);
		$aResult = array();
		foreach(self::doSelect($oCriteria) as $oDocumentType) {
			$aKind = explode('/', $oDocumentType->getMimeType());
			$aResult[$aKind[0]] = StringPeer::getString('document_kind.'.$aKind[0]);
		}
		return $aResult;
	}

	public static function getDocumentKinds() {
		$oCriteria = new Criteria();
		$aResult = array();
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
		return self::doCount($oCriteria) > 0;
	}
	
	public static function getDocumentTypeByMimetype($sMimetype=null) {
		$oCriteria = new Criteria();
		$oCriteria->add(self::MIMETYPE, $sMimetype);
		return self::doSelectOne($oCriteria);
	}
	
	public static function getDocumentTypeByExtension($sExtension=null) {
		$oCriteria = new Criteria();
		$oCriteria->add(self::EXTENSION, $sExtension);
		return self::doSelectOne($oCriteria);
	}
	
	public static function getDocumentTypeAndMimetypeByDocumentKind($sMimeTypeKind='image', $bLike=true) {
		$oCriteria = new Criteria();
		$oCriteria->add(self::MIMETYPE, "$sMimeTypeKind/%", $bLike ? Criteria::LIKE : Criteria::NOT_LIKE);
		$aResult = array();
		foreach(self::doSelect($oCriteria) as $aDocumentType) {
			$aResult[$aDocumentType->getId()]=$aDocumentType->getMimetype();
		}
		return $aResult;
	}
	
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
		return self::doCount(new Criteria()) > $iMinEntries;
	}
	
	public static function insertRow($aArrayOfValues) {
		$oDocumentType = new DocumentType();
		foreach ($aArrayOfValues as $sFieldName => $mValue) {
			$sMethodName = 'set'.StringUtil::camelize($sFieldName, true);
			$mValue = $mValue === true ? 1 : $mValue;
			$oDocumentType->$sMethodName($mValue);
		}
		$oDocumentType->save();
	}
	
	public static function getDocumentTypesByCategory($bIsOfficeDocType = null) {
		$oCriteria = new Criteria();
		if (is_bool($bIsOfficeDocType)) {
			$oCriteria->add(self::IS_OFFICE_DOC, $bIsOfficeDocType);
		}
		$oCriteria->addAscendingOrderByColumn(self::IS_OFFICE_DOC);
		$oCriteria->addAscendingOrderByColumn(self::EXTENSION);
		return self::doSelect($oCriteria);
	}
	
}

