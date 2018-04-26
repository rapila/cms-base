<?php

class FormFrontendConfigWidgetModule extends FrontendConfigWidgetModule {
	public function getTypeOptions() {
		return array('email' => TranslationPeer::getString('wns.form_type.email'), 'external' => TranslationPeer::getString('wns.form_type.external'), 'manager' => TranslationPeer::getString('wns.form_type.manager'));
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