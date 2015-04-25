<?php
/**
 * @package modules.widget
 */
class RoleListWidgetModule extends SpecializedListWidgetModule {
	public $oDelegateProxy;

	protected function createListWidget() {
		$oListWidget = new ListWidgetModule();
		$this->oDelegateProxy = new CriteriaListWidgetDelegate($this, "Role", "role_key");
		$oListWidget->setDelegate($this->oDelegateProxy);
		return $oListWidget;
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
				$aResult['display_type'] = ListWidgetModule::DISPLAY_TYPE_NUMERIC;
				break;
			case 'group_id':
				$aResult['heading'] = StringPeer::getString('wns.role.group_with_role_count');
				$aResult['field_name'] = 'group_with_role_count';
				$aResult['display_type'] = ListWidgetModule::DISPLAY_TYPE_NUMERIC;
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
		$oQuery = RoleQuery::create()->distinct();
		if($this->oDelegateProxy->getGroupId() === CriteriaListWidgetDelegate::SELECT_ALL) {
			return $oQuery->joinGroupRole(null, Criteria::LEFT_JOIN);
		}
		// select specific group
		if(is_numeric($this->oDelegateProxy->getGroupId())) {
			return $oQuery->useGroupRoleQuery(null, Criteria::LEFT_JOIN)
				->useGroupQuery(null, Criteria::LEFT_JOIN)->filterById($this->oDelegateProxy->getGroupId())->endUse()
			->endUse();
		}
		// select roles not included in a group
		return $oQuery->useGroupRoleQuery(null, Criteria::LEFT_JOIN)
			->useGroupQuery(null, Criteria::LEFT_JOIN)->filterById(null, Criteria::ISNULL)->endUse()
		->endUse();
	}

}