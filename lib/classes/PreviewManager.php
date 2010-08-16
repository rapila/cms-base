<?php

class PreviewManager extends FrontendManager {
	private $sOldSessionLanguage;
	
	public function __construct() {
		parent::__construct();
		ResourceIncluder::defaultIncluder()->addJavaScriptLibrary('jquery', 1.4);
		ResourceIncluder::defaultIncluder()->addJavaScriptLibrary('jqueryui', 1);
		ResourceIncluder::defaultIncluder()->addResource('widget/widget.js');
		ResourceIncluder::defaultIncluder()->addResource('widget/widget_skeleton.js'); //Provides some basic overrides for tooltip, notifyuser and stuff
		ResourceIncluder::defaultIncluder()->addResource('widget/widget.css');
		ResourceIncluder::defaultIncluder()->addResource('preview/theme/jquery-ui-1.7.2.custom.css');
		ResourceIncluder::defaultIncluder()->addResource('preview/preview-default.css');
		$oLoginWindowWidget = new LoginWindowWidgetModule();
		LoginWindowWidgetModule::includeResources();
    $oAdminMenuWidget = new AdminMenuWidgetModule();
    AdminMenuWidgetModule::includeResources();
	}
	
	protected function initLanguage() {
		$this->sOldSessionLanguage = Session::language();
		if(self::hasNextPathItem() && LanguagePeer::languageIsActive(self::peekNextPathItem())) {
				AdminManager::setContentLanguage(self::usePath());
		} else {
			if(!LanguagePeer::languageIsActive(AdminManager::getContentLanguage())) {
				Session::getSession()->resetAttribute(AdminManager::CONTENT_LANGUAGE_SESSION_KEY);
			}
			if(!LanguagePeer::languageIsActive(AdminManager::getContentLanguage())) {
				LinkUtil::redirectToManager('', "AdminManager");
			}
			LinkUtil::redirectToLanguage(true, AdminManager::getContentLanguage());
		}
		Session::getSession()->setLanguage(AdminManager::getContentLanguage());
	}
	
	public function render() {
		parent::render();
		Session::getSession()->setLanguage($this->sOldSessionLanguage);
	}
	
	protected function getXHTMLOutput() {
		return new XHTMLOutput('html5');
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
}