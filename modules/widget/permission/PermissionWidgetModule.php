<?php
/**
 * @package modules.widget
 */
class PermissionWidgetModule extends WidgetModule {
	public static function moduleIsGranted($sModuleName, $sModuleType = 'widget') {
		Module::isModuleAllowed($sModuleType, $sModuleName, Session::getSession()->getUser());
	}
	
	public static function userHasRole($sRoleKey) {
		if(!Session::getSession()->isAuthenticated()) {
			return false;
		}
		$oUser = Session::getSession()->getUser();
		return $oUser->hasRole($sRoleKey);
	}
	
	public function mayEditPageDetails($iPageId) {
		if(!Session::getSession()->isAuthenticated()) {
			return false;
		}
		$oUser = Session::getSession()->getUser();
		return $oUser->mayEditPageDetails($iPageId);
	}

	public function mayEditPageContents($iPageId) {
		if(!Session::getSession()->isAuthenticated()) {
			return false;
		}
		$oUser = Session::getSession()->getUser();
		return $oUser->mayEditPageContents($iPageId);
	}

	public function mayCreateChildren($iPageId) {
		if(!Session::getSession()->isAuthenticated()) {
			return false;
		}
		$oUser = Session::getSession()->getUser();
		return $oUser->mayCreateChildren($iPageId);
	}

	public function mayDelete($iPageId) {
		if(!Session::getSession()->isAuthenticated()) {
			return false;
		}
		$oUser = Session::getSession()->getUser();
		return $oUser->mayDelete($iPageId);
	}

	public function mayViewPage($iPageId) {
		if(!Session::getSession()->isAuthenticated()) {
			return false;
		}
		$oUser = Session::getSession()->getUser();
		return $oUser->mayViewPage($iPageId);
	}
	
	public static function isSingleton() {
		return true;
	}
}