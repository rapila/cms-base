<?php
/**
 * @package modules.widget
 */
class RoleListWidgetModule extends WidgetModule {

	private $oListWidget;
	
	public function __construct() {
		$this->oListWidget = new ListWidgetModule();
		$oDelegateProxy = new CriteriaListWidgetDelegate($this, "Role", "role_key");
		$this->oListWidget->setDelegate($oDelegateProxy);
	}
	
	public function doWidget() {
		$aTagAttributes = array('class' => 'role_list');
		$oListTag = new TagWriter('table', $aTagAttributes);
		$this->oListWidget->setListTag($oListTag);
		return $this->oListWidget->doWidget();
	}
	
	public function getColumnIdentifiers() {
		return array('id', 'role_key', 'description', 'user_with_role_count', 'delete');
	}
	
	public function getMetadataForColumn($sColumnIdentifier) {
		$aResult = array();
		switch($sColumnIdentifier) {
			case 'id':
				$aResult['heading'] = false;
				$aResult['field_name'] = 'role_key';
				$aResult['display_type'] = ListWidgetModule::DISPLAY_TYPE_DATA;
				break;
			case 'role_key':
				$aResult['heading'] = StringPeer::getString('widget.role.role_key');
				$aResult['is_sortable'] = true;
				break;
			case 'description':
				$aResult['heading'] = StringPeer::getString('widget.role.description');
				$aResult['is_sortable'] = true;
				break;
			case 'user_with_role_count':
				$aResult['heading'] = StringPeer::getString('widget.role.user_with_role_count');
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