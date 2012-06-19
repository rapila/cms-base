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
		$this->oDelegateProxy->setUserKind(CriteriaListWidgetDelegate::SELECT_ALL);
		$this->oUserKindFilter = WidgetModule::getWidget('user_kind_input', null, $this->oDelegateProxy->getUserKind());
	}
	
	public function doWidget() {
		$aTagAttributes = array('class' => 'user_list');
		$oListTag = new TagWriter('table', $aTagAttributes);
		$this->oListWidget->setListTag($oListTag);
		return $this->oListWidget->doWidget();
	}
	
	public function getColumnIdentifiers() {
		return array('id', 'full_name', 'username', 'email', 'user_kind', 'language_name', 'updated_at_formatted', 'delete');
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
				$aResult['display_type'] = ListWidgetModule::DISPLAY_TYPE_ICON;
				$aResult['heading'] = '';
				$aResult['has_data'] = true;
				$aResult['heading_filter'] = array('user_kind_input', $this->oUserKindFilter->getSessionKey());
				$aResult['is_sortable'] = false;
				break;
			case 'language_name':
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
	
	public function getDatabaseColumnForColumn($sColumnIdentifier) {
		if($sColumnIdentifier === 'full_name') {
			return UserPeer::FIRST_NAME;
		}
		if($sColumnIdentifier === 'updated_at_formatted') {
			return UserPeer::UPDATED_AT;
		}
		if($sColumnIdentifier === 'group_id') {
			return UserGroupPeer::GROUP_ID;
		}
		if($sColumnIdentifier === 'language_name') {
			return UserPeer::LANGUAGE_ID;
		}
		return null;
	}
	
	public function getUserKindName() {
		$aUserKinds = UserKindInputWidgetModule::allUserKinds();
		if(isset($aUserKinds[$this->oDelegateProxy->getUserKind()])) {
			return $aUserKinds[$this->oDelegateProxy->getUserKind()];
		}
		return $this->oDelegateProxy->getUserKind();
	}
	
	public function getGroupName() {
		$oGroup = GroupQuery::create()->findPk($this->oDelegateProxy->getGroupId());
		if($oGroup) {
			return $oGroup->getName();
		}
		if($this->oDelegateProxy->getGroupId() === CriteriaListWidgetDelegate::SELECT_WITHOUT) {
			return StringPeer::getString('wns.users.without_category');
		}
		return $this->oDelegateProxy->getGroupId();
	}
	
	public function getFilterTypeForColumn($sColumnIdentifier) {
		if($sColumnIdentifier === 'user_kind') {
			return CriteriaListWidgetDelegate::FILTER_TYPE_MANUAL;
		}
		if($sColumnIdentifier === 'group_id') {
			return CriteriaListWidgetDelegate::FILTER_TYPE_IS;
		}
		return null;
	}
	
	public function getCriteria() {
		$oCriteria = UserQuery::create();
		$sUserKind = $this->oDelegateProxy->getUserKind();
		if($sUserKind !== CriteriaListWidgetDelegate::SELECT_ALL) {
			if($sUserKind === User::IS_ADMIN_USER) {
				$oCriteria->filterByIsAdmin(true);
			} else if($sUserKind === User::IS_BACKEND_LOGIN_ENABLED) {
				$oCriteria->filterByIsBackendLoginEnabled(true);
			} else if($sUserKind === User::IS_ADMIN_LOGIN_ENABLED) {
				$oCriteria->filterByIsBackendLoginEnabled(true)->filterByIsAdminLoginEnabled(true);
			} else {
				$oCriteria->filterByIsAdmin(false)->filterByIsBackendLoginEnabled(false)->filterByIsAdminLoginEnabled(false);
			}
		}
		$oCriteria->addJoin(UserPeer::ID, UserGroupPeer::USER_ID, Criteria::LEFT_JOIN);
		return $oCriteria;
	}
}
