<?php

class FormEditWidgetModule extends EditWidgetModule {
	public function getTypeOptions() {
		return array('email' => StringPeer::getString('wns.form_type.email'), 'external' => StringPeer::getString('wns.form_type.external'), 'manager' => StringPeer::getString('wns.form_type.manager'));
	}
	
	public function getMethodOptions() {
		return ArrayUtil::arrayWithValuesAsKeys(array('post', 'get'));
	}
	
	public function getManagerOptions() {
		return ArrayUtil::arrayWithValuesAsKeys(Manager::listManagers());
	}
	
	public function getFieldTypeOptions() {
		return ArrayUtil::arrayWithValuesAsKeys(FormStorage::getAvailableTypes());
	}
}