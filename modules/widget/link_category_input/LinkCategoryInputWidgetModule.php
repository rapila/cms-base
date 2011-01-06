<?php
/**
 * @package modules.widget
 */
class LinkCategoryInputWidgetModule extends WidgetModule {
	
	public function getCategories() {
		return WidgetJsonFileModule::jsonBaseObjects(LinkCategoryPeer::getAllSorted(), array('id', 'name'));
	}
}