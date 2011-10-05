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

	public static function mayDoOperationOnObjectOfModel($sOperation, $sModelName, $mObject) {
		$sPeer = "{$sModelName}Peer";
		if(!is_object($mObject)) {
			$mObject = $sPeer::retrieveByPK($mObject);
		}
		return $sPeer::mayOperateOn(Session::getSession()->getUser(), $mObject, $sOperation);
	}

	public static function mayUpdateObjectOfModel($sModelName, $iObjectId) {
		return $this->mayDoOperationOnObjectOfModel('update', $sModelName, $iObjectId);
	}

	public static function mayDeleteObjectOfModel($sModelName, $iObjectId) {
		return $this->mayDoOperationOnObjectOfModel('delete', $sModelName, $iObjectId);
	}

	public static function mayInsertObjectOfModel($sModelName) {
		$oObject = new $sModelName();
		return $this->mayDoOperationOnObjectOfModel('insert', $sModelName, $oObject);
	}
	
	public static function mayEditPageDetails($iPageId) {
		if(!Session::getSession()->isAuthenticated()) {
			return false;
		}
		$oUser = Session::getSession()->getUser();
		return $oUser->mayEditPageDetails($iPageId);
	}

	public static function mayEditPageContents($iPageId) {
		if(!Session::getSession()->isAuthenticated()) {
			return false;
		}
		$oUser = Session::getSession()->getUser();
		return $oUser->mayEditPageContents($iPageId);
	}

	public static function mayCreateChildren($iPageId) {
		if(!Session::getSession()->isAuthenticated()) {
			return false;
		}
		$oUser = Session::getSession()->getUser();
		return $oUser->mayCreateChildren($iPageId);
	}

	public static function mayDelete($iPageId) {
		if(!Session::getSession()->isAuthenticated()) {
			return false;
		}
		$oUser = Session::getSession()->getUser();
		return $oUser->mayDelete($iPageId);
	}

	public static function mayViewPage($iPageId) {
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
