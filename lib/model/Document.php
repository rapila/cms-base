<?php

require_once 'model/om/BaseDocument.php';


/**
 * @package model
 */ 
class Document extends BaseDocument {
	
	private static $DOCUMENT_CATEGORIES = array();
	
	private $iDataSize = null;
	
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
	
	public function getFullName() {
		return $this->getName().'.'.$this->getExtension();
	}
	
	public function isImage() {
		return $this->getDocumentType()->isImageType();
	}
	
	public function getDisplayUrl($aUrlParameters = array(), $sFileModule = 'display_document') {
		return LinkUtil::link(array($sFileModule, $this->getId()), "FileManager", $aUrlParameters);
	}
	
	public function shouldBeIncludedInList($sLanguageId, $oPage) {
		return $this->getLanguageId() === null || $this->getLanguageId() === $sLanguageId;
	}
	
	public function renderListItem($oTemplate) {
		$oTemplate->replaceIdentifier('name', $this->getName());
		$oTemplate->replaceIdentifier('link_text', $this->getName());
		$oTemplate->replaceIdentifier('title', $this->getName());
		$oTemplate->replaceIdentifier('description', $this->getDescription());
		$oTemplate->replaceIdentifier('extension', $this->getExtension());
		$oTemplate->replaceIdentifier('mimetype', $this->getMimetype());
		$oTemplate->replaceIdentifier('url', $this->getDisplayUrl());
		$oTemplate->replaceIdentifier('document_category_id', $this->getDocumentCategoryId());
		$oTemplate->replaceIdentifier('category_id', $this->getDocumentCategoryId());
		$oTemplate->replaceIdentifier('document_category', $this->getCategoryName());
		$oTemplate->replaceIdentifier('category', $this->getCategoryName());
		$oTemplate->replaceIdentifier("size", DocumentUtil::getDocumentSize($this->getDataSize(), 'kb'));
	}
	
	public function getCategoryName() {
		if($this->getDocumentCategory()) {
			return $this->getDocumentCategory()->getName();
		}
		return null;
	}
	
	public function getDataSize(PropelPDO $oConnection = null) {
		if($this->iDataSize === null) {
			$oCriteria = $this->buildPkeyCriteria();
			$oCriteria->addSelectColumn('OCTET_LENGTH(data)');
			$rs = DocumentPeer::doSelectStmt($oCriteria, $oConnection);
			$this->iDataSize = (int)$rs->fetchColumn(0);
		}
		return $this->iDataSize;
	}

	public function getFileInfo($sFilesizeFormat = 'auto_iso') {
		return DocumentUtil::getDocumentSize($this->getDataSize(), $sFilesizeFormat).' | '.$this->getExtension();
	}
	
	/**
	* Shortcut for getDisplayUrl(array(), 'display_document');
	* @deprecated use Document->getDisplayUrl() instead
	* @todo remove
	*/
	public function getLink() {
		return $this->getDisplayUrl(array(), 'display_document');
	}
	
	public function getDocumentCategory(PropelPDO $con = null) {
		if(!isset(self::$DOCUMENT_CATEGORIES[$this->getDocumentCategoryId()])) {
			self::$DOCUMENT_CATEGORIES[$this->getDocumentCategoryId()] = parent::getDocumentCategory($con);
		}
		return self::$DOCUMENT_CATEGORIES[$this->getDocumentCategoryId()];
	}
	
	public function setDocumentCategoryId($mCategoryId) {
		parent::setDocumentCategoryId(is_numeric($mCategoryId) && $mCategoryId > 0 ? $mCategoryId : null);
	}
}