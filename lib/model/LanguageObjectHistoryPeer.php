<?php

	// include base peer class
	require_once 'model/om/BaseLanguageObjectHistoryPeer.php';

	// include object class
	include_once 'model/LanguageObjectHistory.php';


/**
 * @package		 model
 */
class LanguageObjectHistoryPeer extends BaseLanguageObjectHistoryPeer {

	public static function mayOperateOn($oUser, $oLanguageObjectHistory, $sOperation) {
		if($oUser === null || !$oUser->getIsBackendLoginEnabled()) {
			return false;
		}
		if($oUser->getIsAdmin()) {
			return true;
		}
		return $oUser->mayEditPageContents($oLanguageObjectHistory->getContentObject()->getPage());
	}
}

