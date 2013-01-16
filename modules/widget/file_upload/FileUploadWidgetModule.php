<?php

/**
* @package modules.widget
*/
class FileUploadWidgetModule extends WidgetModule {
	public static function isSingleton() {
		return true;
	}

	public function uploadFile($sFileKey = 'file', $aOptions = null, $bCreateType = false) {
		$oFlash = Flash::getFlash();
		$oFlash->checkForFileUpload($sFileKey);
		$oFlash->finishReporting();
		if(!Flash::noErrors()) {
			throw new ValidationException();
		}

		$aFileInfo = $_FILES[$sFileKey];

		if($aOptions['document_id']) {
			$oDocument = DocumentQuery::create()->findPk($aOptions['document_id']);
		} else {
			/**
			* @todo ignoreRights should possibly be handled differently, see issue #160 
			*/
			DocumentPeer::ignoreRights(true);
			$oDocument = new Document();
		}
		if($oDocument === null) {
			throw new LocalizedException("wns.file_upload.document_not_found");
		}
		$sFileName = $aOptions['name'];
		$aName = explode('.', $sFileName);
		if(count($aName) > 1) {
			array_pop($aName);
		}
		$sFileName = implode('.', $aName);
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
				if($sExtension === null) {
					throw new LocalizedException("wns.file_upload.unknown_document_type");
				}
				$oDocumentType = new DocumentType();
				$oDocumentType->setExtension($sExtension);
				$oDocumentType->setMimetype(implode('/', $aMimeType));
				$oDocumentType->save();
				$iDocumentTypeId = $oDocumentType->getId();
			} else {
				throw $e;
			}
		}
    $oDocument->setData(fopen($aFileInfo['tmp_name'] , "r"));
		$this->updateDocument($oDocument, $aOptions, $sFileName, $iDocumentTypeId);

		$oDocument->save();
		return $oDocument->getId();
	}
	
	public static function includeResources($oResourceIncluder = null) {
		if($oResourceIncluder == null) {
			$oResourceIncluder = ResourceIncluder::defaultIncluder();
		}
		$oResourceIncluder->addResource('widget/html5-formdata/formdata.js');
		self::includeWidgetResources(false, $oResourceIncluder);
	}

	public function accepts($sFileName, $sMimeType = null) {
		$aName = explode('.', $sFileName);
		$sExtension = null;
		if(count($aName) > 1) {
			$sExtension = array_pop($aName);
		}
		$sFileName = implode('.', $aName);
		$oDocumentType = null;
		if($sMimeType !== null) {
			$oDocumentType = DocumentTypeQuery::findDocumentTypeByMimetype($sMimeType);
		}
		if($oDocumentType === null && $sExtension !== null) {
			$oDocumentType = DocumentTypeQuery::findDocumentTypeByExtension($sExtension);
		}
		if($oDocumentType === null) {
			if($sExtension === null) {
				throw new LocalizedException("wns.file_upload.unknown_document_type", null, 'error');
			}
			if($sMimeType == null) {
				throw new LocalizedException("wns.file_upload.unknown_mimetype", null, 'error');
			}
			throw new LocalizedException("wns.file_upload.document_type_not_found", array('extension' => $sExtension, 'mimetype' => $sMimeType));
		}
		return $oDocumentType->getId();
	}

	public function acceptsURL($sUrl, $bCreateType = false) {
		$sFileName = substr($sUrl, strrpos($sUrl, '/')+1);
		$aName = explode('.', $sFileName);
		$sExtension = null;
		if(count($aName) > 1) {
			$sExtension = array_pop($aName);
		}
		$sFileName = implode('.', $aName);
		$aHeaders = @get_headers($sUrl, true);
		$sMimeType = null;
		$oDocumentType = null;
		if($aHeaders && isset($aHeaders['Content-Type'])) {
			$sMimeType = $aHeaders['Content-Type'];
			$oDocumentType = DocumentTypeQuery::findDocumentTypeByMimetype($sMimeType);
		}
		if($oDocumentType === null && $sExtension !== null) {
			$oDocumentType = DocumentTypePeer::getDocumentTypeByExtension($sExtension);
		}
		if($oDocumentType === null && $bCreateType && $sMimeType && $sExtension) {
			$oDocumentType = new DocumentType();
			$oDocumentType->setExtension($sExtension);
			$oDocumentType->setMimetype($sMimeType);
			$oDocumentType->save();
		}
		if($oDocumentType === null) {
			throw new LocalizedException("wns.file_upload.document_type_not_found", array('extension' => $sExtension, 'mimetype' => $sMimeType));
		}
		return $oDocumentType->getId();
	}

	public function uploadURL($sUrl, $aOptions, $bCreateType) {
		$aOptions['name'] = substr($sUrl, strrpos($sUrl, '/')+1);
		$sFileName = explode('.', $aOptions['name']);
		if(count($sFileName) > 1) {
			$sExtension = array_pop($sFileName);
		}
		$sFileName = implode('.', $sFileName);

		$iDocumentTypeId = $this->acceptsURL($sUrl, $bCreateType);
		$oDocument = null;
		if($aOptions['document_id']) {
			$oDocument = DocumentQuery::create()->findPk($aOptions['document_id']);
		} else {
			/**
			* @todo ignoreRights should possibly be handled differently, see issue #160 
			*/
			DocumentPeer::ignoreRights(true);
			$oDocument = new Document();
		}
		//this needs fopen wrappers enabled
		$oDocument->setData(file_get_contents($sUrl));
		$this->updateDocument($oDocument, $aOptions, $sFileName, $iDocumentTypeId);

		$oDocument->save();
		return $oDocument->getId();
	}

	private function updateDocument($oDocument, &$aOptions, $sFileName, $iDocumentTypeId) {
		$oDocument->setDocumentTypeId($iDocumentTypeId);
		$oDocument->setOriginalName($aOptions['name']);
		if(!$aOptions['deny_name_override'] || !$oDocument->getName()) {
			$oDocument->setName($sFileName);
		}

		if($oDocument->isNew()) {
			$oDocument->setLanguageId($aOptions['language_id']);
			$oDocument->setIsProtected($aOptions['is_protected']);
			if($aOptions['document_category_id']) {
				$oDocument->setDocumentCategoryId($aOptions['document_category_id']);
				$oDocument->setSort(DocumentQuery::create()->filterByDocumentCategoryId($oDocument->getDocumentCategoryId())->count() + 1);
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
	}

}
