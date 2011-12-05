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
	
	public static function getGroupsBySearch($sSearch = null) {
		$oCriteria = new Criteria();
		if($sSearch) {
			$this->addSearchToCriteria($sSearch, $oCriteria);
		}
		$oCriteria->addAscendingOrderByColumn(self::NAME);
		return self::doSelect($oCriteria);
	}
	
	public static function getAll() {
		$oCriteria = new Criteria();
		$oCriteria->addAscendingOrderByColumn(self::NAME);
		return self::doSelect($oCriteria);
	}
	
	public static function getGroupsByNameSpace($sNameSpace) {
		$oCriteria = new Criteria();
		$oCriteria->add(self::NAME, "$sNameSpace%", Criteria::LIKE);
		$oCriteria->addAscendingOrderByColumn(self::NAME);
		return self::doSelect($oCriteria);
	}
	
	public static function getGroupNamesByNameSpace($sNameSpace) {
		$aResult = array();
		foreach(self::getGroupsByNameSpace($sNameSpace) as $oGroup) {
			$aResult[$oGroup->getId()] = substr($oGroup->getName(), strlen($sNameSpace));
		}
		return $aResult;
	}

	public static function addSearchToCriteria($sSearch, $oCriteria) {
		$oSearchCriterion = $oCriteria->getNewCriterion(self::NAME, "%$sSearch%", Criteria::LIKE);
		$oCriteria->add($oSearchCriterion);
	}

}
