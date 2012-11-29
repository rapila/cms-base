<?php


/**
 * @package    propel.generator.model
 */
class LinkQuery extends BaseLinkQuery {

	public function excludeExternallyManaged() {
		$this->addJoin(LinkPeer::LINK_CATEGORY_ID, LinkCategoryPeer::ID, Criteria::LEFT_JOIN);
		$oManagedFalse = $this->getNewCriterion(LinkCategoryPeer::IS_EXTERNALLY_MANAGED, false, Criteria::EQUAL);
		$oManagedNull = $this->getNewCriterion(LinkCategoryPeer::IS_EXTERNALLY_MANAGED, null, Criteria::ISNULL);
		$oManagedFalse->addOr($oManagedNull);
		$this->addAnd($oManagedFalse);
		return $this;
	}
	
	public function filterByDisplayLanguage($sLanguageId = null) {
		if($sLanguageId === null) {
			$sLanguageId = Session::language();
		}
		return $this->filterByLanguageId(null, Criteria::ISNULL)->_or()->filterByLanguageId(Session::language());
	}
	
	public function filterByTagId($aTagId) {
		$aTaggedLinkIds = TagInstanceQuery::create()->filterByTagId($aTagId)->filterByModelName('Link')->select(array('TaggedItemId'))->find();
		return $this->filterById($aTaggedLinkIds, Criteria::IN);
	}


}

