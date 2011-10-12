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
			self::$ROOT_PAGE = self::retrieveRoot();
			if(self::$ROOT_PAGE === null) {
				throw new Exception('Error in PagePeer::getRootPage(): there is no root page');
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
		$oRootPage->makeRoot();
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
	
	public static function pageIsNotUnique($sName, $iParentId, $iCurrentPageId = null) {
		return PageQuery::create()->filterByParentAndName($sName, $iParentId, $iCurrentPageId)->count() > 0;
	}

	public static function getPageByName($sName) {
		return PageQuery::create()->filterByName($sName)->findOne();
	}

	public static function getPageByIdentifier($sIdentifier) {
		return PageQuery::create()->filterByIdentifier($sIdentifier)->findOne();
	}

	public static function getLastUpdatedTimestamp() {
		$oCriteria = new Criteria();
		$oCriteria->addDescendingOrderByColumn(self::UPDATED_AT);
		$oPage = self::doSelectOne($oCriteria);
		if($oPage) {
			return $oPage->getUpdatedAtTimestamp();
		}
		return 0;
	}

	public static function mayOperateOn($oUser, $oPage, $sOperation) {
		if(!parent::mayOperateOn($oUser, $oPage, $sOperation)) {
			//Denyable mode is set to 'admin_user' => false means: User is invalid
			return false;
		}
		if($oUser->getIsAdmin()) {
			return true;
		}
		if($sOperation === 'insert') {
			$oParent = $oPage->getParent();
			if($oParent === null) {
				//Only admins may create root pages
				return false;
			}
			return $oUser->mayCreateChildren($oParent);
		}
		if($sOperation === 'update') {
			return $oUser->mayEditPageDetails($oPage);
		}
		if($sOperation === 'delete') {
			//FIXME: if page has children, check if right is inherited.
			return $oUser->mayDelete($oPage);
		}
		//Flow never reaches this
		return false;
	}
}
