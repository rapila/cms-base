<?php


/**
 * @package    propel.generator.model
 */
class DocumentQuery extends BaseDocumentQuery {

	public function excludeExternallyManaged() {
		return $this->useDocumentCategoryQuery()->filterByIsExternallyManaged(false)->_or()->filterByIsExternallyManaged(null, Criteria::ISNULL)->endUse();
	}

	public function filterByDocumentKind($sDocumentKind = 'image') {
		return $this->filterByDocumentTypeId(DocumentTypeQuery::findDocumentTypeIDsByKind($sDocumentKind), Criteria::IN);
	}

	public function filterByDisplayLanguage($sLanguageId = null) {
		if($sLanguageId === null) {
			$sLanguageId = Session::language();
		}
		return $this->filterByLanguageId(null, Criteria::ISNULL)->_or()->filterByLanguageId(Session::language());
	}

	public function recent() {
		return $this->orderByCreatedAt(Criteria::DESC);
	}

	public function filterByTagId($aTagId) {
		$aTaggedIds = TagInstanceQuery::create()->filterByTagId($aTagId)->filterByModelName('Document')->select(['TaggedItemId'])->find();
		return $this->filterById($aTaggedIds, Criteria::IN);
	}

	public function filterByTagName($sTagName) {
		$aTaggedItems = TagInstanceQuery::create()->filterByTagName($sTagName)->filterByModelName('Document')->select(['TaggedItemId'])->find();
		$this->filterById($aTaggedItems, Criteria::IN);
		return $this;
	}

	public function filterByDocumentCategoryName($sName) {
		return $this->useDocumentCategoryQuery(null, Criteria::INNER_JOIN)->filterByName($sName)->endUse();
	}
}
