<?php
require_once('propel/runtime/lib/query/Criteria.php');
/**
 * class Session
 */
class Session {

	private $oUser;
	private $iUserId;
	private $aAttributes;

	const SESSION_LANGUAGE_KEY = "language";
	const SESSION_OBJECT_KEY = "session_object_key";
	const SESSION_LAST_EDIT_MODULE	= 'last_edit_module';
	const SESSION_LAST_EDIT_ID			= 'last_edit_id';

	const USER_IS_VALID = 1;
	const USER_IS_DEFAULT_USER = 2;
	const USER_IS_INACTIVE = 4;
	const USER_IS_FRONTEND_ONLY = 8;

	public function __construct() {
		$_SESSION[self::SESSION_OBJECT_KEY] = $this;
		$this->aAttributes = array();
	}

	public function __sleep() {
		$this->oUser = null;
		return array_keys(get_object_vars($this));
	}

	public function __wakeup() {
		if($this->iUserId === null || @$_REQUEST['logout'] === "true") {
			$this->iUserId = null;
			unset($_REQUEST['logout']);
			unset($_POST['logout']);
			unset($_GET['logout']);
			return;
		}
		$this->oUser = UserQuery::create()->findPk($this->iUserId);
	}

	public function isAuthenticated() {
		return ($this->oUser !== null);
	}
	
	public function isBackendAuthenticated() {
		return $this->isAuthenticated() && $this->oUser->getIsBackendLoginEnabled();
	}

	public function login($sUsername, $sPassword) {
		$oUser = UserPeer::getUserByUsername($sUsername);
		if($oUser === null) {
			return 0;
		}
		if(!PasswordHash::comparePassword($sPassword, $oUser->getPassword())) {
			if(PasswordHash::comparePasswordFallback($sPassword, $oUser->getPassword())) {
				$oUser->setPassword($sPassword);
				UserPeer::ignoreRights(true);
				$oUser->save();
				return $this->login($sUsername, $sPassword);
			}
			return 0;
		}
		if($oUser->getDigestHA1() === null && Settings::getSetting('security', 'generate_digest_secrets', false) === true) {
			$oUser->setPassword($sPassword);
			UserPeer::ignoreRights(true);
			$oUser->save();
		}
		return $this->loginUser($oUser);
	}
	
	public static function startDigest() {
		header('HTTP/1.1 401 Unauthorized');
		header('WWW-Authenticate: Digest realm="'.self::getRealm().'",qop="auth",nonce="'.Util::uuid().'",opaque="'.self::getRealm().'"');
	}
	
	public function loginUsingDigest() {
		if(empty($_SERVER['PHP_AUTH_DIGEST'])) {
			return 0;
		}
		
		// analyze the PHP_AUTH_DIGEST variable
		if(($aDigestContent = self::parseDigestHeader()) === false || ($oUser = UserPeer::getUserByUsername($aDigestContent['username'])) === null) {
			return 0;
		}
		
		// generate the valid response
		$sHA1 = $oUser->getDigestHA1();
		if($sHA1 === null) {
			return 0;
		}
		$sHA2 = md5($_SERVER['REQUEST_METHOD'].':'.$aDigestContent['uri']);
		$sCorrectResponse = md5($sHA1.':'.$aDigestContent['nonce'].':'.$aDigestContent['nc'].':'.$aDigestContent['cnonce'].':'.$aDigestContent['qop'].':'.$sHA2);

		if($aDigestContent['response'] !== $sCorrectResponse) {
			return 0;
		}
		
		return $this->loginUser($oUser);
	}
	
	private function loginUser($oUser) {
		$iReturnValue = self::USER_IS_VALID;
		if(!$oUser->getIsBackendLoginEnabled()) {
			$iReturnValue |= self::USER_IS_FRONTEND_ONLY;
		}
		if($oUser->getIsInactive()) {
			$iReturnValue |= self::USER_IS_INACTIVE;
			$iReturnValue &= ~self::USER_IS_VALID;
		}
		//Actual login
		if(($iReturnValue & self::USER_IS_VALID) === self::USER_IS_VALID) {
			$this->oUser = $oUser;
			$this->iUserId = $oUser->getId();
			if(UserQuery::create()->count() === 1 && $this->oUser->getFirstName() == '') {
				// user firstname can only (should only) be empty if it is the default user
				$iReturnValue |= self::USER_IS_DEFAULT_USER;
			}
		}
		FilterModule::getFilters()->handleUserLoggedIn($oUser, array(&$iReturnValue));
		return $iReturnValue;
	}

