<?php


/**
 * @package    propel.generator.model
 */
class PagePropertyQuery extends BasePagePropertyQuery {

	public function filterBySplitValue($iJournalId, $sChar = ',') {
		return $this->filterByValue($iJournalId)->_or()->filterByValue("$iJournalId$sChar%")->_or()->filterByValue("%$sChar$iJournalId$sChar%")->_or()->filterByValue("%$sChar$iJournalId");
	}
}

