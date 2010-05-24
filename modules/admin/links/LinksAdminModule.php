<?php
/**
 * @package modules.admin
 */
class LinksAdminModule extends AdminModule {

	private $oListWidget;
	private $oSidebarWidget;
	private $oInputWidget;
	
	public function __construct() {
		$this->oListWidget = new LinkListWidgetModule();
		if(isset($_REQUEST['link_category_id'])) {
			$this->oListWidget->setLinkCategoryId($_REQUEST['link_category_id']);
			$this->addResourceParameter(ResourceIncluder::RESOURCE_TYPE_JS, 'link_category_id', $_REQUEST['link_category_id']);
		}
		$this->oSidebarWidget = new ListWidgetModule();
		if(!is_numeric($this->oListWidget->getLinkCategoryId())) {
			$this->addResourceParameter(ResourceIncluder::RESOURCE_TYPE_JS, 'link_category_id', $this->oListWidget->getLinkCategoryId());
		}
		$this->oSidebarWidget->setDelegate(new CriteriaListWidgetDelegate($this, 'LinkCategory', 'name'));
		$this->oInputWidget = new SidebarInputWidgetModule();
	}
	
	public function mainContent() {
		return $this->oListWidget->doWidget();
	}
	
	public function sidebarContent() {
		return $this->oSidebarWidget->doWidget();
	}
	
	public function getColumnIdentifiers() {
		return array('link_category_id', 'title', 'magic_column');
	}
	
	public function getMetadataForColumn($sColumnIdentifier) {
		$aResult = array();
		switch($sColumnIdentifier) {
			case 'title':
				$aResult['heading'] = StringPeer::getString('links.sidebar_heading');
				$aResult['field_name'] = 'name';
				break;
			case 'link_category_id':
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
		if(LinkPeer::doCount($this->oListWidget->oDelegateProxy->getCriteria(true)) > 0) {
			return array(
				array('id' => CriteriaListWidgetDelegate::SELECT_ALL,
							'title' => StringPeer::getString('links.select_all_title'),
							'magic_column' => 'all'),
				array('link_category_id' => CriteriaListWidgetDelegate::SELECT_WITHOUT,
							'title' => StringPeer::getString('links.select_without_title'),
							'magic_column' => 'without'));
		}
		return array();
	}

	public function usedWidgets() {
		return array($this->oListWidget, $this->oListWidget, $this->oInputWidget);
	}
}
