<?php
require_once('propel/query/Criteria.php');
/**
 * class Session
 */
class Session {

  private $oUser;
  private $iUserId;
  private $aAttributes;

  const SESSION_LANGUAGE_KEY = "language";
  const SESSION_OBJECT_KEY = "session_object_key";
  const SESSION_LAST_EDIT_MODULE  = 'last_edit_module';
  const SESSION_LAST_EDIT_ID      = 'last_edit_id';

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
    $this->oUser = UserPeer::retrieveByPK($this->iUserId);
  }

  public function isAuthenticated() {
    return ($this->oUser !== null);
  }

  public function login($sUsername, $sPassword) {
    $oCriteria = new Criteria();
    $oCriteria->add(UserPeer::USERNAME, $sUsername, Criteria::EQUAL);
    $oUser = UserPeer::doSelectOne($oCriteria);
    if($oUser === null) {
      return 0;
    }
    if(!PasswordHash::comparePassword($sPassword, $oUser->getPassword())) {
      if(PasswordHash::comparePasswordFallback($sPassword, $oUser->getPassword())) {
        $oUser->setPassword(PasswordHash::hashPassword($sPassword));
        $oUser->save();
        return $this->login($sUsername, $sPassword);
      }
      return 0;
    }
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
      if ($this->oUser->getFirstName() == '') {
        // user firstname can only (should only) be empty if it is the default user
        $iReturnValue |= self::USER_IS_DEFAULT_USER;
      }
    }
    return $iReturnValue;
  }

  public function logout() {
    $this->oUser = null;
    $this->iUserId = null;
  }

  public function getLanguage() {
    return $this->getAttribute(self::SESSION_LANGUAGE_KEY);
  }

  public function setLanguage($sLanguage) {
    return $this->setAttribute(self::SESSION_LANGUAGE_KEY, $sLanguage);
  }

  public function setAttribute($sAttribute, $mValue) {
    if($mValue === null) {
      unset($this->aAttributes[$sAttribute]);
      return;
    }
    $this->aAttributes[$sAttribute] = $mValue;
  }
  
  public function setArrayAttributeValueForKey($sAttribute, $sKey, $mValue) {
    if(!$this->hasAttribute($sAttribute)) {
      $this->aAttributes[$sAttribute] = array();
    } else if(!is_array($this->aAttributes[$sAttribute])) {
      throw new Exception("Error in Session->setArrayAttributeValueForKey: Attribute $sAttribute is not an array");
    }
    $this->aAttributes[$sAttribute][$sKey] = $mValue;
  }

  public function getAttribute($sAttribute) {
    if(in_array($sAttribute, array('isAuthenticated', 'getUserId'))) {
      return $this->$sAttribute();
    }
    if($this->hasAttribute($sAttribute)) {
      return $this->aAttributes[$sAttribute];
    }
    return Settings::getSetting("session_default", $sAttribute, null);
  }
  
  public function getArrayAttributeValueForKey($sAttribute, $sKey) {
    if(!$this->hasAttribute($sAttribute)) {
      return null;
    } else if(!is_array($this->aAttributes[$sAttribute])) {
      throw new Exception("Error in Session->getArrayAttributeValueForKey: Attribute $sAttribute is not an array");
    }
    return @$this->aAttributes[$sAttribute][$sKey];
  }

  public function resetAttribute($sAttribute) {
    $this->setAttribute($sAttribute, null);
  }

  public function hasAttribute($sAttribute) {
    return isset($this->aAttributes[$sAttribute]);
  }

  public static function language() {
    return self::getSession()->getLanguage();
  }

  public static function getSession() {
    if(isset($_SESSION[self::SESSION_OBJECT_KEY])) {
      return $_SESSION[self::SESSION_OBJECT_KEY];
    }
    return new Session();
  }

  public function getUser() {
    return $this->oUser;
  }

  public function getUserId() {
    return $this->iUserId;
  }
}

try {
  session_name("Session".str_replace(array('/', '.'), '_', StringUtil::endsWith(MAIN_DIR_FE, '/') ? substr(MAIN_DIR_FE, 0, -1) : MAIN_DIR_FE));
  @session_start();
} catch (ClassNotFoundException $e) {
  //Tried to load class that does not exist (may be because the user’s session contains old data, clearing the session)
  foreach($_SESSION as $sSessionKey => $mSessionValue) {
    unset($_SESSION[$sSessionKey]);
  }
}