<?php


/**
 * @package		 propel.generator.model
 */
class RolePeer extends BaseRolePeer {
	
	public static function addSearchToCriteria($sSearch, $oCriteria) {
		$oSearchCriterion = $oCriteria->getNewCriterion(RolePeer::ROLE_KEY,"%$sSearch%", Criteria::LIKE);
		$oSearchCriterion->addOr($oCriteria->getNewCriterion(RolePeer::DESCRIPTION, "%$sSearch%", Criteria::LIKE));
		$oCriteria->add($oSearchCriterion);
	}

}

