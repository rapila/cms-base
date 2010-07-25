<?php
/**
 * @package modules.widget
 */
class UserKindInputWidgetModule extends PersistentWidgetModule {

	private $sSelectedUserKind;
		
	public function getUserKinds() {
		return array(CriteriaListWidgetDelegate::SELECT_ALL => StringPeer::getString('widget.user_kind.all'),
		            '1' => StringPeer::getString('widget.user.backend'), 
		            '2' => StringPeer::getString('widget.user.frontend')
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