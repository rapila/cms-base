<?php
/**
 * @package modules.widget
 */
class LinkCategoryInputWidgetModule extends WidgetModule {
	
	public function getCategories() {
		return WidgetJsonFileModule::jsonBaseObjects(LinkCategoryQuery::create()->orderByName()->find(), array('id', 'name'));
	}
}