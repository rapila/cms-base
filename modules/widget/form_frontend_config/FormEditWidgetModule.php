<?php

class FormEditWidgetModule extends EditWidgetModule {
	public function getTypeOptions() {
		return array('email' => StringPeer::getString('wns.form_type.email'), 'external' => StringPeer::getString('wns.form_type.external'), 'manager' => StringPeer::getString('wns.form_type.manager'));
	}
	
	public function getMethodOptions() {
		return array('post', 'get');
	}
	
	public function getManagerOptions() {
		return array_values(Manager::listManagers());
	}
	
	public function getFieldTypeOptions() {
		return FormStorage::getAvailableTypes();
	}
}