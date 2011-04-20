<?php
/**
 * @package manager
*/
class LoginManager extends Manager {
	
	const USER_NAME = 'user_name';
	const LOGIN_PASSWORD = 'password';
	private $sAction;
	private $oTemplate;
	
	public function __construct() {
		parent::__construct();
		$this->sAction = 'login';
		if(Manager::isPost()) {
			ArrayUtil::trimStringsInArray($_POST);
		}
		//1st step: user clicked on the recovery link
		//	• Display email field
		if(isset($_REQUEST['password_forgotten'])) {
			$this->sAction = 'password_forgotten';
		}
		//2nd step: user has entered an email address
		//	• Send the email with the recovery link (and generate the hint)
		//	• Add confirmation message to flash
		if(isset($_POST['password_reset_user_name'])) {
			$this->sAction = self::sendResetMail();
		}
		//3rd step: user has clicked on the reset link in the e-mail
		//	• Validate the hint
		//	• Display a form for entering a new password (form also contains hidden fields for email and hint)
		//	• Add the referrer to the session (again)
		if(isset($_REQUEST['recover_username'])) {
			$this->sAction = self::passwordReset();
		}
		//4th step: user has submitted the new password
		//	• Validate the hint (again)
		//	• Validate password constraints
		//	• Set the new password (if valid)
		//	• Log in (if valid)
		//	• Redirect to the referrer (if valid)
		if(isset($_POST['new_password'])) {
			$this->sAction = self::loginNewPassword();
		}
		if(isset($_POST[self::USER_NAME])) {
			self::login();
		}
		$oOutput = new XHTMLOutput('transitional');
		$oOutput->render();
		$this->oTemplate = new Template('login', array(DIRNAME_TEMPLATES, 'login'), false, true);
	}
	
	public function render() {
		$this->oTemplate->replaceIdentifier('login_action', $this->sAction);
		$this->oTemplate->doIncludes();
		$this->oTemplate->replaceIdentifier('action', LinkUtil::link());
		$this->oTemplate->replaceIdentifier('login_title', StringPeer::getString($this->sAction == 'password_forgotten' ? 'wns.login.password_reset' : 'wns.login'));
		$this->oTemplate->replaceIdentifier('domain_name', LinkUtil::getHostName());
		if($this->sAction === 'login') {
			$this->renderLogin();
		}
		$this->oTemplate->render();
	}

	private function renderLogin() {
		$this->oTemplate->replaceIdentifier('action_password_forgotten', LinkUtil::link(null, null, array('password_forgotten' => 'true')));
		$this->oTemplate->replaceIdentifier(self::USER_NAME, '');
		$this->oTemplate->replaceIdentifier(self::LOGIN_PASSWORD, '');
	}

	public static function login($sUserName = null, $sPassword = null, $sReferrer = '') {
		if($sUserName === null) {
			$sUserName = $_POST[self::USER_NAME];
		}
		if($sPassword === null) {
			$sPassword = $_POST[self::LOGIN_PASSWORD];
		}
		$oFlash = Flash::getFlash();
		if($sUserName === '' || $sPassword === '') {
			$oFlash->addMessage('login.empty_fields');
			return;
		}
		$iAdminTest = Session::getSession()->login($sUserName, $sPassword);
		//User is valid
		if(($iAdminTest & Session::USER_IS_VALID) === Session::USER_IS_VALID) {
			if(isset($_REQUEST['origin'])) {
				$sReferrer = $_REQUEST['origin'];
			} else if(Session::getSession()->hasAttribute('login_referrer')) {
				$sReferrer = Session::getSession()->getAttribute('login_referrer');
				Session::getSession()->resetAttribute('login_referrer');
			} else if(!$sReferrer) {
				$sReferrer = LinkUtil::link(array(), 'AdminManager');
			}
			if(($iAdminTest & Session::USER_IS_DEFAULT_USER) === Session::USER_IS_DEFAULT_USER) { 
				Session::getSession()->setAttribute('change_password', 1);
				$sReferrer = LinkUtil::link(array('users', Session::getSession()->getUserId()), 'AdminManager');
			}
			LinkUtil::redirect($sReferrer);
		}
		//User is inactive
		if(($iAdminTest & Session::USER_IS_INACTIVE) === Session::USER_IS_INACTIVE) {
			$oFlash->addMessage('login_user_inactive');
			return;
		}
		//User is unknown
		$oFlash->addMessage('login_check_params');
		$sUsernameDefault = $sUserName;
		$sPasswordDefault = $sPassword;
		if(UserPeer::initializeFirstUserIfEmpty($sUsernameDefault, $sPasswordDefault)) {
			$oFlash->removeMessage('login_check_params');
			$oFlash->addMessage('login_welcome');
			$oFlash->addMessage('login_welcome2', array( 'username' => $sUsernameDefault, 'password' => $sPasswordDefault));
		}
	}
	
