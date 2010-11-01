<?php
/**
* @package modules.widget
*/
class DocumentsViewWidgetModule extends PersistentWidgetModule {
	private $iInitialDocumentCategoryId;
	private $sInitialSearchString;
	private $sInitialDocumentKind;
	private $iInitialThumbnailSize;
	private $aViewSessions;
	
	public $oDocumentsViewWidgetDelegate;
	
	public function __construct() {
		parent::__construct();
		$this->iInitialDocumentCategoryId = CriteriaListWidgetDelegate::SELECT_ALL;
		$this->sInitialSearchString = null;
		$this->sInitialDocumentKind = CriteriaListWidgetDelegate::SELECT_ALL;
		$this->iInitialThumbnailSize = 160;
		$this->oDocumentsViewWidgetDelegate = new DocumentsViewWidgetDelegate();
		$aViewSessions = array();
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
	
	public function getSessionForView($sViewType) {
		if(!isset($aViewSessions[$sViewType])) {
			$oWidget = WidgetModule::getWidget($sViewType, null, $this->oDocumentsViewWidgetDelegate);
			$aViewSessions[$sViewType] = $oWidget->getSessionKey();
		}
		return $aViewSessions[$sViewType];
	}
}