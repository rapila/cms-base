<?php
/**
 * @package modules.widget
 */
class AdminMenuWidgetModule extends PersistentWidgetModule {
	private $bPreview;
	
	public function __construct($bPreview = false) {
		parent::__construct(null);
		$this->bPreview = $bPreview;
		$this->setSetting('current_manager', Manager::getManagerClassNormalized());
		$oResourceIncluder = ResourceIncluder::defaultIncluder();
		$oResourceIncluder->addResource('admin/admin_menu.js');
	}
	
	public static function isSingleton() {
		return true;
	}
	
	private function getUserInfo() {
		if(Session::getSession()->isAuthenticated()) {
			$aResult['FullName'] = Session::getSession()->getUser()->getFullName();
			$aResult['Id'] = Session::getSession()->getUserId();
			return $aResult;
		}
	}
	
	public function getModuleConfig() {
		$oUser = Session::getSession()->getUser();
		$aSettings = $oUser->getAdminSettings('admin_menu');
		$aResult = array();
		foreach($aSettings as $sSection => &$aConfig) {
			$aRes = array();
			$this->cleanModules($aConfig, $aRes);
			$aResult[$sSection] = $aRes;
		}
		return $aResult;
	}
	
	private function cleanModules($aSettings, &$aResult = array()) {
		foreach($aSettings as $iKey => &$mValue) {
			if(is_array($mValue)) {
				$aRes = array();
				$this->cleanModules($mValue, $aRes);
				$aResult[] = array('type' => 'menu', 'args' => array($aRes));
			} else if(is_string($mValue)) {
				if($mValue === 'edit') {
					$mValue = "module.pages";
				}
				$aArgs = explode('.', $mValue);
				$sType = array_shift($aArgs);
				$aInfo = array();
				if($sType === 'module') {
					$sModuleName = $aArgs[0];
					if(!Module::isModuleAllowed('admin', $sModuleName, Session::getSession()->getUser())) {
						continue;
					}
					$aInfo = $this->getModule($sModuleName);
				} else if($sType === 'user') {
					$aInfo = $this->getUserInfo();
				} else if($sType === 'logout') {
					$aInfo = $this->getPageLink();
				}
				$aArgs[] = $aInfo;
				$aResult[] = array('type' => $sType, 'args' => $aArgs);
			} else {
				$aResult[] = array('type' => 'spacer', 'args' => array(15));
			}
		}
	}
	
	public function doWidget() {
		$oTemplate = $this->constructTemplate('menu_bar');
		$oTemplate->replaceIdentifier('session', $this->getSessionKey());
		if(Session::getSession()->isAuthenticated()) {
			$oTemplate->replaceIdentifier('style', 'block');
		}
		return $oTemplate;
	}
	
	private function getModule($sName) {
		$aResult = array('link' => LinkUtil::link(array($sName), 'AdminManager'), 'title' => AdminModule::getDisplayNameByName($sName));
		return $aResult;
	}
	
	public function getPreviewLink() {
		return LinkUtil::link(self::getPageFullPathArray(), 'PreviewManager', array(), false);
	}
	
	private static function getPageFullPathArray() {
		$oPage = PageQuery::create()->findPk(Session::getSession()->getAttribute('persistent_page_id'));
		return ($oPage ? $oPage->getFullPathArray() : array());
	}
	
	public function getPageLink() {
		Session::getSession()->setLanguage(AdminManager::getContentLanguage());
		return LinkUtil::link(self::getPageFullPathArray(), 'FrontendManager');
	}
}
