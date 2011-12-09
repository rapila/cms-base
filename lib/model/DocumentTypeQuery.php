<?php


/**
 * @package   propel.generator.model
 */
class DocumentTypeQuery extends BaseDocumentTypeQuery {
	public function filterByDocumentKind($sDocumentKind = 'image', $bInclude = true) {
		$this->filterByMimetype("$sDocumentKind/%", $bInclude ? Criteria::LIKE : Criteria::NOT_LIKE);
		return $this;
	}
}

