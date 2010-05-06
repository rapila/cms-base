<?php
/**
 * @package modules.widget
 */
class DocumentCategoryInputWidgetModule extends WidgetModule {
	
	public function getCategories() {
		return WidgetJsonFileModule::jsonBaseObjects(DocumentCategoryPeer::getDocumentCategoriesSorted(false, null), array('id', 'name'));
	}
}