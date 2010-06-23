<?php

class PreviewManager extends FrontendManager {
	public function __construct() {
		parent::__construct();
		ResourceIncluder::defaultIncluder()->addJavaScriptLibrary('jquery', 1.4);
		ResourceIncluder::defaultIncluder()->addJavaScriptLibrary('jqueryui', 1);
		ResourceIncluder::defaultIncluder()->addResource('admin/widget.js');
		ResourceIncluder::defaultIncluder()->addResource('admin/new_admin.js');
		ResourceIncluder::defaultIncluder()->addResource('admin/admin-skeleton.css');
		ResourceIncluder::defaultIncluder()->addResource('admin/theme/jquery-ui-1.7.2.custom.css');
		$oLoginWindowWidget = new LoginWindowWidgetModule();
		LoginWindowWidgetModule::includeResources();
		// $oAdminMenuWidget = new AdminMenuWidgetModule();
		// AdminMenuWidgetModule::includeResources();
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
	
	protected function getSessionLanguage() {
		return AdminManager::getContentLanguage();
	}
	
	protected function useFullPageCache() {
		return false;
	}
}