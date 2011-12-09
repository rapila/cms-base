<?php


/**
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

}

