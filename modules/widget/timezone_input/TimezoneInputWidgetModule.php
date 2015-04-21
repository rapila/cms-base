<?php
class TimezoneInputWidgetModule extends WidgetModule {

	public function getElementType() {
		$this->setSetting('default_value', Settings::getSetting('general', 'timezone', 'Europe/Zurich'));
		return 'select';
	}
	
	public function timeZones() {
		return DateTimeZone::listIdentifiers();
	}
}