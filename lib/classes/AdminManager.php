<?php

class AdminManager extends Manager {
	
	const DEFAULT_MODULE = 'dashboard';
  const CONTENT_LANGUAGE_SESSION_KEY = 'content_language';
	
	private $sModuleName;
	private $oModule;
	private $oResourceIncluder;
	
	public function __construct() {
		parent::__construct();
		$this->sModuleName = Manager::usePath();
		if($this->sModuleName === null) {
			$this->sModuleName = self::DEFAULT_MODULE;
		}
		$this->oModule = AdminModule::getModuleInstance($this->sModuleName);
		$this->oResourceIncluder = ResourceIncluder::defaultIncluder();
		if(isset($_REQUEST[self::CONTENT_LANGUAGE_SESSION_KEY])) {
			self::setContentLanguage($_REQUEST[self::CONTENT_LANGUAGE_SESSION_KEY]);
		}
	}
	
	public function getModuleName() {
		return $this->sModuleName;
	}
	
	public static function setContentLanguage($sLanguageId) {
    Session::getSession()->setAttribute(self::CONTENT_LANGUAGE_SESSION_KEY, $sLanguageId);
  }
  
  public static function getContentLanguage() {
    $sLanguageId = Session::getSession()->getAttribute(self::CONTENT_LANGUAGE_SESSION_KEY);
    if($sLanguageId === null) {
      $sLanguageId = Session::language();
    }
    // hack that should be removed in a future version of installManager()
    if(!LanguagePeer::languageExists($sLanguageId) && LanguagePeer::hasNoLanguage()) {
      $oLanguage = new Language();
      $oLanguage->setId($sLanguageId);
      $oLanguage->setIsActive(true);
      $oLanguage->save();
    }
    return $sLanguageId;
  }

	public static function setCurrentPage($oPage) {
		FrontendManager::$CURRENT_PAGE = $oPage;
	}

	public function render() {
		$this->preRender();
		
		$oTemplate = null;
		if(!Session::getSession()->isAuthenticated() || !Session::getSession()->getUser()->getIsBackendLoginEnabled()) {
			if(Session::getSession()->isAuthenticated() && !Session::getSession()->getUser()->getIsBackendLoginEnabled()) {
				Flash::getFlash()->addMessage('backend_login_denied');
				Session::getSession()->logout();
			}
			$oTemplate = new Template('login', array(DIRNAME_TEMPLATES, 'admin'), false, true);
			$oLoginWindowWidget = new LoginWindowWidgetModule();
			LoginWindowWidgetModule::includeResources();
		} else {
			$oTemplate = new Template('main', array(DIRNAME_TEMPLATES, 'admin'), false, true);
			$this->doAdmin($oTemplate);
		}
		$oTemplate->replaceIdentifier("title", Settings::getSetting('backend', 'title', 'no title set in config/config.yml for backend'), null, Template::LEAVE_IDENTIFIERS);
		$oTemplate->replaceIdentifier('module_name', $this->sModuleName);
		$oTemplate->replaceIdentifier('module_display_name', AdminModule::getDisplayNameByName($this->sModuleName));

		$oTemplate->render();
	}
	
	private function preRender() {
		$oConstants = new Template('constants.js', array(DIRNAME_TEMPLATES, 'admin'));
		$oConstants->replaceIdentifier('current_admin_module', $this->sModuleName);
		$this->oResourceIncluder->addJavaScriptLibrary('jquery', 1.4);
		$this->oResourceIncluder->addCustomJs($oConstants);
		$this->oResourceIncluder->addJavaScriptLibrary('jqueryui', 1);
		$this->oResourceIncluder->addResource('admin/admin-skeleton.css');
		$this->oResourceIncluder->addResource('admin/theme/jquery-ui-1.7.2.custom.css');
		$this->oResourceIncluder->addResource('widget/widget.css');
		$this->oResourceIncluder->addResource('admin/admin-ui.css');
		$this->oResourceIncluder->addResource('admin/widget.js');
		$this->oResourceIncluder->addResource('widget/widget_skeleton.js'); //Provides some basic overrides for tooltip, notifyuser and stuff
		$this->oResourceIncluder->addResource('admin/new_admin.js');
		$this->oResourceIncluder->addResource('admin/skeleton.js');
		// WidgetModule::removeStoredWidgets();
		
		$oOutput = new XHTMLOutput('html5');
		$oOutput->render();
	}
	
	private function doAdmin($oTemplate) {
		$oAdminMenuWidget = new AdminMenuWidgetModule();
		AdminMenuWidgetModule::includeResources($this->oResourceIncluder);
		
		$oTemplate->replaceIdentifierMultiple('main_content', $this->oModule->mainContent());
		$oTemplate->replaceIdentifierMultiple('sidebar_content', $this->oModule->sidebarContent());
		$oTemplate->replaceIdentifierMultiple('admin_menu', $oAdminMenuWidget->doWidget());
		
		foreach($this->oModule->usedWidgets() as $mWidget) {
			if(!is_string($mWidget)) {
        $mWidget = get_class($mWidget);
			}
      call_user_func(array($mWidget, 'includeResources'), $this->oResourceIncluder);
		}
		
		$this->oModule->includeCustomResources($this->oResourceIncluder);
	}
}