<?php

	// include base peer class
	require_once 'model/om/BaseLinkPeer.php';
	
	// include object class
	include_once 'model/Link.php';


/**
 * @package model
 */ 
class LinkPeer extends BaseLinkPeer {
		
	public static function addSearchToCriteria($sSearch, $oCriteria) {
		$oSearchCriterion = $oCriteria->getNewCriterion(self::NAME, "%$sSearch%", Criteria::LIKE);
		$oSearchCriterion->addOr($oCriteria->getNewCriterion(self::DESCRIPTION, "%$sSearch%", Criteria::LIKE));
		$oSearchCriterion->addOr($oCriteria->getNewCriterion(self::URL, "%$sSearch%", Criteria::LIKE));
		$oCriteria->add($oSearchCriterion);
	}

	/** 
	 * getLinksByTagName()
	 * @param string|array $mTagName The name(s) of the tag(s) for which links are to be found $mTagName
	 * @param boolean $bOrderByLinkName optional sortorder
	 * @return array of objects
	 */
	public static function getLinksByTagName($mTagName, $bOrderByLinkName=true) {
		$oCriteria = new Criteria();
		$oCriteria->addJoin(self::ID, TagInstancePeer::TAGGED_ITEM_ID, Criteria::INNER_JOIN);
		$oCriteria->addJoin(TagInstancePeer::TAG_ID, TagPeer::ID, Criteria::INNER_JOIN);
		$oCriteria->add(TagInstancePeer::MODEL_NAME, 'Link');
		if(!is_array($mTagName)) $mTagName = array($mTagName);
		$oCriteria->add(TagPeer::NAME, $mTagName, Criteria::IN);
		if($bOrderByLinkName) {
			$oCriteria->addAscendingOrderByColumn(self::NAME);
		} else {
			$oCriteria->addAscendingOrderByColumn(self::URL);
		}
		return self::doSelect($oCriteria);
	}
		
	public static function mayOperateOnOwn($oUser, $mObject, $sOperation) {
		$bResult = parent::mayOperateOnOwn($oUser, $mObject, $sOperation);
		///When changing the sort or the category, I have to have the rights to said category as well
		if($bResult && ($mObject->isColumnModified(LinkPeer::SORT) || $mObject->isColumnModified(LinkPeer::LINK_CATEGORY_ID))) {
			return $mObject->getLinkCategory() === null || $mObject->getLinkCategory()->mayOperate($sOperation, $oUser);
		}
		return $bResult;
	}

}

