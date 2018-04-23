<?php
/**
 * @package modules.admin
 */
class DocumentsAdminModule extends AdminModule {

	private $oListWidget;
	private $oSidebarWidget;
	private $oInputWidget;

	public function __construct() {
		$this->oListWidget = new DocumentListWidgetModule();
		$this->oListWidget->addPaging();
		if(isset($_REQUEST['document_category_id'])) {
			$this->oListWidget->setDocumentCategoryId($_REQUEST['document_category_id']);
		}

		$this->oInputWidget = new SidebarInputWidgetModule();
		$this->oSidebarWidget = new ListWidgetModule();
		$this->oSidebarWidget->setSetting('hash_key', 'document_category_id');
		$this->oSidebarWidget->setListTag(new TagWriter('ul'));
		$this->oSidebarWidget->setDelegate(new CriteriaListWidgetDelegate($this, 'DocumentCategory', 'name'));
		$this->oSidebarWidget->setSetting('initial_selection', array('document_category_id' => $this->oListWidget->getDocumentCategoryId()));
	}

	public static function getPrincipalModel() {
		return 'Document';
	}

	public function mainContent() {
		return $this->oListWidget->doWidget();
	}

	public function sidebarContent() {
		return $this->oSidebarWidget->doWidget();
	}

	public function getColumnIdentifiers() {
		return array('document_category_id', 'name_with_externally_managed_state', 'magic_column');
	}

	public function getMetadataForColumn($sColumnIdentifier) {
		$aResult = array();
		switch($sColumnIdentifier) {
			case 'name_with_externally_managed_state':
				$aResult['heading'] = TranslationPeer::getString('wns.documents.sidebar_heading');
				break;
			case 'document_category_id':
				$aResult['display_type'] = ListWidgetModule::DISPLAY_TYPE_DATA;
				$aResult['field_name'] = 'id';
				break;
			case 'magic_column':
				$aResult['display_type'] = ListWidgetModule::DISPLAY_TYPE_CLASSNAME;
				$aResult['has_data'] = false;
				break;
		}
		return $aResult;
	}

	public function getDatabaseColumnForColumn($sColumnIdentifier) {
		if($sColumnIdentifier === 'name_with_externally_managed_state') {
			return DocumentCategoryPeer::NAME;
		}
		return null;
	}

	public function getCustomListElements() {
		if($this->getCriteria()->count() > 0) {
			return array(
				array('document_category_id' => CriteriaListWidgetDelegate::SELECT_ALL,
							'name_with_externally_managed_state' => TranslationPeer::getString('wns.documents.select_all_title'),
							'magic_column' => 'all'),
				array('document_category_id' => CriteriaListWidgetDelegate::SELECT_WITHOUT,
							'name_with_externally_managed_state' => TranslationPeer::getString('wns.documents.select_without_title'),
							'magic_column' => 'without'));
		}
		return array();
	}

	public function usedWidgets() {
		return array($this->oListWidget, $this->oSidebarWidget, $this->oInputWidget);
	}

	public function getCriteria() {
		$oQuery = DocumentCategoryQuery::create();
		if(!Session::getSession()->getUser()->getIsAdmin() || Settings::getSetting('admin', 'hide_externally_managed_document_categories', true)) {
			return $oQuery->filterByIsExternallyManaged('false');
		}
		return $oQuery;
	}

}
