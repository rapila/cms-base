<?php

	// include base peer class
	require_once 'model/om/BaseLinkCategoryPeer.php';

	// include object class
	include_once 'model/LinkCategory.php';


/**
 * @package		 model
 */
class LinkCategoryPeer extends BaseLinkCategoryPeer {
	public static function getAllSorted() {
		$oCriteria = new Criteria();
		$oCriteria->addAscendingOrderByColumn(self::NAME);
		return self::doSelect($oCriteria);
	}
}