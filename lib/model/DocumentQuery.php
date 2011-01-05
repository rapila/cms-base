<?php


/**
 * Skeleton subclass for performing query and update operations on the 'documents' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.model
 */
class DocumentQuery extends BaseDocumentQuery {
	public function filterByDocumentKind($sDocumentKind = 'image') {
		$this->joinDocumentType();
		$this->add(DocumentTypePeer::MIMETYPE, "$sDocumentKind/%", Criteria::LIKE);
		return $this;
	}

} // DocumentQuery
