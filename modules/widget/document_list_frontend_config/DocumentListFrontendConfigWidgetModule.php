<?php
class DocumentListFrontendConfigWidgetModule extends FrontendConfigWidgetModule {

	public function allDocuments($aOptions = array()) {
		return WidgetJsonFileModule::jsonOrderedObject(DocumentListFrontendModule::listQuery($aOptions)->select(array('Id', 'Name'))->find()->toKeyValue('Id', 'Name'));
	}

	public function getConfigData() {
		$aResult = $this->configData();
		if(!isset($aResult['document_categories'])) {
			$aResult['document_categories'] = array();
		}
		if(!isset($aResult['tags'])) {
			$aResult['tags'] = array();
		}
		return $aResult;
	}

	public function getConfigurationModes() {
		$aResult = array();
		$aDocumentCategories = DocumentListFrontendModule::getCategoryOptions();
		$aResult['document_categories[]'] = WidgetJsonFileModule::jsonOrderedObject($aDocumentCategories);
		$aResult['tags[]'] = WidgetJsonFileModule::jsonOrderedObject(DocumentListFrontendModule::getTagOptions());
		$aResult['document_kind'] = WidgetJsonFileModule::jsonOrderedObject(array('' => TranslationPeer::getString('wns.document_kind.all')) + DocumentKindInputWidgetModule::getDocumentKindsAssoc());
		$aResult['list_template'] = array_keys(DocumentListFrontendModule::getTemplateOptions());
		if(count($aDocumentCategories) > 0) {
			$aResult['sort_by'] = DocumentListFrontendModule::getSortOptions();
			$aResult['sort_order'] = DocumentListFrontendModule::getSortOrders();
		}
		return $aResult;
	}
}
