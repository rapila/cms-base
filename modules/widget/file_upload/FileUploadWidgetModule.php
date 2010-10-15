<?php

/**
* @package modules.widget
*/
class FileUploadWidgetModule extends WidgetModule {
	public static function isSingleton() {
		return true;
	}
	
	public function uploadFile($sFileData, $aOptions, $bCreateType = false) {
		$sFileData = base64_decode($sFileData);
		if($aOptions['document_id']) {
			$oDocument = DocumentPeer::retrieveByPK($aOptions['document_id']);
		} else {
			$oDocument = new Document();
		}
		if($oDocument === null) {
			throw new LocalizedException("widget.file_upload.document_not_found");
		}
		$sFileName = $aOptions['name'];
		$aName = explode('.', $sFileName);
		if(count($aName) > 1) {
			array_pop($aName);
			$sFileName = implode('.', $aName);
		}
		$iDocumentTypeId = null;
		try {
			$iDocumentTypeId = $this->accepts($aOptions['name'], $aOptions['type']);
		} catch(Exception $e) {
			if($bCreateType) {
				$aName = explode('.', $aOptions['name']);
				$sExtension = null;
				if(count($aName) > 1) {
					$sExtension = array_pop($aName);
				}
				$aMimeType = explode('/', $aOptions['type']);
				if($sExtension === null) {
					$sExtension = $aMimeType[1];
				}
				$oDocumentType = new DocumentType();
				$oDocumentType->setExtension($sExtension);
				$oDocumentType->setMimetype(implode('/', $aMimeType));
			}
			$oDocumentType->save();
			$iDocumentTypeId = $oDocumentType->getId();
		}
		$oDocument->setData($sFileData);
		$oDocument->setDocumentTypeId($iDocumentTypeId);
		$oDocument->setOriginalName($aOptions['name']);
		if($oDocument->isNew()) {
  		$oDocument->setName($sFileName);
  		$oDocument->setLanguageId($aOptions['language_id']);
  		$oDocument->setIsProtected($aOptions['is_protected']);
  		if($aOptions['document_category_id']) {
  			$oDocument->setDocumentCategoryId($aOptions['document_category_id']);
  		}
		}
    $oDocument->save();
		return $oDocument->getId();
	}
	
	public function accepts($sFileName, $sMimeType) {
		$aName = explode('.', $sFileName);
		$sExtension = null;
		if(count($aName) > 1) {
			$sExtension = array_pop($aName);
			$sFileName = implode('.', $aName);
		}
		$oDocumentType = DocumentTypePeer::getDocumentTypeByMimetype($sMimeType);
		if($oDocumentType === null && $sExtension !== null) {
			$oDocumentType = DocumentTypePeer::getDocumentTypeByExtension($sExtension);
		}
		if($oDocumentType === null) {
			throw new LocalizedException("file_upload.document_type_not_found", array('document_type' => $sExtension));
		}
		return $oDocumentType->getId();
	}
}