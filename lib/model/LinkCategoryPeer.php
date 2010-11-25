<?php

	// include base peer class
	require_once 'model/om/BaseLinkCategoryPeer.php';

	// include object class
	include_once 'model/LinkCategory.php';


/**
 * @package		 model
 */
class LinkCategoryPeer extends BaseLinkCategoryPeer {
	public static function getAllSorted($bWithLinksOnly=false) {
		$oCriteria = new Criteria();
		if($bWithLinksOnly) {
		  $oCriteria->setDistinct();
		  $oCriteria->addJoin(self::ID, LinkPeer::LINK_CATEGORY_ID, Criteria::INNER_JOIN);
		}
		$oCriteria->addAscendingOrderByColumn(self::NAME);
		return self::doSelect($oCriteria);
	}
}