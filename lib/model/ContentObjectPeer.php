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
		if($oUser === null || !$oUser->getIsBackendLoginEnabled()) {
			return false;
		}
		if($oUser->getIsAdmin()) {
			return true;
		}
		return $oUser->mayEditPageStructure($oContentObject->getPage());
	}
}

