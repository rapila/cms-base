<?php
class LoginFrontendConfigWidgetModule extends FrontendConfigWidgetModule {
	public function getDisplayOptions() {
		$aResult = array();
		foreach(ResourceFinder::findResourceObjectsByExpressions(array(DIRNAME_MODULES, FrontendModule::getType(), FrontendModule::getNameByClassName('LoginFrontendModule'), DIRNAME_TEMPLATES, '/^[\\w_\\d-]+\.tmpl$/')) as $oResource) {
			$sFileName = $oResource->getFileName('.tmpl');
			if(strpos($sFileName, '_action_') !== false) {
				continue;
			}
			$aResult[$sFileName] = StringUtil::makeReadableName($sFileName);
		}

		return $aResult;
	}

	public function getLoginDisplayMode() {
		$sResult = $this->configData();
		$sResult = $sResult[LoginFrontendModule::MODE_SELECT_KEY];
		return $sResult;
	}
}
