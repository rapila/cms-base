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
		$this->joinDocumentType();
		$this->add(DocumentTypePeer::MIMETYPE, "$sDocumentKind/%", Criteria::LIKE);
		return $this;
	}
}
