<?php

	// include base peer class
	require_once 'model/om/BaseGroupPeer.php';

	// include object class
	include_once 'model/Group.php';

/**
 * @package		 model
 */
class GroupPeer extends BaseGroupPeer {

	public static function addSearchToCriteria($sSearch, $oCriteria) {
		$oSearchCriterion = $oCriteria->getNewCriterion(self::NAME, "%$sSearch%", Criteria::LIKE);
		$oCriteria->add($oSearchCriterion);
	}

}
