<?php
/**
 * @package modules.frontend
 * 
 * NOTE
 * if the login page is protected, then the origin redirect does not work 
 * if the login is called from an unprotected page, since origin will be overwritten
 * is there a reason to protect a login page?
 */

class LoginFrontendModule extends DynamicFrontendModule {
	
	private $oPage;
	private $oUser;

	const MODE_SELECT_KEY = 'display_mode';

	public function __construct(LanguageObject $oLanguageObject = null, $aRequestPath = null, $iId = 1) {
		parent::__construct($oLanguageObject, $aRequestPath, $iId);
		$this->oPage = FrontendManager::$CURRENT_PAGE;
	}
	
	/**
	* The render method for the login page type. When on a login page type, this is given the login action as determined by the page type. Can be either null (default), 'password_forgotten', or 'password_reset' (or any other string of which a template "$sLoginType_action_$sAction" exists).
	* 
	*/
	public function renderFrontend($sAction = 'login') {
		$aOptions = @unserialize($this->getData());
		$sLoginType = isset($aOptions[self::MODE_SELECT_KEY]) ? $aOptions[self::MODE_SELECT_KEY] : 'login';
		$this->oUser = Session::getSession()->getUser();
		if($this->oUser) {
			$sAction = 'logout';
		}
		$oTemplate = $this->constructTemplate($sLoginType);
		if($oTemplate->hasIdentifier('function_template')) {
			$oFunctionTemplate = null;
			try {
				$oFunctionTemplate = $this->constructTemplate("{$sLoginType}_action_{$sAction}");
			} catch (Exception $e) {
				//Fallback to the default function template for the specified action
				$oFunctionTemplate = $this->constructTemplate("login_action_{$sAction}");
			}
			$oTemplate->replaceIdentifier('function_template', $oFunctionTemplate, null, Template::LEAVE_IDENTIFIERS);
		}
		if($this->oUser) {
			$oPage = $this->oPage;
			if(Session::getSession()->hasAttribute('login_referrer_page')) {
				$oPage = Session::getSession()->getAttribute('login_referrer_page');
				Session::getSession()->resetAttribute('login_referrer_page');
			}
			if(!$this->oPage->getIsProtected() || Session::getSession()->getUser()->mayViewPage($this->oPage)) {
				$oTemplate->replaceIdentifier('fullname', Session::getSession()->getUser()->getFullName());
				$oTemplate->replaceIdentifier('name', Session::getSession()->getUser()->getUsername());
				$oTemplate->replaceIdentifier('action', LinkUtil::link(FrontendManager::$CURRENT_NAVIGATION_ITEM->getLink(), null, array('logout' => 'true')));
			} else {
				$oFlash = Flash::getFlash();
				$oFlash->addMessage('login.logged_in_no_access');
			}
		}
		
		$oTemplate->replaceIdentifier('login_title', StringPeer::getString('wns.login'));
		$sOrigin = isset($_REQUEST['origin']) ? $_REQUEST['origin'] : LinkUtil::linkToSelf();
		$oTemplate->replaceIdentifier('origin', $sOrigin);
		
		if($sAction !== 'logout') {
			$oLoginPage = $this->oPage->getLoginPage();
			$sLink = null;
			if($oLoginPage === null) {
				$sLink = LinkUtil::link('', 'LoginManager');
			} else {
				$sLink = LinkUtil::link($oLoginPage->getFullPathArray());
			}
			$oTemplate->replaceIdentifier('action', $sLink);
		}
		
		if($sAction === 'login') {
			$oLoginPage = $this->oPage->getLoginPage();
			$sLink = null;
			if($oLoginPage === null) {
				$sLink = LinkUtil::link(array(), 'LoginManager', array('password_forgotten' => 'true'));
			} else {
				$sLink = LinkUtil::link($oLoginPage->getFullPathArray(), null, array('password_forgotten' => 'true'));
			}
			$oTemplate->replaceIdentifier('password_forgotten_action', $sLink);
		}
		return $oTemplate;
	}
	
	public function getUser() {
		return $this->oUser;
	}

	public function getWidget() {
		$aOptions = $this->widgetData();
		$oWidget = new LoginEditWidgetModule(null, $this);
		$oWidget->setDisplayMode(@$aOptions[self::MODE_SELECT_KEY]);
		return $oWidget;
	}
}
