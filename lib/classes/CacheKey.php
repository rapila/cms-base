<?php

/**
* Construct a sensible cache key that depends on a series of input variables
*/
class CacheKey {
	private $aVars = array();
	
	private function __construct() {}
	
	/**
	* Quickly create an instance
	*/
	public static function create() {
		return new CacheKey();
	}
	
	/**
	* Make this cache key depend on a request param (or a series thereof).
	* @param string…|array $sVar variable names
	*/
	public function dependOnRequestParameter($sVar) {
		if(is_array($sVar)) {
			$aVar = $sVar;
		} else {
			$aVar = func_get_args();
		}
		foreach($sVar as $sVarName) {
			$sValue = '';
			if(isset($_REQUEST[$sVar])) {
				$sValue = $_REQUEST[$sVar];
			}
			$this->aVars['request_'.$sVarName] = $sValue;
		}
		return $this;
	}
	
	/**
	* Make the cache key depend on the current session language
	*/
	public function dependOnLanguage() {
		$this->aVars['language'] = Session::language();
		return $this;
	}
	
	/**
	* Make the cache key depend on a navigation item’s path.
	* @param NavigationItem $oNavigationItem the navigation item to be dependent on (defaults to the frontend manager’s current navigation item)
	*/
	public function dependOnPath($oNavigationItem = null) {
		if($oNavigationItem === null) {
			$oNavigationItem = FrontendManager::$CURRENT_NAVIGATION_ITEM;
		}
		$this->aVars['path'] = implode('/', $oNavigationItem->getLink());
		return $this;
	}
	
	/**
	* 
	*/
	public function dependOnCustom($sName, $mValue) {
		$this->aVars['custom_'.$sName] = $mValue;
	}
	
	/**
	* Make the cache depend on the currently logged in user.
	* @param User|int $iUser the user this cache content depends on.
	* Note: It might not be very efficient to cache user-dependent content on systems with a high number of distinct users
	*/
	public function dependOnUser($iUser = false) {
		if($iUser === false) {
			$iUser = Session::user(false);
		}
		if($iUser instanceof User) {
			$iUser = $iUser->getId();
		}
		if($iUser === null) {
			$this->aVars['user'] = null;
		} else {
			$this->aVars['user'] = (int)$iUser;
		}
		return $this;
	}
	
	/**
	* Depend this cache’s contents on whether or not a user is logged in
	*/
	public function dependOnLoggedIn() {
		$this->aVars['logged_in'] = Session::getSession()->isAuthenticated();
		return $this;
	}
	
	/**
	* Render this cache key into a string. An optional prefix will be prepended.
	*/
	public function render($sPrefix = '') {
		ksort($this->aVars);
		return $sPrefix.'_'.serialize($this->aVars);
	}
}