<?php
/**
 * @package modules.widget
 */
class UserListWidgetModule extends PersistentWidgetModule {
	private $oListWidget;
	private $oUserKindFilter;
	public $oDelegateProxy;
	
	public function __construct() {
		$this->oListWidget = new ListWidgetModule();
		$this->oDelegateProxy = new CriteriaListWidgetDelegate($this, "User", 'full_name');
		$this->oListWidget->setDelegate($this->oDelegateProxy);
		$this->oListWidget->setSetting('row_model_drag_and_drop_identifier', 'id');
		$this->oUserKindFilter = WidgetModule::getWidget('user_kind_input', null, UserKindInputWidgetModule::IS_BACKEND_LOGIN_ENABLED);
		$this->oDelegateProxy->setUserKind(UserKindInputWidgetModule::IS_BACKEND_LOGIN_ENABLED);
	}
	
	public function doWidget() {
		$aTagAttributes = array('class' => 'user_list');
		$oListTag = new TagWriter('table', $aTagAttributes);
		$this->oListWidget->setListTag($oListTag);
		return $this->oListWidget->doWidget();
	}
	
	public function getColumnIdentifiers() {
		return array('id', 'full_name', 'username', 'email', 'user_kind', 'is_admin', 'language_id', 'updated_at_formatted', 'delete');
	}
	
	public function getMetadataForColumn($sColumnIdentifier) {
		$aResult = array('is_sortable' => true);
		switch($sColumnIdentifier) {
			case 'full_name':
				$aResult['heading'] = StringPeer::getString('wns.name');
				break;			
			case 'username':
				$aResult['heading'] = StringPeer::getString('wns.user_name');
				break;
			case 'email':
				$aResult['heading'] = StringPeer::getString('wns.email');
				break;
			case 'user_kind':
				$aResult['heading'] = '';
				$aResult['heading_filter'] = array('user_kind_input', $this->oUserKindFilter->getSessionKey());
				$aResult['is_sortable'] = false;
				break;			
			case 'is_admin':
				$aResult['heading'] = StringPeer::getString('wns.user.admin');
				break;
			case 'language_id':
				$aResult['heading'] = StringPeer::getString('wns.language');
				break;
			case 'updated_at_formatted':
				$aResult['heading'] = StringPeer::getString('wns.updated_at');
				break;
			case 'delete':
				$aResult['is_sortable'] = false;
				$aResult['heading'] = ' ';
				$aResult['display_type'] = ListWidgetModule::DISPLAY_TYPE_ICON;
				$aResult['field_name'] = 'trash';
				break;
		}
		return $aResult;
	}
	
	public function getDatabaseColumnForDisplayColumn($sDisplayColumn) {
		if($sDisplayColumn === 'full_name') {
			return UserPeer::FIRST_NAME;
		}
		if($sDisplayColumn === 'updated_at_formatted') {
			return UserPeer::UPDATED_AT;
		}
		if($sDisplayColumn === 'user_kind') {
			return UserPeer::IS_BACKEND_LOGIN_ENABLED;
		}
		if($sDisplayColumn === 'group_id') {
			return UserGroupPeer::GROUP_ID;
		}
		return null;
	}
	
	public function getUserKindName() {
		$aUserKinds = UserKindInputWidgetModule::getUserKinds();
		if(isset($aUserKinds[$this->oDelegateProxy->getUserKind()])) { 
			return $aUserKinds[$this->oDelegateProxy->getUserKind()];
		}
		return $this->oDelegateProxy->getUserKind();
	}
	
	public function getGroupName() {
		$oGroup = GroupPeer::retrieveByPK($this->oDelegateProxy->getGroupId());
		if($oGroup) {
			return $oGroup->getName();
		}
		if($this->oDelegateProxy->getGroupId() === CriteriaListWidgetDelegate::SELECT_WITHOUT) {
			return StringPeer::getString('wns.users.without_category');
		}
		return $this->oDelegateProxy->getGroupId();
	}
	
	public function getFilterTypeForColumn($sColumnName) {
		if($sColumnName === 'user_kind') {
			return CriteriaListWidgetDelegate::FILTER_TYPE_IS;
		}
		if($sColumnName === 'group_id') {
			return CriteriaListWidgetDelegate::FILTER_TYPE_IS;
		}
		return null;
	}
	
	public function getCriteria() {
		$oCriteria = new Criteria();
		$oCriteria->addJoin(UserPeer::ID, UserGroupPeer::USER_ID, Criteria::LEFT_JOIN);
		return $oCriteria;
	}
}