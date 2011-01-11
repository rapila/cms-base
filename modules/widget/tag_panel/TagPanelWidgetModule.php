<?php

/**
* @package widget
*/

class TagPanelWidgetModule extends WidgetModule {
	
	public function listTags() {
		return TagQuery::create()->find()->toArray();
	}
	
	public static function isSingleton() {
		return true;
	}
}