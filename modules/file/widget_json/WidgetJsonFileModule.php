<?php

class WidgetJsonFileModule extends FileModule {

	public static $JSON_ERRORS = array();

	public function __construct($aRequestPath) {
		parent::__construct($aRequestPath);
		$this->sWidgetType = Manager::usePath();
		$this->sAction = Manager::usePath();
	}

	public function renderFile() {
		header("Content-Type: application/json;charset=utf-8");
		$aRequest = array();
		$sContentType = 'application/x-www-form-urlencoded';
		if(isset($_SERVER['CONTENT_TYPE'])) {
			$sContentType = $_SERVER['CONTENT_TYPE'];
		}
		if(isset($_SERVER['HTTP_CONTENT_TYPE'])) {
			$sContentType = $_SERVER['HTTP_CONTENT_TYPE'];
		}
		if(StringUtil::startsWith($sContentType, 'application/json')) {
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
				$mJSONData = $this->getJSON($aRequest);
				$sResult = json_encode($mJSONData);
				$iError = json_last_error();
				if($iError !== JSON_ERROR_NONE) {
					throw new LocalizedException('wns.error.json', array('json_error' => $iError, 'json_error_message' => self::$JSON_ERRORS[$iError]));
				}
				print $sResult;
			} catch(Exception $e) {
				//Handle the gift, not the wrapping…
				if($e->getPrevious()) {
					throw $e->getPrevious();
				} else {
					throw $e;
				}
			}
		} catch (LocalizedException $ex) {
			LinkUtil::sendHTTPStatusCode(500, 'Server Error');
			print json_encode(array('exception' => array('message' => $ex->getLocalizedMessage(), 'code' => $ex->getCode(), 'file' => $ex->getFile(), 'line' => $ex->getLine(), 'trace' => $ex->getTrace(), 'parameters' => $ex->getMessageParameters(), 'exception_type' => $ex->getExceptionType())));
		} catch (Exception $ex) {
			LinkUtil::sendHTTPStatusCode(500, 'Server Error');
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
		$bIsPersistent = $sWidgetClass::isPersistent();
		if(!$bIsPersistent) {
			// Close session early on readonly calls
			Session::close();
		}

		if($this->sAction == 'widgetInformation') {
			$aInformation = array();
			$sWidgetClass::includeResources();
			$aInformation['resources'] = ResourceIncluder::defaultIncluder()->getIncludes()->render();
			$aInformation['methods'] = $sWidgetClass::getCustomMethods();
			$aInformation['is_singleton'] = $sWidgetClass::isSingleton();
			$aInformation['is_persistent'] = $bIsPersistent;
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
		$aInstanceArgs = array(@$aRequest['session_key']);
		if(isset($aRequest['instance_args'])) {
			$aInstanceArgs = $aRequest['instance_args'];
		}
		$aNewArgs = array_merge(array($this->sWidgetType), $aInstanceArgs);
		$oWidget = call_user_func_array(array('WidgetModule', 'getWidget'), $aNewArgs);
		if($this->sAction === 'instanciateWidget') {
			$this->checkPermissions($sWidgetClass);
			$aInformation = array();
			$aInformation['session_id'] = $oWidget->getSessionKey();
			$oWidgetContents = $oWidget->doWidget();
			if($oWidgetContents instanceof Template) {
				$oWidgetContents = $oWidgetContents->render();
			}
			$aInformation['content'] = $oWidgetContents;
			$aInformation['is_new'] = $oWidget->isNew();
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
		if(!Session::getSession()->isAuthenticated()) {
			throw new LocalizedException('wns.file.widget_json.needs_login', null, 'needs_login');
		}
		throw new LocalizedException("wns.file.widget_json.check_permissions", array('widget' => $this->sWidgetType));
	}

	public static function jsonOrderedObject($aObject) {
		$aResult = array();
		foreach($aObject as $sKey => $mValue) {
			$aResult[] = array('key' => $sKey, 'value' => $mValue);
		}
		return $aResult;
	}

	public static function jsonBaseObjects($aBaseObjects, $aOriginalColumnNames) {
		if($aBaseObjects instanceof PropelCollection) {
			$aBaseObjects = $aBaseObjects->getArrayCopy();
		}
		$aResult = array();
		$aColumnNames = array();
		foreach($aOriginalColumnNames as $mIdentifier => $sColumnName) {
			$aArgs = [];
			if(is_array($sColumnName)) {
				$aArgs = $sColumnName['args'];
				$sColumnName = $sColumnName['column'];
				if(is_callable($aArgs)) {
					$aArgs = $aArgs();
				}
			}
			if(is_numeric($mIdentifier)) {
				$mIdentifier = $sColumnName;
			}
			$aColumnNames[$mIdentifier] = array(
				'getter' => 'get'.StringUtil::camelize($sColumnName, true),
				'args' => $aArgs
			);
		}
		foreach($aBaseObjects as $oBaseObect) {
			if(!($oBaseObect instanceof BaseObject)) {
				$aResult[] = $oBaseObect;
				continue;
			}
			$aResult[] = array();
			foreach($aColumnNames as $sColumnName => $aOptions) {
				$sGetterName = $aOptions['getter'];
				$aArgs = $aOptions['args'];
				$aResult[count($aResult)-1][$sColumnName] = $oBaseObect->$sGetterName(...$aArgs);
			}
		}
		return $aResult;
	}
}

{
	$aJsonErrorConstants = get_defined_constants();
	foreach($aJsonErrorConstants as $sJsonErrorConstant => $iJsonErrorConstantValue) {
		if(StringUtil::startsWith($sJsonErrorConstant, 'JSON_ERROR_')) {
			WidgetJsonFileModule::$JSON_ERRORS[$iJsonErrorConstantValue] = $sJsonErrorConstant;
		}
	}
}
