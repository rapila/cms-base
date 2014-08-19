<?php
class DocumentListFrontendConfigWidgetModule extends FrontendConfigWidgetModule {

	public function allDocuments($aOptions = array()) {
		return DocumentListFrontendModule::listQuery($aOptions)->select(array('Id', 'Name'))->find()->toKeyValue('Id', 'Name');
	}

	public function getConfigurationModes() {
		$aResult = array();
		$aDocumentCategories = DocumentListFrontendModule::getCategoryOptions();
		$aResult['document_categories'] = WidgetJsonFileModule::jsonOrderedObject($aDocumentCategories);
		$aResult['tags'] = WidgetJsonFileModule::jsonOrderedObject(DocumentListFrontendModule::getTagOptions());
		$aResult['document_kind'] = WidgetJsonFileModule::jsonOrderedObject(array('' => StringPeer::getString('wns.document_kind.all')) + DocumentKindInputWidgetModule::getDocumentKindsAssoc());
		$aResult['list_template'] = array_keys(DocumentListFrontendModule::getTemplateOptions());
		if(count($aDocumentCategories) > 0) {
			$aResult['sort_by'] = DocumentListFrontendModule::getSortOptions();
		}
		return $aResult;
	}
}
