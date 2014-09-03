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
		$aResult = array();
		foreach($oQuery->select(array('Id', 'Name'))->find() as $aData) {
			$aResult[] = array('key' => $aData['Id'], 'value' => $aData['Name']);
		}
		return $aResult;
	}
}