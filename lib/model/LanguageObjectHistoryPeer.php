<?php

	// include base peer class
	require_once 'model/om/BaseLanguageObjectHistoryPeer.php';

	// include object class
	include_once 'model/LanguageObjectHistory.php';


/**
 * @package		 model
 */
class LanguageObjectHistoryPeer extends BaseLanguageObjectHistoryPeer {

	public static function getHistoryByLanguageObject(LanguageObject $oLanguageObject, $iLimit=10) {
		return self::getHistoryByObjectAndLanguageId($oLanguageObject->getObjectId(), $oLanguageObject->getLanguageId(), $iLimit);
	}
	
	public static function getHistoryByObjectAndLanguageId($iObjectId, $sLanguageId, $iLimit=10) {
		$oCriteria = self::getHistoryByObjectAndLanguageIdCriteria($iObjectId, $sLanguageId);
		$oCriteria->setLimit($iLimit);
		return self::doSelect($oCriteria);
	}
	
	public static function getHistoryByObjectAndLanguageIdCriteria($iObjectId, $sLanguageId, $iLimit=10) {
		$oCriteria = new Criteria();
		$oCriteria->add(self::OBJECT_ID, $iObjectId);
		$oCriteria->add(self::LANGUAGE_ID, $sLanguageId);
		$oCriteria->addDescendingOrderByColumn(self::REVISION);
		return $oCriteria;
	}
	
	public static function mayOperateOn($oUser, $oLanguageObjectHistory, $sOperation) {
		return ContentObjectPeer::mayOperateOn($oUser, $oLanguageObjectHistory->getContentObject(), $sOperation);
	}
}

