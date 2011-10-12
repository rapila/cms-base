<?php

require_once 'model/om/BasePageProperty.php';


/**
 * @package model
 */ 
class PageProperty extends BasePageProperty {
	public $bIsTemp = false;
	
	public function save(PropelPDO $con = null) {
		if($this->bIsTemp) {
			return 0;
		}
		return parent::save($con);
	}
	
	public static function mayOperateOn($oUser, $oPageProperty, $sOperation) {
		if(!parent::mayOperateOn($oUser, $oPageProperty, $sOperation)) {
			//Denyable mode is set to 'admin_user' => false means: User is invalid
			return false;
		}
		if($oUser->getIsAdmin()) {
			return true;
		}
		return $oUser->mayEditPageDetails($oPageProperty->getPage());
	}
	
}

