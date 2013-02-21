<?php

	// include base peer class
	require_once 'model/om/BaseTagPeer.php';
	
	// include object class
	include_once 'model/Tag.php';


/**
 * @package model
 */ 
class TagPeer extends BaseTagPeer {
	
	public static function addSearchToCriteria($sSearch, $oCriteria) {
		$oCriteria->add($oCriteria->getNewCriterion(self::NAME, "%$sSearch%", Criteria::LIKE));
	}
	
	/**
	* @deprecated use query methods
	*/
	public static function allTaggedIdsForModel($sModelName, $sTagName = null) {
		$oCriteria = TagInstanceQuery::create()->innerJoinTag()->filterByModelName($sModelName);
		if($sTagName !== null) {
			$oCriteria->add(TagPeer::NAME, $sTagName);
		}
		$oCriteria->select('TaggedItemId');
		return $oCriteria->find();
	}

	public static function dropTargets() {
		return '*';
	}

	public static function droppedOnto($mDroppedId, $sDroppableModelName, $mDroppableId) {
		$oQuery = TagInstanceQuery::create()->filterByTagName($mDroppedId);
		$oResult = new stdClass();
		$oResult->status = 'tagged';
		$oResult->is_new = $oQuery->count() === 0;
		$oResult->is_new_to_model = $oResult->is_new || $oQuery->filterByModelName($sDroppableModelName)->count() === 0;
		$oResult->is_first_of_model = TagInstanceQuery::create()->filterByModelName($sDroppableModelName)->count() === 0;
		try {
			TagInstancePeer::newTagInstance($mDroppedId, $sDroppableModelName, $mDroppableId);
		} catch (Exception $e) {
			$oResult->status = 're-tagged';
		}
		return $oResult;
	}
	
	/**
	* @deprecated use query methods
	*/
	public static function getTagsSorted($sSearch = null, $bJoinInstances = false) {
		$oCriteria = new Criteria();
		if($bJoinInstances) {
			$oCriteria->addJoin(self::ID, TagInstancePeer::TAG_ID, Criteria::INNER_JOIN);
		}
		if($sSearch !== null) {
			$oCriteria->add(self::NAME, "%$sSearch%", Criteria::LIKE);
		}
		$oCriteria->addAscendingOrderByColumn(self::NAME);
		return self::doSelect($oCriteria);
	}
	
	public static function retrieveByName($sTagName) {
		$oCriteria = new Criteria(self::DATABASE_NAME);
		$oCriteria->add(self::NAME, StringUtil::normalize($sTagName));
		return self::doSelectOne($oCriteria);
	}
	
	public static function deleteTagsForObject($oObject) {
		$aTagInstances = self::tagInstancesForObject($oObject);
		foreach($aTagInstances as $oTagInstance) {
			$oTagInstance->delete();
		}
	}
	
	public static function tagInstancesForObject($oObject) {
		return self::tagInstancesForModel(get_class($oObject), $oObject->getId());
	}
	
	public static function tagInstancesForModel($sModelName, $iTaggedItemId) {
		$oCriteria = new Criteria();
		$oCriteria->add(TagInstancePeer::TAGGED_ITEM_ID, $iTaggedItemId);
		$oCriteria->add(TagInstancePeer::MODEL_NAME, $sModelName);
		return TagInstancePeer::doSelect($oCriteria);
	}
	
	public static function getTagsUsedInModelCriteria($sModelName) {
		$oCriteria = new Criteria();
		$oCriteria->setDistinct();
		$oCriteria->addJoin(self::ID, TagInstancePeer::TAG_ID, Criteria::INNER_JOIN);
		$oCriteria->add(TagInstancePeer::MODEL_NAME, $sModelName);
		$oCriteria->addAscendingOrderByColumn(self::NAME);
		return $oCriteria;
	}
	
	public static function getTagsWithTaggedItemCountByModelName($sModelName) {
	  $oCriteria = new Criteria();
		$oCriteria->addJoin(self::ID, TagInstancePeer::TAG_ID, Criteria::INNER_JOIN);
		$oCriteria->add(TagInstancePeer::MODEL_NAME, $sModelName);
		$oCriteria->addGroupByColumn(self::NAME);
    $oCriteria->addAscendingOrderByColumn(self::NAME);
    $oCriteria->clearSelectColumns()->addSelectColumn('COUNT('.TagInstancePeer::TAG_ID.') AS count');
    $oStmt = self::doSelectStmt($oCriteria);
    $aResult = array();
    while($sName = $oStmt->fetchColumn(1)) {
      $aResult[$sName] = $oStmt->fetchColumn(2);
    }
    return $aResult;
	}
}

