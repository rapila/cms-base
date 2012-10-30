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
			} else if(is_string($mValue)) {
				if($mValue === 'edit') {
					$mValue = "module.pages";
				}
				if(StringUtil::startsWith($mValue, 'module.')) {
					$sModuleName = substr($mValue, strlen('module.'));
					if(!Module::isModuleAllowed('admin', $sModuleName, Session::getSession()->getUser())) {
						unset($aSettings[$iKey]);
					}
				}
			}
		}
		$aSettings = array_values($aSettings);
	}
	
	public function doWidget() {
		$oTemplate = $this->constructTemplate('menu_bar');
		$oTemplate->replaceIdentifier('session', $this->getSessionKey());
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
		$oPage = PageQuery::create()->findPk(Session::getSession()->getAttribute('persistent_page_id'));
		return ($oPage ? $oPage->getFullPathArray() : array());
	}
	
	public function getPageLink() {
		Session::getSession()->setLanguage(AdminManager::getContentLanguage());
		return LinkUtil::link(self::getPageFullPathArray(), 'FrontendManager');
	}
}
