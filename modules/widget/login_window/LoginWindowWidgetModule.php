<?php
/**
 * @package modules.widget
 */
class LoginWindowWidgetModule extends PersistentWidgetModule {

	public function login($sUserName, $sPassword) {
		if($sUserName === '' || $sPassword === '') {
			throw new LocalizedException('flash.login.empty_fields');
		}
		$iLoginResult = Session::getSession()->login($sUserName, $sPassword);
		if(($iLoginResult & Session::USER_IS_VALID) === Session::USER_IS_VALID) {
			Session::getSession()->setLanguage(Session::getSession()->getUser()->getLanguageId());
			return array('is_valid' => true);
		} else if(($iLoginResult & Session::USER_IS_INACTIVE) === Session::USER_IS_INACTIVE) {
			throw new LocalizedException('flash.login_user_inactive');
		}
		if(UserPeer::initializeFirstUserIfEmpty($sUserName, $sPassword)) {
			throw new LocalizedException('flash.login_welcome2', array('username' => $sUsernameDefault, 'password' => $sPasswordDefault));
		}
		throw new LocalizedException('flash.login_check_params');
	}
	
	public function resetRequest($sUserNameOrPassword) {
    if($sUserNameOrPassword === '') {
			throw new LocalizedException('flash.login.username_or_email_required');
		}
	  $oUser = UserPeer::getUserByUserName($sUserNameOrPassword);
	  $bShowUserName = false;
	  if($oUser === null) {
	    $oUser = UserPeer::getUserByEmail($sUserNameOrPassword);
	    $bShowUserName = true;
	  }
	  if($oUser) {
	    LoginManager::sendResetMail($oUser, $bShowUserName);
	  }
	}
	
	public function getIsLoggedIn() {
		return Session::getSession()->isAuthenticated();
	}
	
	public function logout() {
		Session::getSession()->logout();
		Cache::clearAllCaches();
		return array('success' => true);
	}
	
	public static function isSingleton() {
		return true;
	}
	
	public static function needsLogin() {
		return false;
	}
}