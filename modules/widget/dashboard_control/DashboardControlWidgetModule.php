<?php

class DashboardControlWidgetModule extends WidgetModule {
	
	public function allDashboardModules() {
		$oUser = Session::getSession()->getUser();
		$aDashboardConfig = $oUser->getAdminSettings('dashboard');
		$aWidgets = array();
		if(isset($aDashboardConfig['widgets'])) {
			$aWidgets = &$aDashboardConfig['widgets'];
		}
		$bDidAddIds = false;
		foreach($aWidgets as &$aWidget) {
			if(!isset($aWidget['uid'])) {
				$bDidAddIds = true;
				$aWidget['uid'] = Util::uuid();
			}
		}
		if($bDidAddIds) {
			$oUser->setAdminSettings('dashboard', $aDashboardConfig);
			$oUser->save();
		}
		return $aWidgets;
	}
	
	public function template() {
		$oUser = Session::getSession()->getUser();
		$aDashboardConfig = $oUser->getAdminSettings('dashboard');
		$sLayoutName = '1column';
		if(isset($aDashboardConfig['layout'])) {
			$sLayoutName = $aDashboardConfig['layout'];
		}
		return Module::constructTemplateForModuleAndType(AdminModule::getType(), AdminModule::getNameByClassName('DashboardAdminModule'), 'layouts/'.$sLayoutName)->render();
	}
	
	public function saveConfig($aConfig) {
		
	}
}