	public static function processPasswordReset($sLinkBase = null) {
		$oFlash = Flash::getFlash();
		if($_POST['password_reset_user_name'] === '') {
			$oFlash->addMessage('login.empty_fields');
			return 'password_forgotten';
		}
		
		$oFlash->addMessage('login.recovery_link_sent');
		$oUser = UserPeer::getUserByUserName($_POST['password_reset_user_name'], true);
		if($oUser === null) {
			return 'login';
		}
    self::sendResetMail($oUser, false, $sLinkBase);
		return 'login';
	}
	
	public static function sendResetMail($oUser, $bShowUserName = false, $sLinkBase) {
		$oUser->setPasswordRecoverHint(PasswordHash::generateHint());
		$oUser->save();
		
		$oEmailTemplate = new Template('e_mail_pw_recover', array(DIRNAME_TEMPLATES, 'login'));
		$oEmailTemplate->replaceIdentifier('first_name', $oUser->getFirstName());
		$oEmailTemplate->replaceIdentifier('last_name', $oUser->getLastName());
		$oEmailTemplate->replaceIdentifier('username', $oUser->getUsername());
		if($bShowUserName) {
		  $oEmailTemplate->replaceIdentifier('username_info', StringPeer::getString('login.password_reset.your_username').': '.$oUser->getUsername());
		}
		if($sLinkBase === null) {
			$sLinkBase = LinkUtil::linkToSelf(null, null, true);
		}
		$aParams = array('recover_hint' => md5($oUser->getPasswordRecoverHint()), 'recover_username' => $oUser->getUsername());
		if(Session::getSession()->hasAttribute('login_referrer')) {
			$aParams['recover_referrer'] = Session::getSession()->getAttribute('login_referrer');
		}
		$sLink = "http://".$_SERVER['HTTP_HOST'].$sLinkBase.LinkUtil::prepareLinkParameters($aParams);
		$oEmailTemplate->replaceIdentifier('new_pw_url', $sLink);
		$oEmail = new EMail(StringPeer::getString('wns.login.password_recover_email_subject'), $oEmailTemplate);
		$sSenderAddress = LinkUtil::getDomainHolderEmail('cms');
		$oEmail->setSender(Settings::getSetting('domain_holder', 'name', 'rapila on '.$_SERVER['HTTP_HOST']), $sSenderAddress);
		$oEmail->addRecipient($oUser->getEmail());
		$oEmail->send();
	}
	
	public static function passwordReset() {
		$oFlash = Flash::getFlash();
		$oUser = UserPeer::getUserByUserName(trim($_REQUEST['recover_username']), true);
		if($oUser === null || md5($oUser->getPasswordRecoverHint()) !== $_REQUEST['recover_hint']) {
			$oFlash->addMessage('login.recovery.invalid');
			return 'login';
		}
		if(isset($_REQUEST['recover_referrer'])) {
			Session::getSession()->setAttribute('login_referrer', $_REQUEST['recover_referrer']);
		}
		return 'password_reset';
	}
	
	public static function loginNewPassword($sReferrer = '') {
		$oFlash = Flash::getFlash();
		$oUser = UserPeer::getUserByUserName(trim($_REQUEST['recover_username']), true);
		if($oUser === null || md5($oUser->getPasswordRecoverHint()) !== $_REQUEST['recover_hint']) {
			$oFlash->addMessage('login.recovery.invalid');
			return 'login';
		}
		
		if($_POST['new_password'] === '') {
			$oFlash->addMessage('login.empty_fields');
		}
		PasswordHash::checkPasswordValidity($_POST['new_password'], $oFlash);
		if($_POST['new_password'] !== $_POST['new_password_retype']) {
			$oFlash->addMessage('password_confirm');
		}
		$oFlash->finishReporting();
		
		if(!Flash::noErrors()) {
			return 'password_reset';
		}
		
		//No errors – set new password, login and redirect
		$oUser->setPassword($_POST['new_password']);
		$oUser->setPasswordRecoverHint(null);
		$oUser->save();
		self::login($_POST['recover_username'], $_POST['new_password'], $sReferrer);
		
		return 'login';
	}
}