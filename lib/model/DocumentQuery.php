<?php


/**
 * @package    propel.generator.model
 */
class DocumentQuery extends BaseDocumentQuery {
	public function excludeExternallyManaged() {
		$this->addJoin(DocumentPeer::DOCUMENT_CATEGORY_ID, DocumentCategoryPeer::ID, Criteria::LEFT_JOIN);
		$oManagedFalse = $this->getNewCriterion(DocumentCategoryPeer::IS_EXTERNALLY_MANAGED, false, Criteria::EQUAL);
		$oManagedNull = $this->getNewCriterion(DocumentCategoryPeer::IS_EXTERNALLY_MANAGED, null, Criteria::ISNULL);
		$oManagedFalse->addOr($oManagedNull);
		$this->addAnd($oManagedFalse);
		return $this;
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
	
}
