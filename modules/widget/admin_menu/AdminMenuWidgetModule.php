<?php
/**
 * @package modules.widget
 */
class AdminMenuWidgetModule extends WidgetModule {
	public function __construct() {
	  $this->setSetting('current_manager', Manager::getManagerClassNormalized());
		$oResourceIncluder = ResourceIncluder::defaultIncluder();
		$oResourceIncluder->addResource('admin/admin_menu.js');
	}
	
	public static function isSingleton() {
		return true;
	}
	
	public function getUserInfo() {
		if(Session::getSession()->isAuthenticated()) {
			$aResult['FullName'] = Session::getSession()->getUser()->getFullName();
			$aResult['Id'] = Session::getSession()->getUserId();
			return $aResult;
		}
	}
	
	public function getModuleConfig() {
		$oUser = Session::getSession()->getUser();
		$aSettings = $oUser->getAdminSettings('admin_menu');
		foreach($aSettings as $sSection => &$aConfig) {
			$this->cleanModules($aConfig);
		}
		return $aSettings;
	}
	
	private function cleanModules(&$aSettings) {
		foreach($aSettings as $iKey => &$mValue) {
			if(is_array($mValue)) {
				$this->cleanModules($mValue);
			} else if(is_string($mValue) && StringUtil::startsWith($mValue, 'module.')) {
				$sModuleName = substr($mValue, strlen('module.'));
				if(!Module::isModuleAllowed('admin', $sModuleName, Session::getSession()->getUser())) {
					unset($aSettings[$iKey]);
				}
			}
		}
		$aSettings = array_values($aSettings);
	}
	
	public function doWidget() {
		$oTemplate = $this->constructTemplate('menu_bar');
		if(Session::getSession()->isAuthenticated()) {
			$oTemplate->replaceIdentifier('style', 'block');
		}
		return $oTemplate;
	}
	
	public function getModule($sName) {
		$aResult = array('link' => LinkUtil::link(array($sName), 'AdminManager'), 'title' => AdminModule::getDisplayNameByName($sName), 'may' => Session::getSession()->getUser()->mayUseAdminModule($sName));
		return $aResult;
	}
	
	public function getPreviewLink() {
		return LinkUtil::link(self::getPageFullPathArray(), 'PreviewManager', array(), false);
	}
	
	private static function getPageFullPathArray() {
	  $oPage = PagePeer::retrieveByPK(Session::getSession()->getAttribute('persistent_page_id'));
		return ($oPage ? $oPage->getFullPathArray() : array());
	}
	
	public function getPageLink() {
		return LinkUtil::link(self::getPageFullPathArray(), 'FrontendManager', array(), true);
	}
}