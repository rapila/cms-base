<?php

require_once 'model/om/BaseDocumentType.php';

/**
 * @package model
 */ 
class DocumentType extends BaseDocumentType {
	public function isImageType($sType = '') {
		return StringUtil::startsWith($this->getMimetype(), "image/$sType");
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

