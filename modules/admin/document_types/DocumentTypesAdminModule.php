<?php
/**
 * @package modules.admin
 */
class DocumentTypesAdminModule extends AdminModule {
	
	private $oListWidget;
	private $oSideBarWidget;
	
	public function __construct() {
		$this->oListWidget = new DocumentTypeListWidgetModule();
		$this->oSideBarWidget = new ListWidgetModule();
		$this->oSideBarWidget->setDelegate($this);
	}
	
	public function mainContent() {
		return $this->oListWidget->doWidget();
	}
	
	public function sidebarContent() {
		return $this->oSideBarWidget->doWidget();
	}
	
	public function numberOfRows() {
		return count(DocumentTypePeer::getDocumentKindsAssoc());
	}

	public function getColumnIdentifiers() {
		return array('document_kind', 'title');
	}
	
	public function getMetadataForColumn($sColumnIdentifier) {
		$aResult = array();
		switch($sColumnIdentifier) {
			case 'document_kind':
				$aResult['display_type'] = ListWidgetModule::DISPLAY_TYPE_DATA;
				break;
			case 'title':
				$aResult['display_heading'] = false;
				break;
		}
		return $aResult;
	}
	
	public static function getListContents() {
		$aResult = array();
		$aDocumentKinds = DocumentTypePeer::getDocumentKindsAssoc();
		asort($aDocumentKinds);
		foreach($aDocumentKinds as $sDocumentKind => $sDocumentKindName) {
			$aResult[] = array('document_kind' => $sDocumentKind, 'title' => $sDocumentKindName);
		}
		return $aResult;
	}

	public function usedWidgets() {
		return array($this->oListWidget, $this->oSideBarWidget);
	}
}
