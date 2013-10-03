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
		$sQuery = "{$sModelName}Query";
		if(!is_object($mObject)) {
			$mObject = $sQuery::create()->findPk($mObject);
		}
		return $mObject->mayOperate($sOperation, $mObject);
	}

	public static function mayUpdateObjectOfModel($sModelName, $iObjectId) {
		return self::mayDoOperationOnObjectOfModel('update', $sModelName, $iObjectId);
	}

	public static function mayDeleteObjectOfModel($sModelName, $iObjectId) {
		return self::mayDoOperationOnObjectOfModel('delete', $sModelName, $iObjectId);
	}

	public static function mayInsertObjectOfModel($sModelName) {
		$oObject = new $sModelName();
		return self::mayDoOperationOnObjectOfModel('insert', $sModelName, $oObject);
	}
	
	public static function mayEditPageDetails($iPageId) {
		$oUser = Session::getSession()->getUser();
		return $oUser->mayEditPageDetails($iPageId);
	}

	public static function mayEditPageDetailsAndDelete($iPageId) {
		$oUser = Session::getSession()->getUser();
		return array($oUser->mayEditPageDetails($iPageId), $oUser->mayDelete($iPageId));
	}

	public static function mayEditPageContents($iPageId) {
		$oUser = Session::getSession()->getUser();
		return $oUser->mayEditPageContents($iPageId);
	}

	public static function mayEditPageStructure($iPageId) {
		if(!Session::getSession()->isAuthenticated()) {
			return false;
		}
		$oUser = Session::getSession()->getUser();
		return $oUser->mayEditPageStructure($iPageId);
	}

	public static function mayCreateChildren($iPageId) {
		$oUser = Session::getSession()->getUser();
		return $oUser->mayCreateChildren($iPageId);
	}

	public static function mayDelete($iPageId) {
		$oUser = Session::getSession()->getUser();
		return $oUser->mayDelete($iPageId);
	}

	public static function mayViewPage($iPageId) {
		$oUser = Session::getSession()->getUser();
		return $oUser->mayViewPage($iPageId);
	}
	
	public static function isSingleton() {
		return true;
	}
}
