<?php
/**
 * @package modules.widget
 */
class DocumentCategoryInputWidgetModule extends WidgetModule {
	
	public function getCategories() {
		return WidgetJsonFileModule::jsonBaseObjects(DocumentCategoryPeer::getDocumentCategoriesForImagePicker(), array('id', 'name'));
	}
	
	public function getElementType() {
		return 'select';
	}
}