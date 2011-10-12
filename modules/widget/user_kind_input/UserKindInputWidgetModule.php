<?php
/**
 * @package modules.widget
 */
class UserKindInputWidgetModule extends PersistentWidgetModule {

	private $sSelectedUserKind;
	
	public function __construct($sSessionKey = null, $sDefaultSelection = CriteriaListWidgetDelegate::SELECT_ALL) {
		parent::__construct($sSessionKey);
		$this->sSelectedUserKind = $sDefaultSelection;
	}
		
	public static function allUserKinds() {
		return array(CriteriaListWidgetDelegate::SELECT_ALL => StringPeer::getString('wns.user_kind.all'),
		             User::IS_ADMIN_USER => StringPeer::getString('wns.user.admin'),
		             User::IS_BACKEND_LOGIN_ENABLED => StringPeer::getString('wns.user.backend'), 
		             User::IS_ADMIN_LOGIN_ENABLED => StringPeer::getString('wns.user.is_admin_login_enabled'), 
		             User::IS_FRONTEND_USER => StringPeer::getString('wns.user.frontend')
		);
	}
	
	public function setSelectedUserKind($sSelectedUserKind) {
		if($sSelectedUserKind === '') {
			$sSelectedUserKind = null;
		}
		$this->sSelectedUserKind = $sSelectedUserKind;
	}
	
	public function getElementType() {
		return 'select';
	}

	public function getSelectedUserKind() {
		return $this->sSelectedUserKind;
	}
}
