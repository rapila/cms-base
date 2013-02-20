<?php
/**
 * @package modules.widget
 */
class LinkCategoryInputWidgetModule extends WidgetModule {
	
	public function listCategories() {
		return LinkCategoryQuery::create()->orderByName()->select(array('Id', 'Name'))->find()->toKeyValue('Id', 'Name');
	}
}