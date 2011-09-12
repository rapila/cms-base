<?php


/**
 * Skeleton subclass for performing query and update operations on the 'document_types' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.	This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package   propel.generator.model
 */
class DocumentTypeQuery extends BaseDocumentTypeQuery {
	public function filterByDocumentKind($sDocumentKind = 'image', $bInclude = true) {
		$this->filterByMimetype("$sDocumentKind/%", $bInclude ? Criteria::LIKE : Criteria::NOT_LIKE);
		return $this;
	}
} // DocumentTypeQuery
