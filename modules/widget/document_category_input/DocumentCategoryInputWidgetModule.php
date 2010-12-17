<?php
/**
 * @package modules.widget
 */
class DocumentCategoryInputWidgetModule extends WidgetModule {
	
	public function getCategories($bGetCategoriesWithDocumentsOnly=false) {
		if(!$bGetCategoriesWithDocumentsOnly) {
			$oDocuments = DocumentCategoryPeer::getDocumentCategoriesSorted();
		} else {
			$oDocuments = DocumentCategoryPeer::getDocumentCategoriesForImagePicker();
		}
		return WidgetJsonFileModule::jsonBaseObjects($oDocuments, array('id', 'name'));
	}
	
	public function getElementType() {
		return 'select';
	}
}