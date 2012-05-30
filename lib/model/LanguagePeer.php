<?php

	// include base peer class
	require_once 'model/om/BaseLanguagePeer.php';
	
	// include object class
	include_once 'model/Language.php';


/**
 * @package model
 */ 
class LanguagePeer extends BaseLanguagePeer {
	
	const STATIC_STRING_NAMESPACE = 'language';
	
	public static function getLanguageName($sOfLanguageId, $sInLanguageId = null) {
		return StringPeer::getString(self::STATIC_STRING_NAMESPACE.".".$sOfLanguageId, $sInLanguageId, $sOfLanguageId);
	}

	public static function languageIsActive($sLanguageId, $bByPath = false) {
		$oLanguage = null;
		if($bByPath) {
			$oLanguage = LanguagePeer::retrieveByPath($sLanguageId);
		} else {
			$oLanguage = LanguagePeer::retrieveByPK($sLanguageId);
		}
		if($oLanguage === null) {
			return false;
		}
		return $oLanguage->getIsActive();
	}

	public static function retrieveByPath($sLanguagePathPrefix) {
		return LanguageQuery::create()->filterByPathPrefix($sLanguagePathPrefix)->findOne();
	}

	public static function languageExists($sLanguageId, $bByPath = false) {
		$oQuery = LanguageQuery::create();
		if($bByPath) {
			$oQuery->filterByPathPrefix($sLanguageId);
		} else {
			$oQuery->filterById($sLanguageId);
		}
		return $oQuery->count() > 0;
	}

	public static function getLanguages($bActiveOnly = false, $bSortBySort = false, $mExcludeCurrent = false) {
		$oCriteria = new Criteria();
		if($bActiveOnly) {
			$oCriteria->add(self::IS_ACTIVE, true);
		}
		if($mExcludeCurrent === 'default') {
			$mExcludeCurrent = Settings::getSetting("session_default", Session::SESSION_LANGUAGE_KEY, 'de');
		}
		if($mExcludeCurrent === true) {
			$mExcludeCurrent = Session::language();
		}
		if($mExcludeCurrent !== false) {
			$oCriteria->add(self::ID, $mExcludeCurrent, Criteria::NOT_EQUAL);
		}
		if($bSortBySort) {
			$oCriteria->addAscendingOrderByColumn(self::SORT);
		} else {
			$oCriteria->addAscendingOrderByColumn(self::ID);
		}
		return self::doSelect($oCriteria);
	}
		
	public static function getLanguagesAssoc($bActiveOnly=false, $oSortBySort=false) {
		$aResult = array();
		$oQuery = LanguageQuery::create();
		if($bActiveOnly) {
			$oQuery->filterByIsActive(true);
		}
		foreach($oQuery->orderByContext($oSortBySort)->find() as $oLanguage) {
			$aResult[$oLanguage->getId()] = $oLanguage->getLanguageName();
		} 
		if(!$oSortBySort) {
			asort($aResult);
		}	 
		return $aResult;
	}
	
	public static function hasNoLanguage() {
		return self::doCount(new Criteria()) === 0;
	}
	
	public static function isMonolingual() {
		return self::doCount(new Criteria()) <= 1;
	}

	public static function getAdminLanguages() {
	  // display registered languages instead of found and posibly incomplete ones
		$aLanguages = array();
		$aRegisteredLanguages = Settings::getSetting('admin', 'registered_user_languages', array());
		foreach($aRegisteredLanguages as $sLanguageId) {
      $aLanguages[$sLanguageId] = self::getLanguageName($sLanguageId);
		}
		return $aLanguages;

		// get language ini files to provide available user_language choice
		$aLanguageFiles = ResourceFinder::getFolderContents(ResourceFinder::findResource(DIRNAME_LANG, ResourceFinder::SEARCH_BASE_ONLY));
		foreach($aLanguageFiles as $sKey => $sValue) {
			if(StringUtil::endsWith($sKey, '.ini')) {
				$sLanguageId = substr($sKey, 0, -4);	
				$aLanguages[$sLanguageId] = self::getLanguageName($sLanguageId);
			}
		}
		return $aLanguages;
	}
	
 /**
	* @param string $sLanguageId
	* use cases:
	* 1. at first users' creation
	* 2. fallback method, creates language if it does not exist, but not at first users' login time, i.e. when languages have been truncated
	* @return void
	*/	
	public static function createLanguageIfNoneExist($sLanguage) {
		if(!LanguagePeer::hasNoLanguage()) {
			return;
		}
		$oLanguage = new Language();
		$oLanguage->setId($sLanguage);
		$oLanguage->setPathPrefix($sLanguage);
		$oLanguage->setIsActive(true);
		LanguagePeer::ignoreRights(true);
		$oLanguage->save();
	}

}

