<?php

	// include base peer class
	require_once 'model/om/BaseDocumentCategoryPeer.php';

	// include object class
	include_once 'model/DocumentCategory.php';

/**
 * @package model
 */ 
class DocumentCategoryPeer extends BaseDocumentCategoryPeer {
	
	public static function addSearchToCriteria($sSearch, $oCriteria) {
		$oCriteria->add($oCriteria->getNewCriterion(DocumentCategoryPeer::NAME,"%$sSearch%", Criteria::LIKE));
	}
	
}
