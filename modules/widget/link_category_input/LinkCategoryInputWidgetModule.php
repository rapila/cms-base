<?php
/**
 * @package modules.widget
 */
class LinkCategoryInputWidgetModule extends WidgetModule {
	
	public function listCategories() {
		$oQuery = LinkCategoryQuery::create()->orderByName();
		if(Settings::getSetting('admin', 'hide_externally_managed_link_categories', true)) {
			$oQuery->filterByIsExternallyManaged(false);
		}
		return $oQuery->select(array('Id', 'Name'))->find()->toKeyValue('Id', 'Name');
	}
}