<?php
// include base peer class
require_once 'model/om/BasePagePeer.php';
// include object class
include_once 'model/Page.php';


/**
 * @package model
 */	
class PagePeer extends BasePagePeer {

  private static $ROOT_PAGE = null;

  public static function getRootPage() {
    if(self::$ROOT_PAGE === null) {
      $oCriteria = new Criteria();
	    $oSubCriterion = $oCriteria->getNewCriterion(PagePeer::PARENT_ID, 0);
	    $oSubCriterion->addOr($oCriteria->getNewCriterion(PagePeer::PARENT_ID, null, Criteria::ISNULL));
      $oCriteria->add($oSubCriterion);
      self::$ROOT_PAGE = self::doSelectOne($oCriteria);
      if(self::$ROOT_PAGE === null) {
        //throw new Exception('Error in PagePeer::getRootPage\(\): there is no root page with parent 0 or null');
        return null;
      }
    }
    return self::$ROOT_PAGE;
  }

  /**
   * initialiseRootPage()
   * @return array of one page object
   */	
  public static function initialiseRootPage() {
    $oRootPage = new Page();
    $oRootPage->setParentId(null);
    $oRootPage->setSort(1);
    $oRootPage->setName('root');
    $oRootPage->setIsInactive(false);
    $oFirstUser = UserPeer::getFirstUser();
    $oFirstUserId = $oFirstUser !== null ? $oFirstUser->getId() : 0;
    $oRootPage->setCreatedBy($oFirstUserId);
    $oRootPage->setUpdatedBy($oFirstUserId);
    $oRootPage->save();
    $sLanguageId = Settings::getSetting("session_default", Session::SESSION_LANGUAGE_KEY, 'de');
    $oPageString = PageStringPeer::initializeRootPageString( 'Home', $oRootPage->getId(), $sLanguageId);
    $oRootPage->addPageString($oPageString);
    return $oRootPage;
  }
  
  public static function getPageByNameAndParentId($sName, $iParentId, $oCurrentPageId = null) {
    $oCriteria = new Criteria();
    $oCriteria->add(self::NAME, $sName);
    $oCriteria->add(self::PARENT_ID, $iParentId);
    if($oCurrentPageId != null) {
      $oCriteria->add(self::ID, $oCurrentPageId, Criteria::NOT_EQUAL);
    }
    return self::doSelectOne($oCriteria);
  }
  
  public static function pageIsNotUnique($sName, $iParentId, $oCurrentPageId = null) {
    return self::getPageByNameAndParentId($sName, $iParentId, $oCurrentPageId) !== null;
  }

  public static function getMainNavigation() {
    return self::getRootPage()->getChildrenWithCurrentLanguage();
  }

  public static function getPageByName($sName) {
    $oC = new Criteria();
    $oC->add(self::NAME, $sName);
    return self::doSelectOne($oC);
  }

  public static function getLastUpdatedTimestamp() {
    $oCriteria = new Criteria();
    $oCriteria->addDescendingOrderByColumn(self::UPDATED_AT);
    $oPage = self::doSelectOne($oCriteria);
    if($oPage) {
      return $oPage->getTimestamp();
    }
    return 0;
  }
}
