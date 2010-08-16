<?php

class DocumentsViewWidgetModule extends PersistentWidgetModule {
	private $iInitialDocumentCategoryId;
	private $sInitialSearchString;
	private $sInitialDocumentKind;
	private $iInitialThumbnailSize;
	
	public function __construct() {
		$this->iInitialDocumentCategoryId = CriteriaListWidgetDelegate::SELECT_ALL;
		$this->sInitialSearchString = null;
		$this->sInitialDocumentKind = CriteriaListWidgetDelegate::SELECT_ALL;
		$this->iInitialThumbnailSize = 80;
	}
	
	public function setInitialDocumentCategoryId($iInitialDocumentCategoryId) {
	    $this->iInitialDocumentCategoryId = $iInitialDocumentCategoryId;
	}

	public function getInitialDocumentCategoryId() {
	    return $this->iInitialDocumentCategoryId;
	}
	
	public function setInitialSearchString($sInitialSearchString) {
	    $this->sInitialSearchString = $sInitialSearchString;
	}

	public function getInitialSearchString() {
	    return $this->sInitialSearchString;
	}
	
	public function setInitialDocumentKind($sInitialDocumentKind) {
	    $this->sInitialDocumentKind = $sInitialDocumentKind;
	}

	public function getInitialDocumentKind() {
	    return $this->sInitialDocumentKind;
	}
	
	public function setInitialThumbnailSize($iInitialThumbnailSize) {
	    $this->iInitialThumbnailSize = $iInitialThumbnailSize;
	}

	public function getInitialThumbnailSize() {
	    return $this->iInitialThumbnailSize;
	}
}