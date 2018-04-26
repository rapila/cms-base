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
		} else if(($iLoginResult & Session::USER_NEEDS_PASSWORD_RESET) === Session::USER_NEEDS_PASSWORD_RESET) {
			return array('needs_password_reset' => true);
		}
		if(AdminManager::initializeFirstUserIfEmpty($sUserName, $sPassword)) {
			throw new LocalizedException('flash.login_welcome2', array('username' => $sUserName, 'password' => $sPassword));
		}
		throw new LocalizedException('flash.login_check_params');
	}

	public function resetRequest($sUserNameOrPassword, $bForce) {
		if($sUserNameOrPassword === '') {
			throw new LocalizedException('flash.login.username_or_email_required');
		}
		$oUser = UserQuery::create()->filterByUsername($sUserNameOrPassword)->findOne();
		$bShowUserName = false;
		if($oUser === null) {
			$oUser = UserQuery::create()->filterByEmail($sUserNameOrPassword)->findOne();
			$bShowUserName = true;
		}
		if($oUser) {
			LoginManager::sendResetMail($oUser, $bShowUserName, null, $bForce);
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