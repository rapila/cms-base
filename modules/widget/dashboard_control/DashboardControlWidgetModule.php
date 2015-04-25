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

	public function possibleTemplates() {
		$aResult = array();
		foreach(ResourceFinder::findResourceObjectsByExpressions(array(DIRNAME_MODULES, AdminModule::getType(), AdminModule::getNameByClassName('DashboardAdminModule'), DIRNAME_TEMPLATES, 'layouts', '/^[\\w_\\d-]+\.tmpl$/')) as $oResource) {
			$aResult[] = $oResource->getFileName('.tmpl');
		}

		return $aResult;
	}

	public function layoutTemplate() {
		$sLayoutName = self::getLayoutName();
		if(isset($aDashboardConfig['layout'])) {
			$sLayoutName = $aDashboardConfig['layout'];
		}
		return Module::constructTemplateForModuleAndType(AdminModule::getType(), AdminModule::getNameByClassName('DashboardAdminModule'), 'layouts/'.$sLayoutName)->render();
	}

	public function setLayoutName($sLayoutName) {
		self::layoutName($sLayoutName);
	}

	public function getLayoutName() {
		return self::layoutName();
	}

	public static function layoutName($sNewLayoutName = null) {
		$oUser = Session::getSession()->getUser();
		$aDashboardConfig = $oUser->getAdminSettings('dashboard');
		if($sNewLayoutName !== null) {
			if($aDashboardConfig['layout'] === $sNewLayoutName) {
				return true;
			}
			$aDashboardConfig['layout'] = $sNewLayoutName;
			$oUser->setAdminSettings('dashboard', $aDashboardConfig);
			return $oUser->save();
		} else {
			$sLayoutName = '3columns';
			if(isset($aDashboardConfig['layout'])) {
				$sLayoutName = $aDashboardConfig['layout'];
			}
			return $sLayoutName;
		}
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
		$iInsertionKey = null;
		foreach($aWidgets as $iKey => &$aWidget) {
			if($iCounter === $iPosition) {
				$iInsertionKey--;
				break;
			}
			$iInsertionKey++;
			if($aWidget['container'] === $sContainer) {
				$iCounter++;
			}
		}
		if($iInsertionKey === null) {
			$iInsertionKey = 0;
		} else {
			$iInsertionKey++;
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
		UserPeer::ignoreRights(true);
		$oUser->save();
		UserPeer::ignoreRights(false);
	}

	public function listDashboardModules($bFilterByAllowed = false) {
		$aResult = array();
		foreach(WidgetModule::listModulesByAspect('dashboard') as $aModuleInfo) {
			if($bFilterByAllowed && !Module::isModuleAllowed('widget', $aModuleInfo['name'], Session::getSession()->getUser())) {
				continue;
			}
			$aResult[$aModuleInfo['name']] = Module::getDisplayNameByTypeAndName(WidgetModule::getType(), $aModuleInfo['name']);
		}
		return $aResult;
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

	public function documentationData($sDocumentationName) {
		return DocumentationProviderTypeModule::dataForPart($sDocumentationName, Session::language());
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
		UserPeer::ignoreRights(true);
		$oUser->save();
		UserPeer::ignoreRights(false);
	}
}