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
	
	public function delete($con = null) {
		if(ReferencePeer::hasReference($this)) {
			throw new Exception("Exception in ".__METHOD__.": tried removing an instance from the database even though it is still referenced.");
		}
		TagPeer::deleteTagsForObject($this);
		ReferencePeer::removeReferences($this);
		return parent::delete($con);
	}
	
	public function isImage() {
		return $this->getDocumentType()->isImageType();
	}
	
	public function getDisplayUrl($aUrlParameters = array(), $sFileModule = 'display_document') {
		return LinkUtil::link(array($sFileModule, $this->getId()), "FileManager", $aUrlParameters);
	}
	
	public function getCategoryName() {
		if($this->getDocumentCategory()) {
			return $this->getDocumentCategory()->getName();
		}
		return null;
	}
	
	public function getDataSize($oConnection = null) {
		if($this->iDataSize !== null) {
			return $this->iDataSize;
		}
		$oCriteria = $this->buildPkeyCriteria();
		$oCriteria->addSelectColumn('OCTET_LENGTH(data)');
		try {
			$rs = DocumentPeer::doSelectRS($oCriteria, $oConnection);
			$rs->next();
			return $this->iDataSize = $rs->getInt(1);
		} catch (Exception $e) {
			throw new PropelException("Error loading value for [size] column on demand.", $e);
		}
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
	
	public function save($oConnection = null) {
		if(Session::getSession()->isAuthenticated()) {
			$this->setUpdatedBy(Session::getSession()->getUserId());
		}
		$this->setUpdatedAt(date('c'));

		if($this->isNew()) {
			if(Session::getSession()->isAuthenticated()) {
				$this->setCreatedBy(Session::getSession()->getUserId());
			}
			$this->setCreatedAt(date('c'));
		}
		return parent::save($oConnection);
	}
	
	public function getDocumentCategory($con=null) {
		if(!isset(self::$DOCUMENT_CATEGORIES[$this->getDocumentCategoryId()])) {
			self::$DOCUMENT_CATEGORIES[$this->getDocumentCategoryId()] = parent::getDocumentCategory($con);
		}
		return self::$DOCUMENT_CATEGORIES[$this->getDocumentCategoryId()];
	}
	
	public function setDocumentCategoryId($mCategoryId) {
		parent::setDocumentCategoryId(is_numeric($mCategoryId) && $mCategoryId > 0 ? $mCategoryId : null);
	}
	
	public function getUpdatedAtFormatted() {
		return LocaleUtil::localizeDate($this->getUpdatedAt('c'));
	}

} // Document
