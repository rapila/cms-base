<?php

	// include base peer class
	require_once 'model/om/BaseRightPeer.php';
	
	// include object class
	include_once 'model/Right.php';


/**
 * @package model
 */ 
class RightPeer extends BaseRightPeer {
	
	public static function rightWithUniqueValueExists($iPageId, $sRoleKey, $bIsInherited) {
		$oCriteria = new Criteria();
		$oCriteria->add(self::PAGE_ID, $iPageId);
		$oCriteria->add(self::ROLE_KEY, $sRoleKey);
		$oCriteria->add(self::IS_INHERITED, $bIsInherited);
		return self::doCount($oCriteria) > 0;
	}
}

