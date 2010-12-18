<?php
class LoginEditWidgetModule extends EditWidgetModule {

	public function __construct($sSessionKey, $oFrontendModule) {
		parent::__construct($sSessionKey, $oFrontendModule);
	}

	public function getDisplayOptions() {
		$aResult = array();
		foreach(LoginFrontendModule::$DISPLAY_OPTIONS as $sDisplayOption) {
			$aResult[$sDisplayOption] = StringPeer::getString('widget.option.'.$sDisplayOption);
		}
		return $aResult;
	}
	
}