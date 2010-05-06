<?php
/**
 * @package modules.widget
 */
class UserListWidgetModule extends PersistentWidgetModule {
	private $oListWidget;
	private $aGroupId;
	private $sUserKind = '1';
	private $oUserKindFilter;
	
	public function __construct() {
		$this->oListWidget = new ListWidgetModule();
		$oDelegateProxy = new CriteriaListWidgetDelegate($this, "User", 'full_name');
		$this->oListWidget->setDelegate($oDelegateProxy);
		$this->oUserKindFilter = WidgetModule::getWidget('user_kind_input', null, true);
	}
	
	public function doWidget() {
		$aTagAttributes = array('class' => 'user_list');
		$oListTag = new TagWriter('table', $aTagAttributes);
		$this->oListWidget->setListTag($oListTag);
		return $this->oListWidget->doWidget();
	}
	
	public function setGroupId($aGroupId = null) {
		$this->aGroupId = $aGroupId;
	}
	
	public function getGroupId() {
		if($this->aGroupId === null) {
			return CriteriaListWidgetDelegate::SELECT_ALL;
		}
		return $this->aGroupId;
	}
	
	public function setUserKind($sUserKind = null) {
		$this->sUserKind = $sUserKind;
		$this->oUserKindFilter->setSelectedUserKind($sUserKind);
	}
	
	public function getUserKind() {
		if($this->sUserKind === null) {
			return CriteriaListWidgetDelegate::SELECT_ALL;
		}
		return $this->sUserKind;
	}
	
	public function setUserId($aUserId = null) {
		$this->aUserId = $aUserId;
	}
	
	public function getUserId() {
		return $this->aUserId;
	}
	
	public function getColumnIdentifiers() {
		return array('id', 'full_name', 'username', 'email', 'user_kind', 'is_admin', 'language_id', 'updated_at_formatted', 'delete');
	}
	
	public function getMetadataForColumn($sColumnIdentifier) {
		$aResult = array('is_sortable' => true);
		switch($sColumnIdentifier) {
			case 'full_name':
				$aResult['heading'] = StringPeer::getString('name');
				break;			
			case 'username':
				$aResult['heading'] = StringPeer::getString('user_name');
				break;
			case 'email':
				$aResult['heading'] = StringPeer::getString('email');
				break;
			// case 'is_backend_login_enabled':
			// 	$aResult['heading'] = StringPeer::getString('column.is_backend_login_enabled');
			// 	break;
			case 'user_kind':
				$aResult['heading'] = '';
				// $aResult['field_name'] = 'is_backend_login_enabled';
				$aResult['heading_filter'] = array('user_kind_input', $this->oUserKindFilter->getSessionKey());
				$aResult['is_sortable'] = false;
				break;			
			case 'is_admin':
				$aResult['heading'] = StringPeer::getString('column_name.is_admin');
				break;
			case 'language_id':
				$aResult['heading'] = StringPeer::getString('column.language_id');
				break;
			case 'updated_at_formatted':
				$aResult['heading'] = StringPeer::getString('updated_at');
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
	
	public function getSortColumnForDisplayColumn($sDisplayColumn) {
		if($sDisplayColumn === 'full_name') {
			return UserPeer::FIRST_NAME;
		}
		if($sDisplayColumn === 'updated_at_formatted') {
			return UserPeer::UPDATED_AT;
		}
		return null;
	}

	public function getCriteria() {
		$oCriteria = new Criteria();
		if($this->getGroupId() && ($this->getGroupId() !== CriteriaListWidgetDelegate::SELECT_ALL)) {
      $oCriteria->addJoin(UserPeer::ID, UserGroupPeer::USER_ID, Criteria::INNER_JOIN);
			if(is_numeric($this->getGroupId())) {
	  		$oCriteria->add(UserGroupPeer::GROUP_ID, $this->aGroupId);
			} elseif($this->getGroupId() === CriteriaListWidgetDelegate::SELECT_WITHOUT) {
	  		$oCriteria->add(UserGroupPeer::USER_ID, null, Criteria::ISNULL);
			}
		} 
		if($this->sUserKind) {
			$oCriteria->add(UserPeer::IS_BACKEND_LOGIN_ENABLED, $this->sUserKind == '1');
		}
		return $oCriteria;
	}
}