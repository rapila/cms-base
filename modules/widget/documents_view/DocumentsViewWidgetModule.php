<?php
/**
* @package modules.widget
* 
* 
*/
class DocumentsViewWidgetModule extends PersistentWidgetModule {

	private $aViewSessions;

	public $oDocumentsViewWidgetDelegate;

	public function __construct() {
		parent::__construct();
		$this->oDocumentsViewWidgetDelegate = new DocumentsViewWidgetDelegate();
		$aViewSessions = array();
		$this->setDocumentKind(CriteriaListWidgetDelegate::SELECT_ALL);
		$this->setDocumentCategoryId(CriteriaListWidgetDelegate::SELECT_ALL);
		$this->setSearch(null);
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

	public function getSessionForView($sViewType) {
		if(!isset($aViewSessions[$sViewType])) {
			$oWidget = WidgetModule::getWidget($sViewType, null, $this->oDocumentsViewWidgetDelegate);
			$aViewSessions[$sViewType] = $oWidget->getSessionKey();
		}
		return $aViewSessions[$sViewType];
	}
}