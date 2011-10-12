<?php
/**
 * @package modules.widget
 */
class DocumentCategoryInputWidgetModule extends WidgetModule {
	
	public function allCategories($bGetCategoriesWithDocumentsOnly=false) {
		$oQuery = DocumentCategoryQuery::create()->distinct()->filterByIsExternallyManaged(false);
		if($bGetCategoriesWithDocumentsOnly) {
			$oQuery->joinDocument(null, Criteria::INNER_JOIN);
			if(is_string($bGetCategoriesWithDocumentsOnly)) {
				$oQuery->useDocumentQuery()->filterByDocumentKind($bGetCategoriesWithDocumentsOnly)->endUse();
			}
		}
		return WidgetJsonFileModule::jsonBaseObjects($oQuery->orderByName()->find(), array('id', 'name'));
	}
	
	public function getElementType() {
		return 'select';
	}
}
