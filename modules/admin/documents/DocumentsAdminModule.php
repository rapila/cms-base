<?php
/**
 * @package modules.admin
 */
class DocumentsAdminModule extends AdminModule {

	private $oListWidget;
	private $oSidebarWidget;
	private $oInputWidget;

	public function __construct() {
		$this->oListWidget = new DocumentsViewWidgetModule();
		$this->oInputWidget = new SidebarInputWidgetModule();
		$this->oSidebarWidget = new ListWidgetModule();
		$this->oSidebarWidget->setListTag(new TagWriter('ul'));
		$this->oSidebarWidget->setDelegate(new CriteriaListWidgetDelegate($this, 'DocumentCategory', 'name'));
		if(isset($_REQUEST['document_category_id'])) {
			$this->oListWidget->setDocumentCategoryId($_REQUEST['document_category_id']);
		}
		$this->addResourceParameter(ResourceIncluder::RESOURCE_TYPE_JS, 'document_category_id', $this->oListWidget->getDocumentCategoryId());
	}
	
	public function mainContent() {
		return $this->oListWidget->doWidget();
	}
		
	public function sidebarContent() {
		return $this->oSidebarWidget->doWidget();
	}
	
	public function getColumnIdentifiers() {
		return array('document_category_id', 'title', 'magic_column');
	}
	
	public function getMetadataForColumn($sColumnIdentifier) {
		$aResult = array();
		switch($sColumnIdentifier) {
			case 'title':
				$aResult['heading'] = StringPeer::getString('wns.documents.sidebar_heading');
				$aResult['field_name'] = 'name';
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
	
	public function getCustomListElements() {
		if(DocumentCategoryPeer::doCount(new Criteria()) > 0) {
		 	return array(
				array('document_category_id' => CriteriaListWidgetDelegate::SELECT_ALL,
							'title' => StringPeer::getString('wns.documents.select_all_title'),
							'magic_column' => 'all'),
				array('document_category_id' => CriteriaListWidgetDelegate::SELECT_WITHOUT,
							'title' => StringPeer::getString('wns.documents.select_without_title'),
							'magic_column' => 'without'));
		}
		return array();
	}
	
	public function usedWidgets() {
		return array($this->oListWidget, $this->oSidebarWidget, $this->oInputWidget);
	}
}