	private static function parseDigestHeader() {
		// protect against missing data
		$aNeededParts = array('nonce'=>1, 'nc'=>1, 'cnonce'=>1, 'qop'=>1, 'username'=>1, 'uri'=>1, 'response'=>1);
		$aResult = array();
		$sKeys = implode('|', array_keys($aNeededParts));
		
		preg_match_all('@(' . $sKeys . ')=(?:([\'"])([^\2]+?)\2|([^\s,]+))@', $_SERVER['PHP_AUTH_DIGEST'], $aMatches, PREG_SET_ORDER);
		
		foreach ($aMatches as $aMatch) {
			$aResult[$aMatch[1]] = $aMatch[3] ? $aMatch[3] : $aMatch[4];
			unset($aNeededParts[$aMatch[1]]);
		}
		return $aNeededParts ? false : $aResult;
	}

	public function logout() {
		$this->oUser = null;
		$this->iUserId = null;
	}

	public function getLanguage($bObject = false) {
		$sResult = $this->getAttribute(self::SESSION_LANGUAGE_KEY);
		if($bObject) {
			$sResult = LanguageQuery::create()->findPk($sResult);
			if(!$sResult) {
				//If an object was explicitly requested, most likely, it’s supposed to be a content language
				$sResult = LanguageQuery::create()->findPk(AdminManager::getContentLanguage());
			}
		}
		return $sResult;
	}

	public function setLanguage($sLanguage) {
		if($sLanguage instanceof Language) {
			$sLanguage = $sLanguage->getId();
		}
		return $this->setAttribute(self::SESSION_LANGUAGE_KEY, strtolower($sLanguage));
	}

	public function setAttribute($sAttribute, $mValue) {
		if($mValue === null) {
			unset($this->aAttributes[$sAttribute]);
			return;
		}
		$this->aAttributes[$sAttribute] = $mValue;
	}
	
	public function setArrayAttributeValueForKey($sAttribute, $sKey, $mValue = null) {
		if(!$this->hasAttribute($sAttribute)) {
			$this->aAttributes[$sAttribute] = array();
		} else if(!is_array($this->aAttributes[$sAttribute])) {
			throw new Exception("Error in Session->setArrayAttributeValueForKey: Attribute $sAttribute is not an array");
		}
		if($mValue === null) {
			unset($this->aAttributes[$sAttribute][$sKey]);
		} else {
			$this->aAttributes[$sAttribute][$sKey] = $mValue;
		}
	}

	public function getArrayAttributeValueForKey($sAttribute, $sKey) {
		if(!$this->hasAttribute($sAttribute)) {
			return null;
		} else if(!is_array($this->aAttributes[$sAttribute])) {
			throw new Exception("Error in Session->getArrayAttributeValueForKey: Attribute $sAttribute is not an array");
		}
		return @$this->aAttributes[$sAttribute][$sKey];
	}

	public function getAttribute($sAttribute) {
		if(in_array($sAttribute, array('isAuthenticated', 'getUserId'))) {
			return $this->$sAttribute();
		}
		if(in_array($sAttribute, array('getUser->getEmail', 'getUser->getFullName', 'getUser->getInitials'))) {
			$sMethodName = substr($sAttribute, strlen('getUser->'));
			return $this->oUser->$sMethodName();
		}
		if($this->hasAttribute($sAttribute)) {
			return $this->aAttributes[$sAttribute];
		}
		return self::sessionDefaultFor($sAttribute);
	}
	
	public function resetAttribute($sAttribute) {
		$mResult = null;
		if($this->hasAttribute($sAttribute)) {
			$mResult = $this->aAttributes[$sAttribute];
		}
		$this->setAttribute($sAttribute, null);
		return $mResult;
	}

	public function hasAttribute($sAttribute) {
		return isset($this->aAttributes[$sAttribute]);
	}

	public static function sessionDefaultFor($sAttribute) {
		return Settings::getSetting("session_default", $sAttribute, null);
	}

	/**
	 * Shortcut for Session::getSession()->getLanguage();
	 */
	public static function language($bObject = false) {
		return self::getSession()->getLanguage($bObject);
	}

	/**
	 * Shortcut for Session::getSession()->getUser();
	 */
	public static function user($bObject = true) {
		if($bObject) {
			return self::getSession()->getUser();
		} else {
			return self::getSession()->getUserId();
		}
	}

	public static function getSession() {
		if(isset($_SESSION[self::SESSION_OBJECT_KEY])) {
			return $_SESSION[self::SESSION_OBJECT_KEY];
		}
		return new Session();
	}

	public static function getRealm() {
		return str_replace(array('/', '.'), '_', StringUtil::endsWith(MAIN_DIR_FE, '/') ? substr(MAIN_DIR_FE, 0, -1) : MAIN_DIR_FE);
	}

	public function getUser() {
		return $this->oUser;
	}

	public function getUserId() {
		return $this->iUserId;
	}
}

if(php_sapi_name() !== 'cli') {
	session_name("Session".Session::getRealm());
	$aCookieParams = session_get_cookie_params();
	session_set_cookie_params($aCookieParams['lifetime'], MAIN_DIR_FE, $aCookieParams['domain'], false, true);
	//TODO: use ini_set('unserialize_callback_func', gaga);
	session_start();
}
