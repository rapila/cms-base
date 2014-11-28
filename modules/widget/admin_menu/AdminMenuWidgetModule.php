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

	public function moduleConfig() {
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

	private function cleanModules($aSettings, &$aResult = array(), $bIsMenu = false) {
		foreach($aSettings as $iKey => &$mValue) {
			if(is_array($mValue)) {
				$aRes = array();
				$sType = 'select';
				if($mValue[0] && strpos($mValue[0], 'type.') === 0) {
					$sType = substr(strstr(array_shift($mValue), '.'), 1);
				}
				$sIcon = null;
				if($mValue[0] && strpos($mValue[0], 'icon.') === 0) {
					$sIcon = substr(strstr(array_shift($mValue), '.'), 1);
				}
				$this->cleanModules($mValue, $aRes, true);
				$aResult[] = array('type' => $sType, 'args' => array($aRes, $sIcon));
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
					$aInfo = $this->getModule($sModuleName, $bIsMenu);
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

	public static function includeResources($oResourceIncluder = null) {
		if($oResourceIncluder === null) {
			$oResourceIncluder = ResourceIncluder::defaultIncluder();
		}
		$oResourceIncluder->addResource('widget/popover/jquery.popover.js');
		$oResourceIncluder->addResource(array(DIRNAME_WEB, 'js', 'widget', 'popover', 'jquery.popover.css'));
		self::includeWidgetResources(false, $oResourceIncluder);
	}


	private function getModule($sName, $bIsMenu) {
		$aResult = array('link' => LinkUtil::link(array($sName), 'AdminManager'), 'name' => AdminModule::getDisplayNameByName($sName));
		//Special-case dashboard to print icon
		if($sName === 'dashboard' && !$bIsMenu) {
			$aResult['title'] = $aResult['name'];
			$aResult['name'] = DashboardControlWidgetModule::layoutName();
			$aResult['class'] = 'rapila-icon';
		}
		return $aResult;
	}

	public function getPreviewLink() {
		return LinkUtil::link(self::getPageFullPathArray(), 'PreviewManager', array(), false);
	}

	public function documentationExists($sDocumentationName) {
		$aMetadata = DocumentationProviderTypeModule::dataForPart($sDocumentationName, Session::language());
		return $aMetadata !== null;
	}

	public function documentationData($sDocumentationName) {
		return DocumentationProviderTypeModule::dataForPart($sDocumentationName, Session::language());
	}
	
	public function clearCaches() {
		Cache::clearAllCaches();
	}

	public function resetUserSettings() {
		$oUser = Session::user();
		if($oUser) {
			$oUser->resetBackendSettings();
			$oUser->save();
			return true;
		}
		return false;
	}

	private static function getPageFullPathArray() {
		$oPage = PageQuery::create()->findPk(Session::getSession()->getAttribute('persistent_page_id'));
		return ($oPage ? $oPage->getFullPathArray() : array());
	}

	public function getPageLink() {
		return LinkUtil::link(self::getPageFullPathArray(), 'FrontendManager', array(), AdminManager::getContentLanguage());
	}
}
