<?php
/**
 * @package modules.widget
 */
class UserKindInputWidgetModule extends PersistentWidgetModule {

	private $sSelectedUserKind;
		
	public function getUserKinds() {
		return array('1' => 'Backend User', '2' => 'Frontend User');
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