<?php

// include base peer class
require_once 'model/om/BaseContentObjectPeer.php';

// include object class
include_once 'model/ContentObject.php';


/**
 * @package model
 */ 
class ContentObjectPeer extends BaseContentObjectPeer {
	public static function mayOperateOn($oUser, $oContentObject, $sOperation) {
		if(!parent::mayOperateOn($oUser, $oContentObject, $sOperation)) {
			//Denyable mode is set to 'backend_user' => false means: User is invalid
			return false;
		}
		if($oUser->getIsAdmin()) {
			return true;
		}
		return $oUser->mayEditPageContents($oContentObject->getPage());
	}
}

