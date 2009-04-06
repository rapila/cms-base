<?php

  // include base peer class
  require_once 'model/om/BaseLanguagePeer.php';
  
  // include object class
  include_once 'model/Language.php';


/**
 * Skeleton subclass for performing query and update operations on the 'languages' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package model
 */	
class LanguagePeer extends BaseLanguagePeer {

  public static function languageIsActive($sLanguageId) {
    $sLanguage = LanguagePeer::retrieveByPK($sLanguageId);
    if($sLanguage === null) {
      return false;
    }
    return $sLanguage->getIsActive();
  }

  public static function languageExists($sLanguageId) {
    $sLanguage = LanguagePeer::retrieveByPK($sLanguageId);
    if($sLanguage === null) {
      return false;
    }
    return true;
  }

  public static function getLanguages($bActiveOnly=false, $bSortBySort = false) {
    $oCriteria = new Criteria();
    if($bActiveOnly) {
      $oCriteria->add(self::IS_ACTIVE, true);
    }
    if($bSortBySort) {
      $oCriteria->addAscendingOrderByColumn(self::SORT);
    } else {
      $oCriteria->addAscendingOrderByColumn(self::ID);
    }
    return self::doSelect($oCriteria);
  }

  public static function getLanguagesAssoc($bActiveOnly=false) {
    $aResult = array();
    $aLanguages = self::getLanguages($bActiveOnly);
    foreach($aLanguages as $oLanguage) {
      $aResult[$oLanguage->getId()] = $oLanguage->getLanguageName();
    }    
    return $aResult;
  }
  
  public static function hasNoLanguage() {
    return self::doCount(new Criteria()) === 0;
  }

  public static function getBackendLanguages() {
    $aLanguages = array();
    foreach(self::getFolderContents(MAIN_DIR.'/resources/lang/') as $sLanguage => $sPath) {
      $sName = substr($sLanguage, 0, 2);
      $aLanguages[] = $sName;
    }
    return $aLanguages;
  }

}

