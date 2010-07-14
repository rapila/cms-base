<?php
class FileUploadWidgetModule extends WidgetModule {
	public static function isSingleton() {
		return YES;
	}
	
	public function uploadFile($sFileData, $aOptions) {
		$sFileData = base64_decode($sFileData);
		if($aOptions['document_id']) {
			$oDocument = DocumentPeer::retrieveByPK($sFileData['document_id']);
		} else {
			$oDocument = new Document();
		}
		if($oDocument === null) {
			throw new LocalizedException("widget.file_upload.document_not_found");
		}
		$sFileName = $aOptions['name'];
		$aName = explode('.', $sFileName);
		$sExtension = null;
		if(count($aName) > 1) {
			$sExtension = array_pop($aName);
			$sFileName = implode('.', $aName);
		}
		$oDocumentType = DocumentTypePeer::getDocumentTypeByMimetype($aOptions['type']);
		if($oDocumentType === null && $sExtension !== null) {
			$oDocumentType = DocumentTypePeer::getDocumentTypeByExtension($sExtension);
		}
		if($oDocumentType === null) {
			throw new LocalizedException("widget.file_upload.document_type_not_found");
		}
		$oDocument->setData($sFileData);
		$oDocument->setName($sFileName);
		$oDocument->setLanguageId($aOptions['language_id']);
		$oDocument->setIsProtected($aOptions['is_protected']);
		$oDocument->setDocumentType($oDocumentType);
		if($aOptions['document_category_id']) {
			$oDocument->setDocumentCategoryId($aOptions['document_category_id']);
		}
		$oDocument->save();
		return $oDocument->getId();
	}
}