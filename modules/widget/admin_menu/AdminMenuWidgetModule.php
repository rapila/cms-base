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
	
	public function doWidget() {
		$oTemplate = $this->constructTemplate('menu_bar');
		if(Session::getSession()->isAuthenticated()) {
			$oTemplate->replaceIdentifier('style', 'block');
		}
		return $oTemplate;
	}
	
	public function getModuleSelector() {
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
		array_unshift($aResult, array('name' => 'pages', 'link' => LinkUtil::link(array('pages'), 'AdminManager'), 'title' => 'Verwalten und Administrieren'));
		return $aResult;
	}
}