<?php
/**
 * @package modules.admin
 */
class UsersAdminModule extends AdminModule {

	private $oListWidget;
	private $oSidebarWidget;

	public function __construct() {
		$this->oListWidget 				= new UserListWidgetModule();
		if(isset($_REQUEST['group_id'])) {
			$this->oListWidget->oDelegateProxy->setGroupId($_REQUEST['group_id']);
		}
		$this->addResourceParameter(ResourceIncluder::RESOURCE_TYPE_JS, 'group_id', $this->oListWidget->oDelegateProxy->getGroupId());
		
		if(isset($_REQUEST['user_id'])) {
			$this->addResourceParameter(ResourceIncluder::RESOURCE_TYPE_JS, 'user_id', $_REQUEST['user_id']);
		}
		$this->oSidebarWidget 		= new ListWidgetModule();
		$this->oSidebarWidget->setDelegate(new CriteriaListWidgetDelegate($this, 'Group', 'name'));
	}
	
	public function mainContent() {
		return $this->oListWidget->doWidget();
	}
	
	public function sidebarContent() {
		return $this->oSidebarWidget->doWidget();
	}
	
	public function getColumnIdentifiers() {
		return array('id', 'name', 'magic_column');
	}
	
	public function getMetadataForColumn($sColumnIdentifier) {
		$aResult = array();
		switch($sColumnIdentifier) {
			case 'name':
				$aResult['heading'] = StringPeer::getString('users.sidebar_heading');
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
		$aCustomElements = array(
			array('id' => CriteriaListWidgetDelegate::SELECT_ALL,
						'name' => StringPeer::getString('users.select_all_title'),
						'magic_column' => 'all'),
			array('id' => CriteriaListWidgetDelegate::SELECT_WITHOUT,
						'name' => StringPeer::getString('users.select_without_title'),
						'magic_column' => 'without'));
		//TODO: Return an empty array if doCount($this->getCriteria()) > 0
		return $aCustomElements;
	}

	public function usedWidgets() {
		return array($this->oListWidget, $this->oSidebarWidget);
	}
}
