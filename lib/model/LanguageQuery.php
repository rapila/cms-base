<?php


/**
 * @package    propel.generator.model
 */
class LanguageQuery extends BaseLanguageQuery {
	
	public static function language($sLanguageId, $bByPath = false) {
		$oQuery = self::create();
		if($bByPath) {
			$oQuery->filterByPathPrefix($sLanguageId);
		} else {
			$oQuery->filterById($sLanguageId);
		}
		return $oQuery;
	}

	public function exclude($mExclude = false) {
		if(!$mExclude) {
			return $this;
		}
		if($mExclude === 'default') {
			$mExclude = Settings::getSetting("session_default", Session::SESSION_LANGUAGE_KEY, 'de');
		} else if($mExclude === 'current') {
			$mExclude = Session::language();
		} else if($mExclude === 'edit') {
			$mExclude = AdminManager::getContentLanguage();
		} else if($mExclude instanceof Language) {
			$mExclude = $mExclude->getId();
		}
		return $this->filterById($mExclude, Criteria::NOT_EQUAL);
	}
	
	public function orderByContext($bOrderBySort = false) {
		if($bOrderBySort) {
			return $this->orderBySort();
		}
		return $this->orderById();
	}
	
}

