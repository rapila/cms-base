<?php
/**
 * @package modules.widget
 */
class PermissionWidgetModule extends PersistentWidgetModule {

	public function isGranted($sModuleName, $aSomeParameters) {
		// may do something on page
		// check may admin module, 
		// modules decide for themselves?
		if($isNotGranted) {
			throw new LocalizedException('flash.whatever');
		}
	}
	
	public static function isSingleton() {
		return true;
	}
}