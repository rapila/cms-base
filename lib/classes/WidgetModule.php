<?php
abstract class WidgetModule extends Module {
	
	const WIDGET_SESSION_KEY = 'widget_storage';
	
	protected static $MODULE_TYPE = 'widget';
	
	protected $sPersistentSessionKey = null;
	protected $sInputName = null;
	
	public function __construct($sSessionKey = null) {
		if(static::isPersistent()) {
			if($sSessionKey === null) {
				$this->sPersistentSessionKey = get_class($this);
				if(!call_user_func(array($this->sPersistentSessionKey, 'isSingleton'))) {
					$this->sPersistentSessionKey .= "_".Util::uuid();
				}
			} else {
				$this->sPersistentSessionKey = $sSessionKey;
			}
			Session::getSession()->setArrayAttributeValueForKey(self::WIDGET_SESSION_KEY, $this->sPersistentSessionKey, $this);
		}
	}
	
	public function doWidget() {
		try {
			$oTemplate = $this->constructTemplate();
			$oTemplate->replaceIdentifier('session_key', $this->sPersistentSessionKey);
			$oTemplate->replaceIdentifier('input_name', $this->sInputName);
			return $oTemplate;
		} catch(Exception $e) {
			return null;
		}
	}
	
	public static function includeResources($oResourceIncluder = null) {
		self::includeWidgetResources(false, $oResourceIncluder);
	}
	
	protected static function includeWidgetResources($bEndDependenciesOnJS = false, $oResourceIncluder = null) {
	  // attention: php::get_called_class() requires PHP5.3
		TemplateResourceFileModule::includeAvailableResources(get_called_class(), $bEndDependenciesOnJS, $oResourceIncluder);
	}
	
	public static function isPersistent() {
		return false;
	}
	
	public function needsLogin() {
		return true;
	}
	
	public function setInputName($sInputName) {
			$this->sInputName = $sInputName;
	}

	public function getInputName() {
			return $this->sInputName;
	}
	
	public function getSessionKey() {
			return $this->sPersistentSessionKey;
	}
	
	public static function getCustomMethods($sClassName) {
		return array_merge(array_diff(get_class_methods($sClassName), get_class_methods('WidgetModule')), array('getInputName', 'setInputName'));
	}
	
	public static function removeStoredWidgets() {
		Session::getSession()->setAttribute(self::WIDGET_SESSION_KEY, array());
	}
	
	public static function getWidget($sWidgetType, $sSessionKey = null) {
		if($sSessionKey !== null) {
			$oWidget = Session::getSession()->getArrayAttributeValueForKey(WidgetModule::WIDGET_SESSION_KEY, $sSessionKey);
			if($oWidget !== null) {
				return $oWidget;
			}
		}
		$sWidgetClass = self::getClassNameByName($sWidgetType);
		$aArgs = func_get_args();
		array_shift($aArgs);
		if(!$sWidgetClass::isPersistent()) {
			array_shift($aArgs);
		}
		array_unshift($aArgs, $sWidgetType);
		return call_user_func_array(array("WidgetModule", "getModuleInstance"), $aArgs);
	}
}