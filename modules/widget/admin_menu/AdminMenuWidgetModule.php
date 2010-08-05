<?php
/**
 * @package modules.widget
 */
class AdminMenuWidgetModule extends WidgetModule {
	public function __construct() {
		$oResourceIncluder = ResourceIncluder::defaultIncluder();
		$oResourceIncluder->addResource('admin/admin_menu.js');
	}
	
	public static function isSingleton() {
		return true;
	}
	
	public function getLoggedInName() {
		if(Session::getSession()->isAuthenticated()) {
			return Session::getSession()->getUser()->getFullName();
		}
	}
	
	public function getModuleConfig() {
    $oUser = Session::getSession()->getUser();
    $aSettings = $oUser->getAdminSettings('admin_menu');
    return $aSettings;
	}
	
	public function doWidget() {
		$oTemplate = $this->constructTemplate('menu_bar');
		if(Session::getSession()->isAuthenticated()) {
			$oTemplate->replaceIdentifier('style', 'block');
		}
		return $oTemplate;
	}
	
	public function getModuleSelector($sCurrentModuleName) {
		$aResult = array();
		// list modules with user right
		$aUseModules = array('documents','links','users', 'dashboard');
		foreach(AdminModule::listModules() as $sModuleName => $aModuleInformation) {
			if(!in_array($sModuleName, $aUseModules)) {
				continue;
			}
			$aResult[AdminModule::getDisplayNameByName($sModuleName)] = array('name' => $sModuleName, 'link' => LinkUtil::link(array($sModuleName), 'AdminManager'), 'title' => AdminModule::getDisplayNameByName($sModuleName));
		}
		ksort($aResult);
		array_unshift($aResult, array('name' => '', 'link' => LinkUtil::link(array('pages'), 'AdminManager'), 'title' => 'Verwalten und Administrieren'));
		if(!in_array($sCurrentModuleName, $aUseModules) && $sCurrentModuleName !== 'pages') {
			array_push($aResult, array('name' => $sCurrentModuleName, 'link' => LinkUtil::link(array($sCurrentModuleName), 'AdminManager'), 'title' => AdminModule::getDisplayNameByName($sCurrentModuleName)));
		}
		return $aResult;
	}
}