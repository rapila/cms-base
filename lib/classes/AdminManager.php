<?php

class AdminManager extends Manager {
	
	const DEFAULT_MODULE = 'dashboard';
  const CONTENT_LANGUAGE_SESSION_KEY = 'content_language';
	private $sModuleName;
	private $oModule;
	private $oResourceIncluder;
	
	public function __construct() {
		parent::__construct();
		SanityCheck::basicCheck();
		$this->sModuleName = Manager::usePath();
		if($this->sModuleName === null) {
			$this->sModuleName = self::DEFAULT_MODULE;
		}
		$this->oResourceIncluder = ResourceIncluder::defaultIncluder();
		if(isset($_REQUEST[self::CONTENT_LANGUAGE_SESSION_KEY])) {
			self::setContentLanguage($_REQUEST[self::CONTENT_LANGUAGE_SESSION_KEY]);
		}
		if(Session::getSession()->isAuthenticated() && Session::getSession()->getUser()->getIsBackendLoginEnabled()) {
			$oUser = Session::getSession()->getUser();
			Session::getSession()->setLanguage(Session::getSession()->getUser()->getLanguageId());
			if(isset($_REQUEST['preview']) || !$oUser->getIsAdminLoginEnabled()) {
				LinkUtil::redirect(LinkUtil::link(@$_REQUEST['preview'], 'PreviewManager'));
			}
		}
	}
	
	public function getModuleName() {
		return $this->sModuleName;
	}
	
	public static function setContentLanguage($sLanguageId) {
		if(!LanguagePeer::languageExists($sLanguageId)) {
			if(LanguagePeer::languageExists(Session::language())) {
				$sLanguageId = Session::language();
			} else if(LanguagePeer::languageExists(Session::sessionDefaultFor(self::CONTENT_LANGUAGE_SESSION_KEY))) {
				$sLanguageId = Session::sessionDefaultFor(self::CONTENT_LANGUAGE_SESSION_KEY);
			} else if(LanguagePeer::languageExists(Session::sessionDefaultFor(Session::SESSION_LANGUAGE_KEY))) {
				$sLanguageId = Session::sessionDefaultFor(Session::SESSION_LANGUAGE_KEY);
			} else {
				// fallback @see method doc
				LanguagePeer::createLanguageIfNoneExist($sLanguageId);
				return;
			}
		}
		// fallback @see method doc
		LanguagePeer::createLanguageIfNoneExist($sLanguageId);
		Session::getSession()->setAttribute(self::CONTENT_LANGUAGE_SESSION_KEY, $sLanguageId);
  }
  
  public static function getContentLanguage() {
    $sLanguageId = Session::getSession()->getAttribute(self::CONTENT_LANGUAGE_SESSION_KEY);
    if($sLanguageId === null) {
      $sLanguageId = Session::language();
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
				Flash::getFlash()->addMessage('admin_login_denied');
				Session::getSession()->logout();
			}
			self::setContentLanguage(Session::language());
			$oTemplate = new Template('login', array(DIRNAME_TEMPLATES, 'admin'), false, true);
			$oLoginWindowWidget = new LoginWindowWidgetModule();
			LoginWindowWidgetModule::includeResources();
		} else {
			try {
				$this->oModule = AdminModule::getModuleInstance($this->sModuleName);
			} catch (Exception $e) {
				LinkUtil::redirect(LinkUtil::link(array('dashboard', 'module_not_found', $this->sModuleName)));
			}
			if(!Module::isModuleAllowed('admin', $this->sModuleName, Session::getSession()->getUser())) {
				LinkUtil::redirect(LinkUtil::link(array('dashboard', 'module_denied', $this->sModuleName)));
			}
			$oTemplate = new Template('main', array(DIRNAME_TEMPLATES, 'admin'), false, true);
			$this->doAdmin($oTemplate);
		}
		$oTemplate->replaceIdentifier("title", Settings::getSetting('admin', 'title', 'no title set in config/config.yml for admin'), null, Template::LEAVE_IDENTIFIERS);
		$oTemplate->replaceIdentifier('module_name', $this->sModuleName);
		$oTemplate->replaceIdentifier('module_display_name', AdminModule::getDisplayNameByName($this->sModuleName));

