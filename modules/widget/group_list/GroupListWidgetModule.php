<?php
/**
 * @package modules.widget
 */
class GroupListWidgetModule extends WidgetModule {

	private $oListWidget;
	
	public function __construct() {
		$this->oListWidget = new ListWidgetModule();
		$oDelegateProxy = new CriteriaListWidgetDelegate($this, "Group", "name");
		$this->oListWidget->setDelegate($oDelegateProxy);
	}
	
	public function doWidget() {
		$aTagAttributes = array('class' => 'group_list');
		$oListTag = new TagWriter('table', $aTagAttributes);
		$this->oListWidget->setListTag($oListTag);
		return $this->oListWidget->doWidget();
	}
	
	public function getColumnIdentifiers() {
		return array('id', 'name', 'user_link_data', 'delete');
	}
	
	public function getMetadataForColumn($sColumnIdentifier) {
		$aResult = array();
		switch($sColumnIdentifier) {
			case 'name':
				$aResult['heading'] = StringPeer::getString('group.name');
				$aResult['is_sortable'] = true;
				break;
			case 'user_link_data':
				$aResult['heading'] = StringPeer::getString('group.user_count');
				$aResult['display_type'] = ListWidgetModule::DISPLAY_TYPE_URL;
				break;
			case 'delete':
				$aResult['heading'] = ' ';
				$aResult['display_type'] = ListWidgetModule::DISPLAY_TYPE_ICON;
				$aResult['field_name'] = 'trash';
				break;
		}
		return $aResult;
	}
}