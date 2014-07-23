<?php
/**
 * @package modules.widget
 */
class DocumentListWidgetModule extends SpecializedListWidgetModule {

	public $oDocumentsViewWidgetDelegate;

	protected function createListWidget() {
		$this->oDocumentsViewWidgetDelegate = new DocumentsViewWidgetDelegate();
		$oListWidget = new ListWidgetModule();
		$oListWidget->setDelegate($this->oDocumentsViewWidgetDelegate->getDelegateProxy());
		$oListWidget->setSetting('row_model_drag_and_drop_identifier', 'id');
		return $oListWidget;
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
