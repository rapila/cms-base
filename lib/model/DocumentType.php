<?php

require_once 'model/om/BaseDocumentType.php';

/**
 * @package model
 */ 
class DocumentType extends BaseDocumentType {
	public function isImageType($sType = '') {
		return StringUtil::startsWith($this->getMimetype(), "image/$sType");
	}
	
	/**
	* Return true if the document is an image and is supported by the installed GD lib.
	*/
	public function isGDImageType() {
		if(!$this->isImageType()) {
			return false;
		}
		$sType = $this->getDocumentKindDetail();
		$iTypes = imagetypes();
		if($sType === 'vnd.wap.wbmp') {
			return ($iTypes & IMG_WBMP) === IMG_WBMP;
		}
		if($sType === 'x-xpixmap' || $sType === 'image/x-xpm') {
			return ($iTypes & IMG_XMP) === IMG_XMP;
		}
		$sType = strtoupper("IMG_$sType");
		if(defined($sType)) {
			$iTypeVal = constant($sType);
			return ($iTypes & $iTypeVal) === $iTypeVal;
		}
		return false;
	}
	
	public function getDocumentKind() {
		$aResult = explode('/', $this->getMimeType());
		return $aResult[0];
	}
	
	public function getDocumentKindDetail() {
		$aResult = explode('/', $this->getMimeType());
		return $aResult[1];
	}

	public function getDocumentCount() {
		if($this->countDocuments() !== 0) {
			return $this->countDocuments();
		}
		return '-';
	}
	
	public function setExtension($sExtension) {
		return parent::setExtension(strtolower($sExtension));
	}
	
}

