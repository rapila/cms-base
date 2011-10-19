<?php


/**
 * Skeleton subclass for performing query and update operations on the 'language_object_history' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.model
 */
class LanguageObjectHistoryQuery extends BaseLanguageObjectHistoryQuery {
	public function filterByLanguageObject($oLanguageObject) {
		$this->filterByObjectId($oLanguageObject->getObjectId());
		$this->filterByLanguageId($oLanguageObject->getLanguageId());
		return $this;
	}

	public function sort() {
		return $this->orderByRevision(Criteria::DESC);
	}

} // LanguageObjectHistoryQuery
