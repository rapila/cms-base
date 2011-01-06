<?php

	// include base peer class
	require_once 'model/om/BaseUserGroupPeer.php';

	// include object class
	include_once 'model/UserGroup.php';


/**
 * @package		 model
 */
class UserGroupPeer extends BaseUserGroupPeer {
	public static function getAllSorted() {
		$oCriteria = new Criteria();
		$oCriteria->addAscendingOrderByColumn('name');
		return self::doSelect($oCriteria);
	}
}

