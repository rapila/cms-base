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

	/**
	 * @return Page The root page
	 */
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
	 * initializeRootPage()
 	 * @deprecated use {@link PagesAdminModule::initializeRootPage()}
	 * @return array of one page object
	 */ 
	public static function initializeRootPage() {
		$oRootPage = new Page();
		$oRootPage->makeRoot();
		$oRootPage->setName('root');
		$oRootPage->setIsInactive(false);
		$oRootPage->setPageType('default');
		$oRootPage->setTemplateName(Settings::getSetting('frontend', 'main_template', 'general'));
		$oFirstUser = UserQuery::create()->findOne();
		$oFirstUserId = $oFirstUser !== null ? $oFirstUser->getId() : 0;
		$oRootPage->setCreatedBy($oFirstUserId);
		$oRootPage->setUpdatedBy($oFirstUserId);
		$sPageString = new PageString();
		$sPageString->setLanguageId(Settings::getSetting("session_default", Session::SESSION_LANGUAGE_KEY, 'de'));
		$sPageString->setPageTitle('Home');
		$sPageString->setIsInactive(false);
		$oRootPage->addPageString($sPageString);
		$oRootPage->save();
		return $oRootPage;
	}
	
	public static function pageIsNotUnique($sName, $iParentId, $iCurrentPageId = null) {
		return PageQuery::create()->filterByParentAndName($sName, $iParentId, $iCurrentPageId)->count() > 0;
	}

	/**
	* getPageByName()
 	* @deprecated Use page query directly because it is simple and clear
 	*/
	public static function getPageByName($sName) {
		return PageQuery::create()->findOneByName($sName);
	}
	
	/**
	* getPageByIdentifier()
 	* @deprecated Use page query directly because it is simple and clear
 	*/
	public static function getPageByIdentifier($sIdentifier) {
		return PageQuery::create()->findOneByIdentifier($sIdentifier);
	}

	public static function getLastUpdatedTimestamp() {
		$oPage = PageQuery::create()->orderByUdatedAt(Criteria::DESC)->findOne();
		if($oPage) {
			return $oPage->getUpdatedAtTimestamp();
		}
		return 0;
	}

	public static function mayOperateOn($oUser, $oPage, $sOperation) {
		if($oUser === null) {
			return false;
		}
		if($oUser->getIsAdmin()) {
			return true;
		}
		if(!$oUser->getIsAdminLoginEnabled()) {
			return false;
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
			if($oPage->hasChildren() === false) {
				return $oUser->mayDelete($oPage);
			}
			foreach($oUser->allRoles() as $oRole) {
				foreach($oRole->getRights() as $oRight) {
					if($oRight->getIsInherited() && $oRight->rightFits($oPage, 'getMayDelete')) {
						return true;
					} 
				}
			}
			return false;
		}
		//Flow never reaches this
		return false;
	}
}
