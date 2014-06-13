<?php
/**
 * @package modules.widget
 */
class DocumentListWidgetModule extends PersistentWidgetModule {

	private $oListWidget;
	public $oDocumentsViewWidgetDelegate;
	private $oLanguageFilter;
	
	public function __construct($sSessionKey = null, $oDocumentsViewWidgetDelegate = null) {
		parent::__construct($sSessionKey);
		$this->oListWidget = new ListWidgetModule();
		if($oDocumentsViewWidgetDelegate === null) {
			$oDocumentsViewWidgetDelegate = new DocumentsViewWidgetDelegate();
		}
		$this->oDocumentsViewWidgetDelegate = $oDocumentsViewWidgetDelegate;
		$this->oListWidget->setDelegate($this->oDocumentsViewWidgetDelegate->getDelegateProxy());
		$this->oListWidget->setSetting('row_model_drag_and_drop_identifier', 'id');
	}

	public function doWidget() {
		return $this->oListWidget->doWidget('document_list');
	}
	
	public function setDocumentKind($sDocumentKind) {
		return $this->oDocumentsViewWidgetDelegate->setDocumentKind($sDocumentKind);
	}

	public function getDocumentKind() {
		return $this->oDocumentsViewWidgetDelegate->getDocumentKind();
	}
	
	public function setDocumentCategoryId($iDocumentCategoryId = null) {
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
