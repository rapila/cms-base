<?php

require_once 'model/om/BaseDocument.php';


/**
 * @package model
 */
class Document extends BaseDocument {

	private static $DOCUMENT_CATEGORIES = array();

	public function getMimetype() {
		return $this->getDocumentType()->getMimetype();
	}

	public function getExtension() {
		return $this->getDocumentType()->getExtension();
	}

	public function getDocumentKind() {
		return $this->getDocumentType()->getDocumentKind();
	}

	public function getNameAndExtension() {
		return $this->getName().' ['.$this->getExtension().']';
	}

	public function getNameTruncated() {
		return StringUtil::truncate($this->getName(), 50);
	}

	public function getFullName() {
		return $this->getName().'.'.$this->getExtension();
	}

	public function isImage() {
		return $this->getDocumentType()->isImageType();
	}

	public function isGDImage() {
		return $this->getDocumentType()->isGDImageType();
	}

	public function getDisplayUrl($aUrlParameters = array(), $sFileModule = 'display_document') {
		$iId = $this->getId();
		if($sFileModule === 'display_document') {
			$iId .= '.'.$this->getDocumentType()->getExtension();
		}
		return LinkUtil::link(array($sFileModule, $iId), "FileManager", $aUrlParameters);
	}

	public function shouldBeIncludedInList($sLanguageId, $oPage) {
		return $this->getLanguageId() === null || $this->getLanguageId() === $sLanguageId;
	}

	public function renderListItem($oTemplate, $aUrlParams = array()) {
		$oTemplate->replaceIdentifier('id', $this->getId());
		$oTemplate->replaceIdentifier('name', $this->getName());
		$oTemplate->replaceIdentifier('link_text', $this->getName());
		$oTemplate->replaceIdentifier('title', $this->getName());
		$oTemplate->replaceIdentifier('description', $this->getDescription());
		$oTemplate->replaceIdentifier('extension', $this->getExtension());
		$oTemplate->replaceIdentifier('mimetype', $this->getMimetype());
		$oTemplate->replaceIdentifier('url', $this->getDisplayUrl($aUrlParams));
		$oTemplate->replaceIdentifier('document_category_id', $this->getDocumentCategoryId());
		$oTemplate->replaceIdentifier('category_id', $this->getDocumentCategoryId());
		$oTemplate->replaceIdentifier('document_category', $this->getCategoryName());
		$oTemplate->replaceIdentifier('category', $this->getCategoryName());
		$oTemplate->replaceIdentifier('license', $this->getLicense());
		$oTemplate->replaceIdentifier('license_url', $this->getLicenseUrl());
		$oTemplate->replaceIdentifier('license_image', $this->getLicenseImageUrl());
		$oTemplate->replaceIdentifier('license_disclaimer', $this->getLicenseDisclaimer());
		$oTemplate->replaceIdentifier('document_type', $this->getMimetype());
		$oTemplate->replaceIdentifier('document_kind', $this->getDocumentKind());
		if($oTemplate->hasIdentifier('size')) {
			$oTemplate->replaceIdentifier("size", DocumentPeer::getDocumentSize($this->getDataSize(), 'auto_iso'));
		}
		if($this->isGDImage() && $oTemplate->hasIdentifier('dimension', Template::$ANY_VALUE)) {
			$oImage = $this->getImage();
			$oTemplate->replaceIdentifier('dimension', $oImage->getOriginalWidth(), 'width');
			$oTemplate->replaceIdentifier('dimension', $oImage->getOriginalHeight(), 'height');
			$oImage->destroy();
		}
		$oDocument = $this;
		$oTemplate->replaceIdentifierCallback("preview", function($oTemplateIdentifier, &$iFlags) use ($oDocument) {
			$iSize = 190;
			if($oTemplateIdentifier->getValue()) {
				$iSize = $oTemplateIdentifier->getValue();
			}
			return $oDocument->getPreview($iSize, false, true);
		});
	}

	public function getCategoryName() {
		if($this->getDocumentCategory()) {
			return $this->getDocumentCategory()->getName();
		}
		return null;
	}

	public function getPreview($iSize = 190, $bRefresh = true, $bMayReturnTemplate = false) {
		$aOptions = array();
		$aOptions['document_id'] = $this->getId();
		if($this->getDocumentType()->getDocumentKind() === 'image') {
			// Objects don’t get displayed otherwise
			$aOptions['max_width'] = $iSize;
			$aOptions['max_height'] = $iSize;
			$aOptions['force_refresh'] = $bRefresh;
		} else {
			$aOptions['width'] = $iSize;
			$aOptions['height'] = $iSize*0.747;
		}

		$aFallback = $aOptions;
		$aFallback['document_id'] = '';
		$aFallback['height'] = $iSize;
		$aFallback['url'] = LinkUtil::link(array('document_type_preview', $this->getDocumentTypeId()), 'FileManager', array('size' => $iSize));

		$oModule = FrontendModule::getModuleInstance('media_object', serialize(array($aOptions, $aFallback)));
		$oResult = $oModule->renderFrontend();
		if($bMayReturnTemplate) {
			return $oResult;
		}
		return $oResult->render();
	}

