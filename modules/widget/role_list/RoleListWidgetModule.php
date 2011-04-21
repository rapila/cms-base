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
	
	public function getGroupId() {
		return $this->iGroupId;
	}
	
	public function setGroupId($iGroupId) {
		$this->iGroupId = $iGroupId;
	}
	
	public function getColumnIdentifiers() {
		return array('id', 'role_key', 'description', 'user_with_role_count', 'group_with_role_count', 'delete');
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
			case 'user_with_role_count':
				$aResult['heading'] = StringPeer::getString('wns.role.user_with_role_count');
				break;
			case 'group_with_role_count':
				$aResult['heading'] = StringPeer::getString('wns.role.group_with_role_count');
				break;
			case 'delete':
				$aResult['heading'] = ' ';
				$aResult['display_type'] = ListWidgetModule::DISPLAY_TYPE_ICON;
				$aResult['field_name'] = 'trash';
				break;
		}
		return $aResult;
	}
	
	public function getGroupName() {
		if($this->oDelegateProxy->getGroupId() !== CriteriaListWidgetDelegate::SELECT_ALL) {
			$oGroup = GroupPeer::retrieveByPK($this->oDelegateProxy->getGroupId());
			if($oGroup) {
				return $oGroup->getName();
			}
		}
		return $this->oDelegateProxy->getGroupId();
	}
	
	public function deleteRow($aRowData, $oCriteria) {
		$oRole = RolePeer::retrieveByPK($aRowData['role_key']);
		if($oRole) return $oRole->delete();
	}
	
	public function getCriteria() {
		$oCriteria = new Criteria();
		$oCriteria->addJoin(RolePeer::ROLE_KEY, GroupRolePeer::ROLE_KEY, Criteria::LEFT_JOIN);
		$oCriteria->addJoin(GroupRolePeer::GROUP_ID, GroupPeer::ID, Criteria::LEFT_JOIN);
		if($this->iGroupId && $this->iGroupId !== CriteriaListWidgetDelegate::SELECT_ALL) {
			$oCriteria->add(GroupRolePeer::GROUP_ID, $this->iGroupId);
		}
		return $oCriteria;
	}

}