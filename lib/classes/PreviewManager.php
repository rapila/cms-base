<?php

class PreviewManager extends FrontendManager {
	private $sOldSessionLanguage;
	private $oAdminMenuWidget;
	
	private static $PREVIOUS_MANAGER;
	
	public function __construct($bShouldLogin=true) {
		parent::__construct();
		SanityCheck::basicCheck();
		if($bShouldLogin && (!Session::getSession()->isAuthenticated() || !Session::getSession()->getUser()->getIsBackendLoginEnabled())) {
			LinkUtil::redirect(LinkUtil::link(array(), 'AdminManager', array('preview' => self::getRequestedPath())));
		}

		//Fix JSON requests when using Prototype in the frontend
		ResourceIncluder::defaultIncluder()->addReverseDependency('lib_prototype', false, 'preview/prototype_json_fix.js');
		//Add jQuery and jQuery UI
		ResourceIncluder::defaultIncluder()->addJavaScriptLibrary('jquery', '1.8.1');
		ResourceIncluder::defaultIncluder()->addJavaScriptLibrary('jqueryui', '1.8.23');
		//Add client widget handling code
		ResourceIncluder::defaultIncluder()->addResource('widget/widget.js');
		ResourceIncluder::defaultIncluder()->addResource('widget/widget_skeleton.js'); //Provides some basic overrides for tooltip, notifyuser and stuff
		//Override some site styles in specific regions
		ResourceIncluder::defaultIncluder()->addResource('preview/preview-reset.css');
		ResourceIncluder::defaultIncluder()->addResource('preview/theme/jquery-ui-1.7.2.custom.css');
		//Add the css that handles styles for all widgets but namespace it so it applies only to specific areas of the page (editable areas, dialogs, the admin menu, etc.)
		$this->addNamespacedCss(array('widget', 'widget.css'));

		//preview-interface.css contains things like the edit buttons
		ResourceIncluder::defaultIncluder()->addResource('preview-interface.css', null, null, null, ResourceIncluder::PRIORITY_NORMAL, null, true);

		//Include the resources of widgets we know we’re gonna use.
		$oLoginWindowWidget = WidgetModule::getWidget('login_window');
		LoginWindowWidgetModule::includeResources();
		$this->oAdminMenuWidget = WidgetModule::getWidget('admin_menu');
		AdminMenuWidgetModule::includeResources();
		$this->oPageTypeWidget = WidgetModule::getWidget('page_type');
		PageTypeWidgetModule::includeResources();
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
				LinkUtil::redirectToManager('', "AdminManager");
			}
		}
		Session::getSession()->setLanguage(AdminManager::getContentLanguage());
	}
	
	protected function getXHTMLOutput() {
		return new XHTMLOutput('html5', true, 'preview');
	}
	
	public function render() {
		if(!$this->bIsNotFound) {
			Session::getSession()->setAttribute('persistent_page_id', self::$CURRENT_PAGE->getId());
		}
		parent::render();
		Session::getSession()->setLanguage($this->sOldSessionLanguage);
	}

	protected function fillAttributes() {
		TemplateResourceFileModule::includeAvailableResources(get_class($this->oPageType));
		return parent::fillAttributes();
	}
	
	protected function fillContent() {
		$this->oPageTypeWidget->setPageTypeModule($this->oPageType);
		$oConstants = new Template('constants.js', array(DIRNAME_TEMPLATES, 'preview'));
		$oConstants->replaceIdentifier('language_id', Session::getSession()->getUser()->getLanguageId());
		$oConstants->replaceIdentifier('page_type_widget_session', $this->oPageTypeWidget->getSessionKey());
		$oConstants->replaceIdentifier('admin_menu_widget_session', $this->oAdminMenuWidget->getSessionKey());
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
	
	public static function setTemporaryManager($sManager = null) {
		if($sManager === null) {
			$sManager = get_class();
		}
		self::$PREVIOUS_MANAGER = Manager::getCurrentManager();
		self::$CURRENT_MANAGER = $sManager;
	}
	
	public static function revertTemporaryManager() {
		self::$CURRENT_MANAGER = self::$PREVIOUS_MANAGER;
	}
}