	public function getImage() {
		return Image::imageFromStream($this->getData());
	}

	public function getDimensionsIfImage($sPostfix = "px") {
		if(!$this->isGDImage()) {
			return null;
		}
		try {
			$oImage = $this->getImage();
			if($oImage && $oImage->getOriginalHeight()) {
				$aResult = array();
				$aResult[] = $oImage->getOriginalWidth();
				$aResult[] = $oImage->getOriginalHeight();
				return implode('x', $aResult).$sPostfix;
			}
		} catch(Exception $ex) {} //Ignore unrecognized image format

		return null;
	}

	public function getData(PropelPDO $oConnection = null) {
		return $this->getDocumentData()->getData($oConnection);
	}

	public function setData($mData) {
		if(is_resource($mData)) {
			$mData = stream_get_contents($mData);
		}
		$sHash = sha1($mData);
		$sPreviousHash = $this->getHash();
		if($sHash === $sPreviousHash) {
			return;
		}
		$oOldDocumentData = $this->getDocumentData();
		if($oOldDocumentData && $oOldDocumentData->countDocuments() <= 1) {
			// Only remaining document is the one to be updated
			$oOldDocumentData->delete();
		}
		$oDocumentData = DocumentDataQuery::create()->findPk($sHash);
		if($oDocumentData === null) {
			$oDocumentData = new DocumentData();
			$oDocumentData->setHash($sHash);
			$oDocumentData->setDataSize(strlen($mData));
			$oDocumentData->setData($mData);
		}
		$this->setDocumentData($oDocumentData);
		return $this;
	}

	public function getDataSize() {
		return $this->getDocumentData()->getDataSize();
	}

	public function getFileSize($sFilesizeFormat = 'auto_iso') {
		return DocumentPeer::getDocumentSize($this->getDataSize(), $sFilesizeFormat);
	}

	public function getFileInfo($sFilesizeFormat = 'auto_iso') {
		$this->getFileSize($sFilesizeFormat).' | '.$this->getExtension();
	}

	/**
	* Shortcut for getDisplayUrl(array(), 'display_document');
	* @deprecated use Document->getDisplayUrl() instead
	* @todo remove
	*/
	public function getLink() {
		return $this->getDisplayUrl(array(), 'display_document');
	}

	public function getLicenseInfo() {
		$sLicense = $this->getLicense();
		if($sLicense === null) {
			$sLicense = 'NULL';
		}
		if(!isset(DocumentPeer::$LICENSES[$sLicense])) {
			return array();
		}
		return DocumentPeer::$LICENSES[$sLicense];
	}

	public function getLicenseUrl() {
		$aInfo = $this->getLicenseInfo();
		if(!isset($aInfo['url'])) {
			return null;
		}
		return $aInfo['url'];
	}

	public function getLicenseImageUrl() {
		$aInfo = $this->getLicenseInfo();
		if(!isset($aInfo['image'])) {
			return null;
		}
		return LinkUtil::link(array('license_image', $this->getLicense()), 'FileManager');
	}

	public function getLicenseDisclaimer() {
		$aInfo = $this->getLicenseInfo();
		$sDisclaimer = 'some';
		if(isset($aInfo['disclaimer'])) {
			$sDisclaimer = $aInfo['disclaimer'];
		}
		$sUser = $this->getAuthor();
		if($sUser === null) {
			$sUser = $this->getUserRelatedByCreatedBy();
			if($sUser) {
				$sUser = $sUser->getFullName();
			}
		}
		if($sUser === null) {
			$sUser = $this->getUserRelatedByUpdatedBy();
			if($sUser) {
				$sUser = $sUser->getFullName();
			}
		}
		$iYear = $this->getContentCreatedAt('Y');
		if($iYear === null) {
			$iYear = $this->getCreatedAt('Y');
		}
		$aOptions = array(
			'author' => $sUser,
			'year' => $iYear,
			'license' => $this->getLicense()
		);
		return StringPeer::getString("wns.license.disclaimer.$sDisclaimer", null, null, $aOptions);
	}

	public function getDocumentCategory(PropelPDO $con = null, $doQuery = true) {
		if($this->aDocumentCategory === null && !$doQuery) {
			return null;
		}
		if(!isset(self::$DOCUMENT_CATEGORIES[$this->getDocumentCategoryId()])) {
			self::$DOCUMENT_CATEGORIES[$this->getDocumentCategoryId()] = parent::getDocumentCategory($con, true);
		}
		return self::$DOCUMENT_CATEGORIES[$this->getDocumentCategoryId()];
	}

	public function isInternallyManaged() {
		if($this->getDocumentCategory() === null) {
			return false;
		}
		return !$this->getDocumentCategory()->getIsExternallyManaged();
	}

	public function hasTags() {
		return $this->getHasTags();
	}

	public function getHasTags() {
		return TagQuery::create()->filterByTagged($this)->count() > 0;
	}

	public function hasReferees() {
		return count($this->getReferees()) > 0;
	}
}
