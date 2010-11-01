<?php
/**
 * @package modules.widget
 */
class DocumentThumbnailViewWidgetModule extends PersistentWidgetModule {
	
	private $bInitialAllowsMultiselect = false;
	
	public $oDocumentsViewWidgetDelegate;
	
	public function __construct($sSessionKey = null, $oDocumentsViewWidgetDelegate = null) {
		parent::__construct($sSessionKey);
		if($oDocumentsViewWidgetDelegate === null) {
			$oDocumentsViewWidgetDelegate = new DocumentsViewWidgetDelegate();
		}
		$this->oDocumentsViewWidgetDelegate = $oDocumentsViewWidgetDelegate;
	}
	
	public function listDocuments($iThumbnailSize) {
		$aResults = array();
		foreach($this->oDocumentsViewWidgetDelegate->getDelegateProxy()->getListContents() as $oDocument) {
			$aResults[] = $this->rowData($oDocument, $iThumbnailSize);
		}
		return $aResults;
	}
	
	private function rowData($oDocument, $iThumbnailSize) {
		return array('name' => $oDocument->getName(), 'description' => $oDocument->getDescription(), 'id' => $oDocument->getId(), 'preview' => $this->thumbnail($oDocument->getId(), $iThumbnailSize));
	}
	
	public function singleDocument($iDocumentId, $iThumbnailSize) {
		return $this->rowData($this->oDocumentsViewWidgetDelegate->getDelegateProxy()->rowFromData(array('id' => $iDocumentId)));
	}
	
	public function thumbnail($iDocumentId, $iThumbnailSize) {
		return DocumentDetailWidgetModule::documentPreview($iDocumentId, $iThumbnailSize);
	}
		
	public function setInitialAllowsMultiselect($bInitialAllowsMultiselect) {
		$this->bInitialAllowsMultiselect = $bInitialAllowsMultiselect;
	}

	public function getInitialAllowsMultiselect() {
		return $this->bInitialAllowsMultiselect;
	}
		
	public function getElementType() {
		return 'div';
	}
	
	public function setDocumentKind($sDocumentKind) {
		return $this->oDocumentsViewWidgetDelegate->setDocumentKind($sDocumentKind);
	}

	public function getDocumentKind() {
		return $this->oDocumentsViewWidgetDelegate->getDocumentKind();
	}
	
	public function setDocumentCategoryId($iDocumentCategoryId) {
		return $this->oDocumentsViewWidgetDelegate->setDocumentCategoryId($iDocumentCategoryId);
	}

	public function getDocumentCategoryId() {
		return $this->oDocumentsViewWidgetDelegate->getDocumentCategoryId();
	}
	
	public function setSearch($sSearch) {
		return $this->oDocumentsViewWidgetDelegate->setSearch($sSearch);
	}

	public function getSearch() {
		return $this->oDocumentsViewWidgetDelegate->getSearch();
	}
}