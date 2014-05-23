<?php

/**
* @package widget
*/

class TagPanelWidgetModule extends WidgetModule {
	const USE_NAMESPACED_CSS = false;
	
	// @todo: remove if not used?
	public function listTags() {
		return TagQuery::create()->find()->toArray();
	}
	
	public static function isSingleton() {
		return true;
	}
}