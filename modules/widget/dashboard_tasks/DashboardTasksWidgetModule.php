<?php
/**
 * @package modules.widget
 */
class DashboardTasksWidgetModule extends PersistentWidgetModule {

	private $sModuleNotFound;
	
	public function getTasks() {
		$oUser = Session::getSession()->getUser();
		if($this->sModuleNotFound !== null) {
			$sMessage = StringPeer::getString('wns.module.not_enabled_or_exist', null, null, array('module_name' => $this->sModuleNotFound));
			return array('module_not_found' => $sMessage);
		}
		
		return $oUser->getAdminSettings('dashboard_tasks');;
	}
	
	public function setModuleNotFound($sModuleNotFound) {
		$this->sModuleNotFound = $sModuleNotFound;
	}
	
	public function getModuleNotFound() {
		return $this->sModuleNotFound;
	}
	
	public function getElementType() {
		return new TagWriter('div', array('class' => 'dashboard_tasks'));
	}
	
	public static function isSingleton() {
		return true;
	}


}