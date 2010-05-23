<?php

class WidgetJsonFileModule extends FileModule {
	
	public function __construct($aRequestPath) {
		parent::__construct($aRequestPath);
		$this->sWidgetType = Manager::usePath();
		$this->sAction = Manager::usePath();
	}
	
	public function renderFile() {
		header("Content-Type: application/json;charset=utf-8");
		$aRequest = $_REQUEST;
		if(StringUtil::startsWith($_SERVER['CONTENT_TYPE'], 'application/json')) {
			$aRequest = json_decode(file_get_contents('php://input'), true);
		}
		try {
			$sWidgetClass = WidgetModule::getClassNameByName($this->sWidgetType);
			if($this->sAction == 'widgetInformation') {
				$aInformation = array();
        $sWidgetClass::includeResources();
				$aInformation['resources'] = ResourceIncluder::defaultIncluder()->getIncludes()->render();
        $aInformation['methods'] = WidgetModule::getCustomMethods($sWidgetClass);
				$aInformation['is_singleton'] = $sWidgetClass::isSingleton();
				$aInformation['is_persistent'] = $sWidgetClass::isPersistent();
        print json_encode($aInformation);
        return;
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
				$aInformation = array();
				$aInformation['session_id'] = $oWidget->getSessionKey();
				$oWidgetContents = $oWidget->doWidget();
				if($oWidgetContents instanceof Template) {
					$oWidgetContents = $oWidgetContents->render();
				}
				$aInformation['content'] = $oWidgetContents;
				$aInformation['is_new'] = $bIsNew;
				print json_encode($aInformation);
			} else if($this->sAction === 'methodCall') {
				if($oWidget->needsLogin() && !Session::getSession()->isAuthenticated()) {
					throw new LocalizedException('module.file.widget_json.needs_login');
				}
				$sMethodName = isset($aRequest['method']) ? $aRequest['method'] : Manager::usePath();
				if(!method_exists($oWidget, $sMethodName)) {
					throw new LocalizedException('module.file.widget_json.method_does_not_exist', array('method' => $sMethodName, 'widget' => $oWidget->getName()));
				}
				print json_encode(array("result" => call_user_func_array(array($oWidget, $sMethodName), isset($aRequest['method_parameters']) ? $aRequest['method_parameters'] : array())));
			}
		} catch (LocalizedException $ex) {
			print json_encode(array('exception' => array('message' => $ex->getLocalizedMessage(), 'code' => $ex->getCode(), 'file' => $ex->getFile(), 'line' => $ex->getLine(), 'trace' => $ex->getTrace(), 'exception_type' => $ex->getExceptionType())));
		} catch (Exception $ex) {
			print json_encode(array('exception' => array('message' => "Exception when trying to execute the last action {$ex->getMessage()}", 'code' => $ex->getCode(), 'file' => $ex->getFile(), 'line' => $ex->getLine(), 'trace' => $ex->getTrace(), 'exception_type' => get_class($ex))));
		}
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