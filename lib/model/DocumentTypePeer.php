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
			$aResult[$aKind[0]] = StringPeer::getString('widget.document_kind.'.$aKind[0]);
		}
		return $aResult;
	}

	public static function getDocumentKindsAssoc() {
		$oCriteria = new Criteria();
		$aResult = array();
		foreach(self::doSelect($oCriteria) as $oDocumentType) {
			$aKind = explode('/', $oDocumentType->getMimeType());
			$aResult[$aKind[0]] = self::getDocumentKindName($aKind[0]);
		}
		return $aResult;
	}
	
	public static function getDocumentKindName($sKey) {
		return StringPeer::getString('widget.document_kind.'.$sKey);
	}
	
	public static function documentKindExists($sDocumentKind = 'application') {
		$oCriteria = new Criteria();
		$oCriteria->addJoin(self::ID, DocumentPeer::DOCUMENT_TYPE_ID, Criteria::INNER_JOIN);
		$oCriteria->add(self::MIMETYPE, "$sDocumentKind%", Criteria::LIKE);
		return self::doCount($oCriteria) > 0;
	}
	
	public static function getMimeTypes() {
		$oCriteria = new Criteria();
		$oCriteria->setDistinct();
		$oCriteria->addAscendingOrderByColumn(self::MIMETYPE);
		return self::doSelect($oCriteria);
	}
	
	public static function getMimeTypesAssoc() {
		$aResult = array();
		foreach(self::getMimeTypes() as $oMimeType) {
			$aResult[$oMimeType->getDocumentKind()] = ucfirst($oMimeType->getDocumentKind());
		}
		return $aResult;
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
	
	public static function getMostAgreedMimetypes($sFileName, $aDocTypeCompare = array(), $sBaseName = null) {
		if($sBaseName === null) {
			$sBaseName = basename($sFileName);
		}
		
		if(is_dir($sFileName)) {
			return 'application/x-directory';
		}
		
		if(function_exists("finfo_open")) {
			$rFinfo = finfo_open(FILEINFO_MIME);
			$aDocTypeCompare['finfo'] = finfo_file($rFinfo, $sFileName);
			finfo_close($rFinfo);
		}
		
		$aName = explode(".", $sBaseName);
		if(count($aName) > 0) {
			$oExtensionDocType = self::getDocumentTypeByExtension($aName[count($aName)-1]);
			if($oExtensionDocType !== null) {
				$aDocTypeCompare['extension'] = $oExtensionDocType->getMimetype();
			}
		}
		
		if(function_exists("mime_content_type")) {
			$aDocTypeCompare['mime_content_type'] = mime_content_type($sFileName);
		}
		
		if(($rFileUtility = popen("file --mime-type ".escapeshellarg($sFileName)." 2>/dev/null", "r")) !== false) {
			$sReply = fgets($rFileUtility);
			pclose($rFileUtility);
			
			// the reply begins with the requested filename
			if (!strncmp($sReply, "$sFileName: ", strlen($sFileName)+2)) {					 
				$sReply = substr($sReply, strlen($sFileName)+2);
				// followed by the mime type (maybe including options)
				if (preg_match('|^[[:alnum:]_-]+/[[:alnum:]_-]+;?.*|', $sReply, $matches)) {
					$aDocTypeCompare['file_utility'] = $matches[0];
				}
			}
		}
		
		$aSortedMimeTypes = array_count_values($aDocTypeCompare);
		arsort($aSortedMimeTypes);
		
		$iCount = null;
		$aResult = array();
		foreach($aSortedMimeTypes as $sKey => $iTimes) {
			if($iCount === null) {
				$iCount = $iTimes;
			}
			if($iCount === $iTimes) {
				$aResult[] = $sKey;
			}
		}
		
		if(count($aResult) === 0) {
			$aResult[] = 'application/octet-stream';
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
		
		$aSortedMimeTypes = self::getMostAgreedMimetypes($_FILES[$sFilesName]['tmp_name'], array('uploaded' => $_FILES[$sFilesName]['type']), $_FILES[$sFilesName]['name']);
		
		foreach($aSortedMimeTypes as $sDocType) {
			$oDocType = self::getDocumentTypeByMimetype($sDocType);
			if($oDocType !== null) {
				return $oDocType;
			}
		}
		
		return null;
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
	
	public static function addSearchToCriteria($sSearch, $oCriteria) {
		$oSearchCriterion = $oCriteria->getNewCriterion(DocumentTypePeer::EXTENSION,"%$sSearch%", Criteria::LIKE);
		$oSearchCriterion->addOr($oCriteria->getNewCriterion(DocumentTypePeer::MIMETYPE, "%$sSearch%", Criteria::LIKE));
		$oCriteria->add($oSearchCriterion);
	}
}

