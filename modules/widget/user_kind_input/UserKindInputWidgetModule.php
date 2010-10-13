<?php
/**
 * @package modules.widget
 */
class UserKindInputWidgetModule extends PersistentWidgetModule {

	private $sSelectedUserKind;
	const IS_BACKEND_LOGIN_ENABLED = '1';
	const IS_FRONTEND_USER = '2';
		
	public function getUserKinds() {
		$aOptions = array(
		            self::IS_BACKEND_LOGIN_ENABLED => StringPeer::getString('widget.user.backend'), 
		            self::IS_FRONTEND_USER => StringPeer::getString('widget.user.frontend')
		            );
		if($this->allowSelectAll()) {
			$aOptions = array_merge(array(CriteriaListWidgetDelegate::SELECT_ALL => StringPeer::getString('widget.user_kind.all')), $aOptions);
		}
		return $aOptions;
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
	
	public function allowSelectAll() {
		return Settings::getSetting('admin', 'allow_select_all_users', true);
	}

	public function getSelectedUserKind() {
		if( $this->sSelectedUserKind === null && $this->allowSelectAll() === false) {
			$this->sSelectedUserKind = self::IS_BACKEND_LOGIN_ENABLED;
		}
		return $this->sSelectedUserKind;
	}
}