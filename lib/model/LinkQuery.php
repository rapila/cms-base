<?php


/**
 * @package    propel.generator.model
 */
class LinkQuery extends BaseLinkQuery {

	public function excludeExternallyManaged() {
		return $this->useLinkCategoryQuery()->filterByIsExternallyManaged(false)->_or()->filterByIsExternallyManaged(null, Criteria::ISNULL)->endUse();
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

	public function filterByTagName($sTagName) {
		$aTaggedItems = TagInstanceQuery::create()->filterByTagName($sTagName)->filterByModelName('Link')->select(['TaggedItemId'])->find();
		$this->filterById($aTaggedItems, Criteria::IN);
		return $this;
	}
}

