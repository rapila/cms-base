<?php

	// include base peer class
	require_once 'model/om/BaseLanguagePeer.php';
	
	// include object class
	include_once 'model/Language.php';


/**
 * @package model
 */ 
class LanguagePeer extends BaseLanguagePeer {
	
	/**
	* @deprecated moved to LanguageInputWidgetModule::getLanguageName()
	*/	
	const STATIC_STRING_NAMESPACE = 'language';
	public static function getLanguageName($sOfLanguageId, $sInLanguageId = null) {
		return TranslationPeer::getString(self::STATIC_STRING_NAMESPACE.".".$sOfLanguageId, $sInLanguageId, $sOfLanguageId);
	}

	/**
	* @deprecated Use query class method languageIsActive
	*/
	public static function languageIsActive($sLanguageId, $bByPath = false) {
		$oLanguage = LanguageQuery::language($sLanguageId, $bByPath)->findOne();
		if($oLanguage === null) {
			return false;
		}
		return $oLanguage->getIsActive();
	}
	
	/**
	* @deprecated Use query class method languageExists
	*/
	public static function languageExists($sLanguageId, $bByPath = false) {
		$oQuery = LanguageQuery::language($sLanguageId, $bByPath);
		return $oQuery->count() > 0;
	}

	/**
	* @deprecated use query methods directly in context
	*/
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
		
	/**
	* @deprecated use query methods directly in context
	*/
	public static function getLanguagesAssoc($bActiveOnly=false, $oSortBySort=false) {
		$aResult = array();
		$oQuery = LanguageQuery::create();
		if($bActiveOnly) {
			$oQuery->filterByIsActive(true);
		}
		if($oSortBySort) {
			$oQuery->orderBySort();
		} else {
			$oQuery->orderById();
		}
		foreach($oQuery->find() as $oLanguage) {
			$aResult[$oLanguage->getId()] = $oLanguage->getLanguageName();
		} 
		if(!$oSortBySort) {
			asort($aResult);
		}	 
		return $aResult;
	}

	/**
	* @deprecated not used or too simple to have a dedicated method
	*/	
	public static function hasNoLanguage() {
		return self::doCount(new Criteria()) === 0;
	}
	
	/**
	* @deprecated moved to LanguageInputWidgetModule::isMonolingual(), is only used in admin context
	*/	
	public static function isMonolingual() {
		return LanguageInputWidgetModule::isMonolingual();
	}

	/**
	* @deprecated moved to LanguageInputWidgetModule::getAdminLanguages()
	*/
	public static function getAdminLanguages($bDisplayOriginalLanguage = false) {
	  // display registered languages instead of found and posibly incomplete ones
		$aLanguages = array();
		$aRegisteredLanguages = Settings::getSetting('admin', 'registered_user_languages', array());
		foreach($aRegisteredLanguages as $sLanguageId) {
      $aLanguages[$sLanguageId] = self::getLanguageName($sLanguageId, $bDisplayOriginalLanguage ? $sLanguageId : null);
		}
		return $aLanguages;
	}
	
	/**
	* @deprecated moved to AdminManager::createLanguageIfNoneExist(), is only used in admin context
	*/
	public static function createLanguageIfNoneExist($sLanguage) {
		AdminManager::createLanguageIfNoneExist($sLanguage);
	}

}

