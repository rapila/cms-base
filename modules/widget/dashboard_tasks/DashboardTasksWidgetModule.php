<?php
/**
 * @package modules.widget
 */
class DashboardTasksWidgetModule extends PersistentWidgetModule {

	public function getTasks() {
		$oUser = Session::getSession()->getUser();
		$aSettings = $oUser->getAdminSettings('dashboard_tasks');
		return $aSettings;
	}
	
	public function getElementType() {
		return new TagWriter('div', array('class' => 'dashboard_tasks'));
	}
	
	public static function isSingleton() {
		return true;
	}


}