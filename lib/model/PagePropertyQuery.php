<?php


/**
 * @package    propel.generator.model
 */
class PagePropertyQuery extends BasePagePropertyQuery {

	
	public function filterBySplitValue($iJournalId, $sChar = ',') {
		return $this->filterByValue($iJournalId)->_or()->filterByValue("$iJournalId$sChar%")->_or()->filterByValue("%$sChar$iJournalId$sChar%")->_or()->filterByValue("%$sChar$iJournalId");
	}
	
	public function byNamespace($mNamespace = true) {
		if($mNamespace === true) {
			return $this->filterByName('%:%', Criteria::LIKE);
		} 
		if(is_string($mNamespace)) {
			return $this->filterByName("$mNamespace:%", Criteria::LIKE);
		}
		return $this->filterByName('%:%', Criteria::NOT_LIKE);
	}
}

