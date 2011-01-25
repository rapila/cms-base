<?php

class PreviewManager extends FrontendManager {
	private $sOldSessionLanguage;
	
	private static $PREVIOUS_MANAGER;
	
	public function __construct() {
		parent::__construct();
		if(!Session::getSession()->isAuthenticated() || !Session::getSession()->getUser()->getIsBackendLoginEnabled()) {
			LinkUtil::redirect(LinkUtil::link(array(), 'AdminManager', array('preview' => self::getRequestedPath())));
		}
		
		ResourceIncluder::defaultIncluder()->addReverseDependency('lib_prototype', false, 'preview/prototype_json_fix.js');
		ResourceIncluder::defaultIncluder()->addJavaScriptLibrary('jquery', '1.4.4');
		ResourceIncluder::defaultIncluder()->addJavaScriptLibrary('jqueryui', 1);
		ResourceIncluder::defaultIncluder()->addResource('widget/widget.js');
		ResourceIncluder::defaultIncluder()->addResource('widget/widget_skeleton.js'); //Provides some basic overrides for tooltip, notifyuser and stuff
		// ResourceIncluder::defaultIncluder()->addResource('widget/widget.css');
		ResourceIncluder::defaultIncluder()->addResource('preview/theme/jquery-ui-1.7.2.custom.css');
		$this->addNamespacedCss(array('widget', 'widget.css'));
		ResourceIncluder::defaultIncluder()->addResource('preview/preview-default.css');
		
		ResourceIncluder::defaultIncluder()->addResource('preview-interface.css', null, null, null, ResourceIncluder::PRIORITY_NORMAL, null, true);
		
		$oLoginWindowWidget = new LoginWindowWidgetModule();
		LoginWindowWidgetModule::includeResources();
    $oAdminMenuWidget = new AdminMenuWidgetModule();
    AdminMenuWidgetModule::includeResources();
	}
	
	protected function initLanguage() {
		$this->sOldSessionLanguage = Session::language();
		if(isset($_REQUEST[AdminManager::CONTENT_LANGUAGE_SESSION_KEY]) && LanguagePeer::languageExists($_REQUEST[AdminManager::CONTENT_LANGUAGE_SESSION_KEY])) {
				AdminManager::setContentLanguage($_REQUEST[AdminManager::CONTENT_LANGUAGE_SESSION_KEY]);
				unset($_REQUEST[AdminManager::CONTENT_LANGUAGE_SESSION_KEY]);
				LinkUtil::redirect(LinkUtil::link(Manager::getRequestedPath(), get_class()));
		} else {
			if(!LanguagePeer::languageExists(AdminManager::getContentLanguage())) {
				AdminManager::setContentLanguage($this->sOldSessionLanguage);
			}
			if(!LanguagePeer::languageExists(AdminManager::getContentLanguage())) {
				Session::getSession()->resetAttribute(AdminManager::CONTENT_LANGUAGE_SESSION_KEY);
			}
			if(!LanguagePeer::languageExists(AdminManager::getContentLanguage())) {
				AdminManager::setContentLanguage(Settings::getSetting('session_default', Session::SESSION_LANGUAGE_KEY, 'en'));
			}
			if(!LanguagePeer::languageExists(AdminManager::getContentLanguage())) {
				LinkUtil::redirectToManager('', "AdminManager");
			}
		}
		Session::getSession()->setLanguage(AdminManager::getContentLanguage());
	}
	
	public function render() {
		if(!$this->bIsNotFound) {
			Session::getSession()->setAttribute('persistent_page_id', self::$CURRENT_PAGE->getId());
		}
		parent::render();
		Session::getSession()->setLanguage($this->sOldSessionLanguage);
	}
	
	protected function getXHTMLOutput() {
		return new XHTMLOutput('html5', true, 'preview');
	}
	
	protected function fillContent() {
		$oPageTypeWidget = WidgetModule::getWidget('page_type');
		$oPageTypeWidget->setPageTypeModule($this->oPageType);
		$oConstants = new Template('constants.js', array(DIRNAME_TEMPLATES, 'preview'));
		$oConstants->replaceIdentifier('page_type_widget_session', $oPageTypeWidget->getSessionKey());
		$oConstants->replaceIdentifier('current_page_id', self::$CURRENT_PAGE->getId());
		ResourceIncluder::defaultIncluder()->addCustomJs($oConstants);
		ResourceIncluder::defaultIncluder()->addResource('preview/preview.js');
		$this->oPageType->display($this->oTemplate, true);
	}
	
	protected function useFullPageCache() {
		return false;
	}
	
	private function addNamespacedCss($mLocation) {
		array_unshift($mLocation, 'namespaced_preview_css');
		$oResourceIncluder = ResourceIncluder::defaultIncluder();
		$oResourceIncluder->addResource(LinkUtil::link($mLocation, 'FileManager'), ResourceIncluder::RESOURCE_TYPE_CSS);
	}
	
	public static function shouldIncludeLanguageInLink() {
		return false;
	}
	
	public static function setTemporaryManager() {
		self::$PREVIOUS_MANAGER = Manager::getCurrentManager();
		self::$CURRENT_MANAGER = get_class();
	}
	
	public static function revertTemporaryManager() {
		self::$CURRENT_MANAGER = self::$PREVIOUS_MANAGER;
	}
}