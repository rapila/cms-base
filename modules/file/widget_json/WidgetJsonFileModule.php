<?php

class WidgetJsonFileModule extends FileModule {
	
	public function __construct($aRequestPath) {
		parent::__construct($aRequestPath);
		$this->sWidgetType = Manager::usePath();
		$this->sAction = Manager::usePath();
	}
	
	public function renderFile() {
		header("Content-Type: application/json;charset=utf-8");
		$aRequest = array();
		if(isset($_SERVER['CONTENT_TYPE']) && StringUtil::startsWith($_SERVER['CONTENT_TYPE'], 'application/json')) {
			$aRequest = json_decode(file_get_contents('php://input'), true);
		} else {
			foreach($_REQUEST as $sKey => $sValue) {
				$aRequest[$sKey] = json_decode($sValue, true);
			}
		}
		$oSession = Session::getSession();
		if(!isset($aRequest['session_language']) && $oSession->isAuthenticated()) {
			$aRequest['session_language'] = $oSession->getUser()->getLanguageId();
		}
		$sPrevSessionLanguage = null;
		$sSetSessionLanguage = null;
		if(isset($aRequest['session_language'])) {
			$sPrevSessionLanguage = Session::language();
			$sSetSessionLanguage = $aRequest['session_language'];
			$oSession->setLanguage($sSetSessionLanguage);
		}
		try {
			try {
				print json_encode($this->getJSON($aRequest));
			} catch(Exception $e) {
				//Handle the gift, not the wrapping…
				if($e->getPrevious()) {
					throw $e->getPrevious();
				} else {
					throw $e;
				}
			}
		} catch (LocalizedException $ex) {
			print json_encode(array('exception' => array('message' => $ex->getLocalizedMessage(), 'code' => $ex->getCode(), 'file' => $ex->getFile(), 'line' => $ex->getLine(), 'trace' => $ex->getTrace(), 'parameters' => $ex->getMessageParameters(), 'exception_type' => $ex->getExceptionType())));
		} catch (Exception $ex) {
			ErrorHandler::handleException($ex, true);
			print json_encode(array('exception' => array('message' => "Exception when trying to execute the last action {$ex->getMessage()}", 'code' => $ex->getCode(), 'file' => $ex->getFile(), 'line' => $ex->getLine(), 'trace' => $ex->getTrace(), 'exception_type' => get_class($ex))));
		}
		//If we changed the session language and no widget willfully changed it as well, reset it to the previous state
		if($sPrevSessionLanguage !== null && Session::language() === $sSetSessionLanguage) {
			$oSession->setLanguage($sPrevSessionLanguage);
		}
	}
	
	private function getJSON(&$aRequest) {
		if($this->sAction === 'destroy') {
			foreach($aRequest['session_key'] as $sSessionKey) {
				Session::getSession()->setArrayAttributeValueForKey(WidgetModule::WIDGET_SESSION_KEY, $sSessionKey, null);
			}
			return;
		}
		$sWidgetClass = WidgetModule::getClassNameByName($this->sWidgetType);
		if($this->sAction == 'widgetInformation') {
			$aInformation = array();
			$sWidgetClass::includeResources();
			$aInformation['resources'] = ResourceIncluder::defaultIncluder()->getIncludes()->render();
			$aInformation['methods'] = WidgetModule::getCustomMethods($sWidgetClass);
			$aInformation['is_singleton'] = $sWidgetClass::isSingleton();
			$aInformation['is_persistent'] = $sWidgetClass::isPersistent();
			return $aInformation;
		}
		if($this->sAction == 'staticMethodCall') {
			$this->checkPermissions($sWidgetClass);
			$sMethodName = isset($aRequest['method']) ? $aRequest['method'] : Manager::usePath();
			if(!method_exists($sWidgetClass, $sMethodName)) {
				throw new LocalizedException('wns.file.widget_json.method_does_not_exist', array('method' => $sMethodName, 'widget' => $sWidgetClass));
			}
			return array("result" => call_user_func_array(array($sWidgetClass, $sMethodName), isset($aRequest['method_parameters']) ? $aRequest['method_parameters'] : array()));
		} 
		$oWidget = null;
		if(isset($aRequest['session_key'])) {
			$oWidget = Session::getSession()->getArrayAttributeValueForKey(WidgetModule::WIDGET_SESSION_KEY, $aRequest['session_key']);
		}
		$bIsNew = $oWidget === null;
		if($bIsNew) {
			$aInstanceArgs = array(@$aRequest['session_key']);
			if(isset($aRequest['instance_args'])) {
				$aInstanceArgs = $aRequest['instance_args'];
			}
			$aNewArgs = array_merge(array($this->sWidgetType), $aInstanceArgs);
			$oWidget = call_user_func_array(array('WidgetModule', 'getModuleInstance'), $aNewArgs);
		}
		if($this->sAction === 'instanciateWidget') {
			$this->checkPermissions($sWidgetClass);
			$aInformation = array();
			$aInformation['session_id'] = $oWidget->getSessionKey();
			$oWidgetContents = $oWidget->doWidget();
			if($oWidgetContents instanceof Template) {
				$oWidgetContents = $oWidgetContents->render();
			}
			$aInformation['content'] = $oWidgetContents;
			$aInformation['is_new'] = $bIsNew;
			$aInformation['initial_settings'] = $oWidget->allSettings();
			return $aInformation;
		}
		if($this->sAction === 'methodCall') {
			$this->checkPermissions($sWidgetClass);
			$sMethodName = isset($aRequest['method']) ? $aRequest['method'] : Manager::usePath();
			if(!method_exists($oWidget, $sMethodName)) {
				throw new LocalizedException('wns.file.widget_json.method_does_not_exist', array('method' => $sMethodName, 'widget' => $oWidget->getName()));
			}
			return array("result" => call_user_func_array(array($oWidget, $sMethodName), isset($aRequest['method_parameters']) ? $aRequest['method_parameters'] : array()));
		}
	}
	
	private function checkPermissions($sWidgetClass) {
		if(!$sWidgetClass::needsLogin()) {
			return;
		}
		$oUser = Session::getSession()->getUser();
		if($oUser !== null) {
			if(Module::isModuleAllowed('widget', $this->sWidgetType, $oUser)) {
				return;
			}
		}
		throw new LocalizedException('wns.file.widget_json.needs_login', null, 'needs_login');
	}
	
	public static function jsonBaseObjects($aBaseObjects, $aOriginalColumnNames) {
		if($aBaseObjects instanceof PropelCollection) {
			$aBaseObjects = $aBaseObjects->getArrayCopy();
		}
		$aResult = array();
		$aColumnNames = array();
		foreach($aOriginalColumnNames as $mIdentifier => $sColumnName) {
			if(is_numeric($mIdentifier)) {
				$mIdentifier = $sColumnName;
			}
			$aColumnNames[$mIdentifier] = 'get'.StringUtil::camelize($sColumnName, true);
		}
		foreach($aBaseObjects as $oBaseObect) {
			if(!($oBaseObect instanceof BaseObject)) {
				$aResult[] = $oBaseObect;
				continue;
			}
			$aResult[] = array();
			foreach($aColumnNames as $sColumnName => $sGetterName) {
				$aResult[count($aResult)-1][$sColumnName] = $oBaseObect->$sGetterName();
			}
		}
		return $aResult;
	}
}
