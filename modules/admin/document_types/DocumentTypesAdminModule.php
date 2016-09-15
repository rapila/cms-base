<?php
/**
 * @package modules.admin
 */
class DocumentTypesAdminModule extends AdminModule implements ListWidgetDelegate {

	private $oListWidget;
	private $oSidebarWidget;
	private static $aDOCUMENT_KINDS;

	public function __construct() {
		$this->oListWidget = new DocumentTypeListWidgetModule();
		if(isset($_REQUEST['document_kind'])) {
			$this->oListWidget->oDelegateProxy->setDocumentKind($_REQUEST['document_kind']);
		}
		$this->oSidebarWidget = new ListWidgetModule();
		$this->oSidebarWidget->setListTag(new TagWriter('ul'));
		$this->oSidebarWidget->setDelegate($this);
		$this->oSidebarWidget->setSetting('initial_selection', array('document_kind' => $this->oListWidget->oDelegateProxy->getDocumentKind()));
	}

	public function mainContent() {
		return $this->oListWidget->doWidget();
	}

	public function sidebarContent() {
		return $this->oSidebarWidget->doWidget();
	}

	public function numberOfRows() {
		return count(DocumentKindInputWidgetModule::getDocumentKindsAssoc());
	}

	public function getColumnIdentifiers() {
		return array('document_kind', 'title', 'magic_column');
	}

	public function getMetadataForColumn($sColumnIdentifier) {
		$aResult = array();
		switch($sColumnIdentifier) {
			case 'document_kind':
				$aResult['display_type'] = ListWidgetModule::DISPLAY_TYPE_DATA;
				break;
			case 'title':
				$aResult['heading'] = TranslationPeer::getString('wns.document_types.sidebar_heading');
				$aResult['field_name'] = 'name';
				break;
			case 'magic_column':
				$aResult['display_type'] = ListWidgetModule::DISPLAY_TYPE_CLASSNAME;
				$aResult['has_data'] = false;
				break;
			}
		return $aResult;
	}

	public static function getCustomListElements() {
		if(count(self::getDocumentKinds()) > 0) {
		 	return array(
				array('document_kind' => CriteriaListWidgetDelegate::SELECT_ALL,
							'title' => TranslationPeer::getString('wns.documents.select_all_title'),
							'magic_column' => 'all')
			);
		}
		return array();
	}

	private static function getDocumentKinds() {
		if(self::$aDOCUMENT_KINDS === null) {
			self::$aDOCUMENT_KINDS = DocumentKindInputWidgetModule::getDocumentKindsAssoc();
			asort(self::$aDOCUMENT_KINDS);
		}
		return self::$aDOCUMENT_KINDS;
	}

	public function getListContents($iRowStart = 0, $iRowCount = NULL) {
		$aResult = array();
		foreach(self::getDocumentKinds() as $sDocumentKind => $sDocumentKindName) {
			$aResult[] = array('document_kind' => $sDocumentKind, 'title' => $sDocumentKindName);
		}
		return array_merge(self::getCustomListElements(), $aResult);
	}

	public function usedWidgets() {
		return array($this->oListWidget, $this->oSidebarWidget);
	}
}
