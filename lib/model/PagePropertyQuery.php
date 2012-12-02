<?php


/**
 * @package    propel.generator.model
 */
class PagePropertyQuery extends BasePagePropertyQuery {

	
	public function filterBySplitValue($iJournalId, $sChar = ',') {
		return $this->filterByValue($iJournalId)->_or()->filterByValue("$iJournalId$sChar%")->_or()->filterByValue("%$sChar$iJournalId$sChar%")->_or()->filterByValue("%$sChar$iJournalId");
	}
	
	/**
	* Filter page properties by namespace name. Special values (true/false) can be used to filter not the namespace itself but the fact wether or not something is namespaced.
	*/
	public function byNamespace($mNamespace = true) {
		if(is_bool($mNamespace)) {
			return $this->filterByName('%:%', $mNamespace ? Criteria::LIKE : Criteria::NOT_LIKE);
		}
		return $this->filterByName("$mNamespace:%", Criteria::LIKE);
	}
	
	/**
	* Filter page properties by name. Same as filterByName(), but with some added frills. Passing two arguments will treat the first as the namespace, the second as the in-namespace name.
	* With a null first argument, this will search for a namespaced property in any namespace.
	* With a null second argument, this will behave like filterByName().
	* When passing two null arguments, the behaviour of this method is undefined.
	*/
	public function byName($sNameOrNamespace, $sNamespacedName = null) {
		if($sNamespacedName === null) {
			return $this->filterByName($sNameOrNamespace);
		}
		if($sNameOrNamespace === null) {
			return $this->filterByName("%:$sNamespacedName", Criteria::LIKE);
		}
		return $this->filterByName("$sNameOrNamespace:$sNamespacedName");
	}
}

