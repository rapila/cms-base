<?php


/**
 * @package		 propel.generator.model
 */
class DocumentCategoryQuery extends BaseDocumentCategoryQuery {

	public function filterByDocumentKind($sDocumentKind = 'image') {
		$this->setDistinct();
		$this->joinDocument();
		$this->addJoin(DocumentPeer::DOCUMENT_TYPE_ID, DocumentTypePeer::ID, Criteria::INNER_JOIN);
		$this->add(DocumentTypePeer::MIMETYPE, "$sDocumentKind/%", Criteria::LIKE);
		return $this;
	}

}

