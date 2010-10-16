<?php
/**
 * @package modules.widget
 */
class UserKindInputWidgetModule extends PersistentWidgetModule {

	private $sSelectedUserKind;
	const IS_BACKEND_LOGIN_ENABLED = '1';
	const IS_FRONTEND_USER = '2';
		
	public function getUserKinds() {
		return array(CriteriaListWidgetDelegate::SELECT_ALL => StringPeer::getString('widget.user_kind.all'),
								self::IS_BACKEND_LOGIN_ENABLED => StringPeer::getString('widget.user.backend'), 
								self::IS_FRONTEND_USER => StringPeer::getString('widget.user.frontend')
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