<?php
/**
 * @package modules.widget
 */
class RoleListWidgetModule extends WidgetModule {

	private $oListWidget;
	private $iGroupId;
	public $oDelegateProxy;
	
	public function __construct() {
		$this->oListWidget = new ListWidgetModule();
		$this->oDelegateProxy = new CriteriaListWidgetDelegate($this, "Role", "role_key");
		$this->oListWidget->setDelegate($this->oDelegateProxy);
	}
	
	public function doWidget() {
		$aTagAttributes = array('class' => 'role_list');
		$oListTag = new TagWriter('table', $aTagAttributes);
		$this->oListWidget->setListTag($oListTag);
		return $this->oListWidget->doWidget();
	}
	
	public function getColumnIdentifiers() {
		return array('id', 'role_key', 'description', 'user_id', 'group_id', 'delete');
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
				$aResult['heading'] = StringPeer::getString('wns.role.role_key');
				$aResult['is_sortable'] = true;
				break;
			case 'description':
				$aResult['heading'] = StringPeer::getString('wns.role.description');
				$aResult['is_sortable'] = true;
				break;
			case 'user_id':
				$aResult['heading'] = StringPeer::getString('wns.role.user_with_role_count');
				$aResult['field_name'] = 'user_with_role_count';
				break;
			case 'group_id':
				$aResult['heading'] = StringPeer::getString('wns.role.group_with_role_count');
				$aResult['field_name'] = 'group_with_role_count';
				break;
			case 'delete':
				$aResult['heading'] = ' ';
				$aResult['display_type'] = ListWidgetModule::DISPLAY_TYPE_ICON;
				$aResult['field_name'] = 'trash';
				break;
		}
		return $aResult;
	}
	
	public function getFilterTypeForColumn($sColumn) {
		if($sColumn === 'group_id') {
			return CriteriaListWidgetDelegate::FILTER_TYPE_MANUAL;
		}
	}
	
	public function getGroupName() {
		if($this->oDelegateProxy->getGroupId() !== CriteriaListWidgetDelegate::SELECT_ALL) {
			$oGroup = GroupQuery::create()->findPk($this->oDelegateProxy->getGroupId());
			if($oGroup) {
				return $oGroup->getName();
			}
		}
		return $this->oDelegateProxy->getGroupId();
	}
	
	public function deleteRow($aRowData, $oCriteria) {
		$oRole = RoleQuery::create()->findPk($aRowData['id']);
		if($oRole) return $oRole->delete();
	}
	
	public function getGroupHasRoles($iGroupId) {
		return GroupRoleQuery::create()->filterByGroupId($iGroupId)->count() > 0;
	}

	public function getCriteria() {
		// select all
		if($this->oDelegateProxy->getGroupId() === CriteriaListWidgetDelegate::SELECT_ALL) {
			return RoleQuery::create()->joinGroupRole(null, Criteria::LEFT_JOIN);
		}
		// select specific group
		if(is_numeric($this->oDelegateProxy->getGroupId())) {
			return RoleQuery::create()->useGroupRoleQuery(null, Criteria::LEFT_JOIN)
				->useGroupQuery(null, Criteria::LEFT_JOIN)->filterById($this->oDelegateProxy->getGroupId())->endUse()
			->endUse();
		}
		// select roles not included in a group
		return RoleQuery::create()->useGroupRoleQuery(null, Criteria::LEFT_JOIN)
			->useGroupQuery(null, Criteria::LEFT_JOIN)->filterById(null, Criteria::ISNULL)->endUse()
		->endUse();
	}

}