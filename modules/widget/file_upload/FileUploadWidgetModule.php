<?php

/**
* @package modules.widget
*/
class FileUploadWidgetModule extends WidgetModule {
	public static function isSingleton() {
		return true;
	}
	
	public function uploadFile($sFileKey, $aOptions, $bCreateType = false) {
		$aFileInfo = $_FILES[$sFileKey];
		
		$oFlash = Flash::getFlash();
		$oFlash->checkForFileUpload($sFileKey);
		$oFlash->finishReporting();
		if(!Flash::noErrors()) {
			throw new ValidationException();
		}
		
		if($aOptions['document_id']) {
			$oDocument = DocumentPeer::retrieveByPK($aOptions['document_id']);
		} else {
			$oDocument = new Document();
		}
		if($oDocument === null) {
			throw new LocalizedException("wns.file_upload.document_not_found");
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
    $oDocument->setData(fopen($aFileInfo['tmp_name'] , "r"));
		$oDocument->setDocumentTypeId($iDocumentTypeId);
		$oDocument->setOriginalName($aOptions['name']);
		
		if($oDocument->isNew()) {
			$oDocument->setName($sFileName);
			$oDocument->setLanguageId($aOptions['language_id']);
			$oDocument->setIsProtected($aOptions['is_protected']);
			if($aOptions['document_category_id']) {
				$oDocument->setDocumentCategoryId($aOptions['document_category_id']);
				$oDocument->setSort(DocumentPeer::getHightestSortByCategory($oDocument->getDocumentCategoryId()) + 1);
			}
		}

		// Resize image if necessary
		if($oDocument->isImage() && $oDocument->getDocumentCategoryId() != null 
			&& $oDocument->getDocumentCategory()->getMaxWidth() != null) {
			$iMaxWidth = $oDocument->getDocumentCategory()->getMaxWidth();
			$oImage = Image::imageFromData(stream_get_contents($oDocument->getData()));
			if($oImage->getOriginalWidth() > $oDocument->getDocumentCategory()->getMaxWidth()) {
				$oImage->setSize((int)$oDocument->getDocumentCategory()->getMaxWidth(), 200, Image::RESIZE_TO_WIDTH);
				ob_start();
				$oImage->render();
				$oDocument->setData(ob_get_contents());
				ob_end_clean();
			}
		}
		
		$oDocument->save();
		return $oDocument->getId();
	}
	
	public function accepts($sFileName, $sMimeType = null) {
		$aName = explode('.', $sFileName);
		$sExtension = null;
		if(count($aName) > 1) {
			$sExtension = array_pop($aName);
			$sFileName = implode('.', $aName);
		}
		$oDocumentType = null;
		if($sMimeType !== null) {
			$oDocumentType = DocumentTypePeer::getDocumentTypeByMimetype($sMimeType);
		}
		if($oDocumentType === null && $sExtension !== null) {
			$oDocumentType = DocumentTypePeer::getDocumentTypeByExtension($sExtension);
		}
		if($oDocumentType === null) {
			throw new LocalizedException("wns.file_upload.document_type_not_found", array('document_type' => $sExtension));
		}
		return $oDocumentType->getId();
	}
}