		$oTemplate->render();
	}
	
	private function preRender() {
		$oConstants = new Template('constants.js', array(DIRNAME_TEMPLATES, 'admin'));
		$oConstants->replaceIdentifier('current_admin_module', $this->sModuleName);
		$this->oResourceIncluder->addJavaScriptLibrary('jquery', "1.7.1");
		$this->oResourceIncluder->addCustomJs($oConstants);
		$this->oResourceIncluder->addJavaScriptLibrary('jqueryui', 1);
		$this->oResourceIncluder->addResource('admin/admin-skeleton.css');
		$this->oResourceIncluder->addResource('admin/theme/jquery-ui-1.7.2.custom.css');
		$this->oResourceIncluder->addResource('widget/widget.css');
		$this->oResourceIncluder->addResource('admin/admin-ui.css');
		$this->oResourceIncluder->addResource('admin/print.css', null, null, array('media' => 'print'), ResourceIncluder::PRIORITY_NORMAL, null, true);
		$this->oResourceIncluder->addResource('widget/widget.js');
		$this->oResourceIncluder->addResource('widget/widget_skeleton.js'); //Provides some basic overrides for tooltip, notifyuser and stuff
		$this->oResourceIncluder->addResource('admin/admin.js');
		$this->oResourceIncluder->addResource('admin/skeleton.js');
		// WidgetModule::removeStoredWidgets();
		
		$oOutput = new XHTMLOutput('html5');
		$oOutput->render();
	}
	
	/**
	* @param string $sPostfix string of template 'list item' identifier
	* retrieve all templates from site template dir that follow a naming convention
	* list template name: examplename.tmpl
	* list_item template name: examplename_item.tmpl
	* @return array assoc of path to examplename in key and value
	*/	
	public static function getSiteTemplatesForListOutput($sPostfix = '_item') {
		$aTemplateList = ArrayUtil::arrayWithValuesAsKeys(Template::listTemplates(DIRNAME_TEMPLATES, true));
		$aListTemplates = array();
		foreach($aTemplateList as $sPath => $sListName) {
			if(StringUtil::endsWith($sListName, $sPostfix)) {
				$sPath = substr($sListName, 0, -strlen($sPostfix));
				$aListTemplates[$sPath] = $sPath;
			}
		}
		foreach($aListTemplates as $sListPath) {
			if(!in_array($sListPath, $aTemplateList)) {
				unset($aListTemplates[$sListPath]);
			}
		}
		return $aListTemplates;
	}

	private function doAdmin($oTemplate) {
		$oAdminMenuWidget = new AdminMenuWidgetModule();
		AdminMenuWidgetModule::includeResources($this->oResourceIncluder);
		
		$oTemplate->replaceIdentifierMultiple('main_content', $this->oModule->mainContent());
		
		$mSidebarContent = $this->oModule->sidebarContent();
		if($mSidebarContent === null) {
			$mSidebarContent = '';
		} else if($mSidebarContent === false) {
			$mSidebarContent = null;
		}
		$oTemplate->replaceIdentifierMultiple('sidebar_content', $mSidebarContent);
		
		$oTemplate->replaceIdentifierMultiple('admin_menu', $oAdminMenuWidget->doWidget());
		
		foreach($this->oModule->usedWidgets() as $mWidget) {
			if(!is_string($mWidget)) {
        $mWidget = get_class($mWidget);
			} else {
				$mWidget = WidgetModule::getClassNameByName($mWidget);
			}
      call_user_func(array($mWidget, 'includeResources'), $this->oResourceIncluder);
		}
		
		$this->oModule->includeCustomResources($this->oResourceIncluder);
	}
}
