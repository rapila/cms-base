<?php


/**
 * @package    propel.generator.model
 */
class LanguageQuery extends BaseLanguageQuery {

	public function exclude($mExclude = false) {
		if($mExclude === 'default') {
			$mExclude = Settings::getSetting("session_default", Session::SESSION_LANGUAGE_KEY, 'de');
		} else if($mExclude === true) {
			$mExclude = Session::language();
		}
		if($mExclude !== false) {
			return $this->filterById($mExclude, Criteria::NOT_EQUAL);
		}
		return $this;
	}
	
	public function orderByContext($bOrderBySort = false) {
		if($bOrderBySort) {
			return $this->orderBySort();
		}
		return $this->orderByName();
	}

}

