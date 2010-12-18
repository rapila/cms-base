<?php
/**
 * @package modules.admin
 */
class RolesAdminModule extends AdminModule {
	
	private $oListWidget;

	public function __construct() {
		$this->oListWidget = new RoleListWidgetModule();
		$this->oSidebarWidget 		= new ListWidgetModule();
		$this->oSidebarWidget->setListTag(new TagWriter('ul'));
		$this->oSidebarWidget->setDelegate(new CriteriaListWidgetDelegate($this, 'Group', 'name'));
		if(isset($_REQUEST['group_id'])) {
			$this->oListWidget->oDelegateProxy->setGroupId($_REQUEST['group_id']);
		}
		$this->addResourceParameter(ResourceIncluder::RESOURCE_TYPE_JS, 'group_id', $this->oListWidget->oDelegateProxy->getGroupId());
	}
	
	public function mainContent() {
		return $this->oListWidget->doWidget();
	}
	
	public function sidebarContent() {
		return $this->oSidebarWidget->doWidget();
	}
	
	public function getColumnIdentifiers() {
		return array('group_id', 'name', 'magic_column');
	}
	
	public function getMetadataForColumn($sColumnIdentifier) {
		$aResult = array();
		switch($sColumnIdentifier) {
			case 'group_id':
				$aResult['display_type'] = ListWidgetModule::DISPLAY_TYPE_DATA;
				$aResult['field_name'] = 'id';
				break;
			case 'name':
				$aResult['heading'] = StringPeer::getString('widget.roles.sidebar_heading');
				$aResult['field_name'] = 'name';
				break;
			case 'magic_column':
				$aResult['display_type'] = ListWidgetModule::DISPLAY_TYPE_CLASSNAME;
				$aResult['has_data'] = false;
				break;
		}
		return $aResult;
	}

	public function getCustomListElements() {
		if(GroupPeer::doCount(new Criteria()) > 0) {
			return array(
				array('group_id' => CriteriaListWidgetDelegate::SELECT_ALL,
							'name' => StringPeer::getString('widget.roles.select_all_title'),
							'magic_column' => 'all'),
				array('group_id' => CriteriaListWidgetDelegate::SELECT_WITHOUT,
							'name' => StringPeer::getString('widget.roles.select_without_group_title'),
							'magic_column' => 'without'));
		}
		return array();
	}

	public function usedWidgets() {
		return array($this->oListWidget, $this->oSidebarWidget);
	}
}
