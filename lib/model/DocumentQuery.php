<?php


/**
 * @package    propel.generator.model
 */
class DocumentQuery extends BaseDocumentQuery {
	
	public function excludeExternallyManaged() {
		$this->useDocumentCategoryQuery()->filterByIsExternallyManaged(false)->_or()->filterByIsExternallyManaged(null, Criteria::ISNULL)->endUse();
	}
		
	public function filterByDocumentKind($sDocumentKind = 'image') {
		return $this->filterByDocumentTypeId(DocumentTypePeer::getDocumentTypeIDsByKind($sDocumentKind), Criteria::IN);
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
		$aTaggedIds = TagInstanceQuery::create()->filterByTagId($aTagId)->filterByModelName('Document')->select(array('TaggedItemId'))->find();
		return $this->filterById($aTaggedIds, Criteria::IN);
	}
	
	
}
