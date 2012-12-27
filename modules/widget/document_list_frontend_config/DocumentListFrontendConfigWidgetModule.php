<?php
class DocumentListFrontendConfigWidgetModule extends FrontendConfigWidgetModule {
	
	public function allDocuments($aOptions = array()) {
		return DocumentListFrontendModule::listQuery($aOptions)->select(array('Id', 'Name'))->find()->toKeyValue('Id', 'Name');
	}
	
	public function getConfigurationModes() {
		$aResult = array();
		$aDocumentCategories = DocumentListFrontendModule::getCategoryOptions();
		$aResult['document_categories'] = $aDocumentCategories;
		$aResult['tags'] = DocumentListFrontendModule::getTagOptions();
		$aResult['document_kind'] = array('' => StringPeer::getString('wns.document_kind.all')) + DocumentKindInputWidgetModule::getDocumentKindsAssoc();
		$aResult['list_template'] = array_keys(DocumentListFrontendModule::getTemplateOptions());
		if(count($aDocumentCategories) > 0) {
		  $aResult['sort_by'] = DocumentListFrontendModule::getSortOptions();
		}
		return $aResult;
	}
}
