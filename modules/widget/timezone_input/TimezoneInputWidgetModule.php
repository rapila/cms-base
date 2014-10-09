<?php
class TimezoneInputWidgetModule extends WidgetModule {
	public function getElementType() {
		return 'select';
	}
	
	public function timeZones() {
		return DateTimeZone::listIdentifiers();
	}
}