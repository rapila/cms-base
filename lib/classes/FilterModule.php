<?php
/**
* FilterModule is responsible for running callback functions in various parts of the CMS to handle specific events.
* Filters are called as follows: FilterModule::getFilters()->handle<Event>($aArguments = array())
* Each filter that has a on<Event> event handler is then being called
*/
abstract class FilterModule extends Module {
	protected static $MODULE_TYPE = 'filter';
	private static $FILTERS = null;
	
	public static function getFilters() {
		if(self::$FILTERS === null) {
			$oCache = new Cache("preconfigured_filter_handlers", DIRNAME_PRELOAD);
			if($oCache->entryExists()) {
				self::$FILTERS = $oCache->getContentsAsVariable();
			} else {
				self::$FILTERS = new Filters();
				$oCache->setContents(self::$FILTERS);
			}
		}
		return self::$FILTERS;
	}

	public static function isSingleton() {
		return true;
	}
}

class Filters {
	private $aRegisteredCallbacks;
	private static $EMPTY_ARRAY = array();
	
	public function __construct() {
		$this->aRegisteredCallbacks = array();
		$aFilterModules = FilterModule::listModules();
		foreach($aFilterModules as $sFilterModuleName => $aModuleMetadata) {
			$oFileModuleInstance = FilterModule::getModuleInstance($sFilterModuleName);
			foreach(get_class_methods($oFileModuleInstance) as $sMethodName) {
				if(strlen($sMethodName) < 5 || !StringUtil::startsWith($sMethodName, 'on') || (strtoupper($sMethodName[2]) !== $sMethodName[2])) {
					continue;
				}
				$sEventName = substr($sMethodName, strlen('on'));
				$this->appendHandler($sEventName, array($oFileModuleInstance, $sMethodName));
			}
		}
	}
	
	private function &getCallbacksForEvent($sEventName) {
		if(!isset($this->aRegisteredCallbacks[$sEventName])) {
			return self::$EMPTY_ARRAY;
		}
		return $this->aRegisteredCallbacks[$sEventName];
	}
	
	public function appendHandler($sEventName, $cCallback) {
		if(!isset($this->aRegisteredCallbacks[$sEventName])) {
			$this->aRegisteredCallbacks[$sEventName] = array();
		}
		$this->aRegisteredCallbacks[$sEventName][] = $cCallback;
	}
	
	public function doHandleEvent($sEventName, $aArguments) {
		$iResult = 0;
		foreach($this->getCallbacksForEvent($sEventName) as $cCallback) {
			$mReturn = call_user_func_array($cCallback, $aArguments);
			$iResult++;
		}
		return $iResult;
	}
	
	public function __call($sMethodName, $aParameters) {
		//Event name
		if(!StringUtil::startsWith($sMethodName, 'handle')) {
			return 0;
		}
		$sEventName = substr($sMethodName, strlen('handle'));
		
		return $this->doHandleEvent($sEventName, $aParameters);
	}
}