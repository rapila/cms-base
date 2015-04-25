<?php
/**
 * @package modules.widget
 */
class GroupListWidgetModule extends SpecializedListWidgetModule {

	protected function createListWidget() {
		$oListWidget = new ListWidgetModule();
		$oDelegateProxy = new CriteriaListWidgetDelegate($this, "Group", "name");
		$oListWidget->setDelegate($oDelegateProxy);
		return $oListWidget;
	}

	public function getColumnIdentifiers() {
		return array('id', 'name', 'roles_info', 'user_link_data', 'delete');
	}

	public function getMetadataForColumn($sColumnIdentifier) {
		$aResult = array();
		switch($sColumnIdentifier) {
			case 'name':
				$aResult['heading'] = StringPeer::getString('wns.group.name');
				$aResult['is_sortable'] = true;
				break;
			case 'user_link_data':
				$aResult['heading'] = StringPeer::getString('wns.group.user_count');
				$aResult['display_type'] = ListWidgetModule::DISPLAY_TYPE_URL;
				break;
			case 'roles_info':
				$aResult['heading'] = StringPeer::getString('wns.group.roles');
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