<?php

	// include base peer class
	require_once 'model/om/BaseGroupPeer.php';

	// include object class
	include_once 'model/Group.php';

/**
 * @package		 model
 */
class GroupPeer extends BaseGroupPeer {
	
	public static function getGroupByName($sName) {
		$oCriteria = new Criteria();
		$oCriteria->add(self::NAME, $sName);
		return self::doSelectOne($oCriteria);
	}
	
	public static function getAllSorted() {
		$oCriteria = new Criteria();
		$oCriteria->addAscendingOrderByColumn(self::NAME);
		return self::doSelect($oCriteria);
	}
	
	public static function getGroupsBySearch($sSearch = null) {
		$oCriteria = new Criteria();
		if($sSearch) {
			$oCriteria->add(self::NAME, "%$sSearch%", Criteria::LIKE);
		}
		$oCriteria->addAscendingOrderByColumn(self::NAME);
		return self::doSelect($oCriteria);
	}
	
	public static function addSearchToCriteria($sSearch, $oCriteria) {
		$oSearchCriterion = $oCriteria->getNewCriterion(self::NAME, "%$sSearch%", Criteria::LIKE);
		$oCriteria->add($oSearchCriterion);
	}

}
