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
		ResourceIncluder::defaultIncluder()->addCustomJs('var FILE_PREFIX = "'.MAIN_DIR_FE.Manager::getPrefixForManager('FileManager').'"');
		$oLoginWindowWidget = new LoginWindowWidgetModule();
		LoginWindowWidgetModule::includeResources();
		$oAdminMenuWidget = new AdminMenuWidgetModule();
		AdminMenuWidgetModule::includeResources();
	}
}