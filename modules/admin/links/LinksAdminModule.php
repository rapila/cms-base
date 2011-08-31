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
			$this->oListWidget->oDelegateProxy->setLinkCategoryId($_REQUEST['link_category_id']);
		}
		
		$this->oSidebarWidget = new ListWidgetModule();
		$this->oSidebarWidget->setListTag(new TagWriter('ul'));
		$this->oSidebarWidget->setDelegate(new CriteriaListWidgetDelegate($this, 'LinkCategory', 'name'));
    $this->oSidebarWidget->setSetting('initial_selection', array('link_category_id' => $this->oListWidget->oDelegateProxy->getLinkCategoryId()));
		
		$this->oInputWidget = new SidebarInputWidgetModule();
	}
	
	public function mainContent() {
		return $this->oListWidget->doWidget();
	}
	
	public function sidebarContent() {
		return $this->oSidebarWidget->doWidget();
	}
	
	public function getColumnIdentifiers() {
		return array('link_category_id', 'name', 'magic_column');
	}
	
	public function getMetadataForColumn($sColumnIdentifier) {
		$aResult = array();
		switch($sColumnIdentifier) {
			case 'link_category_id':
				$aResult['display_type'] = ListWidgetModule::DISPLAY_TYPE_DATA;
				$aResult['field_name'] = 'id';
				break;
			case 'name':
				$aResult['heading'] = StringPeer::getString('wns.links.sidebar_heading');
				break;
			case 'magic_column':
				$aResult['display_type'] = ListWidgetModule::DISPLAY_TYPE_CLASSNAME;
				$aResult['has_data'] = false;
				break;
		}
		return $aResult;
	}
	
	public function getCustomListElements() {
		if(LinkCategoryPeer::doCount(new Criteria()) > 0) {
			return array(
				array('link_category_id' => CriteriaListWidgetDelegate::SELECT_ALL,
							'name' => StringPeer::getString('wns.sidebar.select_all'),
							'magic_column' => 'all'),
				array('link_category_id' => CriteriaListWidgetDelegate::SELECT_WITHOUT,
							'name' => StringPeer::getString('wns.links.select_without_title'),
							'magic_column' => 'without'));
		}
		return array();
	}

	public function getCriteria() {
		$oCriteria = new Criteria();
		if(!Session::getSession()->getUser()->getIsAdmin() || Settings::getSetting('admin', 'hide_externally_managed_link_categories', true)) {
			return $oCriteria->add(LinkCategoryPeer::IS_EXTERNALLY_MANAGED, false);
		}
		return $oCriteria;
	}

	public function usedWidgets() {
		return array($this->oListWidget, $this->oSidebarWidget, $this->oInputWidget);
	}
}
