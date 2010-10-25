<?php

	// include base peer class
	require_once 'model/om/BaseLanguageObjectPeer.php';
	
	// include object class
	include_once 'model/LanguageObject.php';


/**
 * @package model
 */ 
class LanguageObjectPeer extends BaseLanguageObjectPeer {
	/**
	* Corresponds to the overriding of {@link LanguageObject->getId()}
	* Provides a unified way of working with stored references (in the references or tags tables)
	*/
	public static function retrieveByPK($object_id, $language_id = null, PropelPDO $con = null) {
		if($language_id === null && strpos($object_id, '_') !== false) {
			$object_id = explode('_', $object_id);
			$language_id = $object_id[1];
			$object_id = $object_id[0];
		}
		return parent::retrieveByPK((int)$object_id, $language_id, $con);
	}
	
	public static function findLanguageObjectsWithObjectType($sObjectType) {
		$oCriteria = new Criteria();
		$oCriteria->addJoin(self::OBJECT_ID, ContentObjectPeer::ID, Criteria::INNER_JOIN);
		$oCriteria->add(ContentObjectPeer::OBJECT_TYPE, $sObjectType);
		return self::doSelect($oCriteria);
	}
	
	public static function findCategoriesFilledInPages($sObjectType = 'document_list', $sCategoryOptionName = 'document_category_option') {
		$aResult = array();
		foreach(self::findLanguageObjectsWithObjectType($sObjectType) as $oLangObj) {
			if(is_resource($oLangObj->getData())) {
				$aData = unserialize(stream_get_contents($oLangObj->getData()));
				if(isset($aData[$sCategoryOptionName])) {
					$aResult[$oLangObj->getContentObject()->getPageId()] = $aData[$sCategoryOptionName];
				}
			}
		}
		return $aResult;
	}
}

