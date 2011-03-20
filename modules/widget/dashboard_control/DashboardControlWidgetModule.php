<?php

class DashboardControlWidgetModule extends WidgetModule {
	
	public function allDashboardModules() {
		$aDashboardConfig = self::dashboardConfig();
		$aWidgets = &$aDashboardConfig['widgets'];
		$bDidAddIds = false;
		foreach($aWidgets as &$aWidget) {
			if(!isset($aWidget['uid'])) {
				$bDidAddIds = true;
				$aWidget['uid'] = Util::uuid();
			}
		}
		if($bDidAddIds) {
			$oUser = Session::getSession()->getUser();
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
	
	public function saveSettings($sUid, $aSettings) {
		self::saveModuleSettings($sUid, $aSettings);
	}
	
	public function changeCollapsed($sUid, $bCollapsed) {
		$aSettings = self::moduleSettingsByUid($sUid);
		$aSettings['collapsed'] = $bCollapsed;
		self::saveModuleSettings($sUid, $aSettings);
	}
	
	public function move($sUid, $sContainer, $iPosition) {
		$aDashboardConfig = self::dashboardConfig();
		$aSettings = null;
		$aWidgets = &$aDashboardConfig['widgets'];
		// Step 1: Remove said widget from all widgets
		foreach($aWidgets as $iKey => &$aWidget) {
			if($aWidget['uid'] === $sUid) {
				$aSettings = $aWidget;
				unset($aWidgets[$iKey]);
				break;
			}
		}
		//Step 2: Change the container
		$aSettings['container'] = &$sContainer;
		
		//Step 3: Find new position
		$iCounter = 0;
		$iInsertionKey = 0;
		foreach($aWidgets as $iKey => &$aWidget) {
			if($iCounter === $iPosition) {
				$iInsertionKey = $iKey;
				break;
			}
			if($aWidget['container'] === $sContainer) {
				$iCounter++;
			}
		}
		
		// Step 4: Re-Insert
		array_splice($aWidgets, $iInsertionKey, 0, array($aSettings));
		
		$oUser = Session::getSession()->getUser();
		$oUser->setAdminSettings('dashboard', $aDashboardConfig);
		$oUser->save();
	}
	
	public function remove($sUid) {
		$aDashboardConfig = self::dashboardConfig();
		$aWidgets = &$aDashboardConfig['widgets'];
		// Step 1: Remove said widget from all widgets
		foreach($aWidgets as $iKey => &$aWidget) {
			if($aWidget['uid'] === $sUid) {
				unset($aWidgets[$iKey]);
				break;
			}
		}
		$aDashboardConfig['widgets'] = array_values($aWidgets);
		$oUser = Session::getSession()->getUser();
		$oUser->setAdminSettings('dashboard', $aDashboardConfig);
		$oUser->save();
	}
	
	public function add($aSettings) {
		
	}
	
	private static function dashboardConfig() {
		$oUser = Session::getSession()->getUser();
		$aDashboardConfig = $oUser->getAdminSettings('dashboard');
		if(!isset($aDashboardConfig['widgets'])) {
			$aDashboardConfig['widgets'] = array();
		}
		return $aDashboardConfig;
	}
	
	private static function moduleSettingsByUid($sUid) {
		$aDashboardConfig = self::dashboardConfig();
		$aWidgets = &$aDashboardConfig['widgets'];
		foreach($aWidgets as &$aWidget) {
			if($aWidget['uid'] === $sUid) {
				return $aWidget;
			}
		}
		return array();
	}
	
	private static function saveModuleSettings($sUid, $aSettings) {
		$oUser = Session::getSession()->getUser();
		$aDashboardConfig = self::dashboardConfig();
		$aWidgets = &$aDashboardConfig['widgets'];
		$bFoundExisting = false;
		foreach($aWidgets as $iKey => &$aWidget) {
			if($aWidget['uid'] === $sUid) {
				$aWidgets[$iKey] = $aSettings;
				$bFoundExisting = true;
				break;
			}
		}
		if(!$bFoundExisting) {
			$aWidgets[] = $aSettings;
		}
		$oUser->setAdminSettings('dashboard', $aDashboardConfig);
		$oUser->save();
	}
}