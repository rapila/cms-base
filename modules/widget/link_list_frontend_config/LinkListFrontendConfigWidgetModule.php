<?php
class LinkListFrontendConfigWidgetModule extends FrontendConfigWidgetModule {

	public function allLinks($aOptions = array()) {
		$oQuery = LinkListFrontendModule::listQuery($aOptions);
		return WidgetJsonFileModule::jsonOrderedObject($oQuery->select(array('Id', 'Name'))->find()->toKeyValue('Id', 'Name'));
	}

	public function getConfigData() {
		$aResult = $this->configData();
		if(!isset($aResult['link_categories'])) {
			$aResult['link_categories'] = array();
		}
		if(!isset($aResult['tags'])) {
			$aResult['tags'] = array();
		}
		return $aResult;
	}

	public function getConfigurationModes() {
		$aResult = array();
		$aLinkCategories = LinkListFrontendModule::getCategoryOptions();
		$aResult['link_categories[]'] = $aLinkCategories;
		$aResult['tags[]'] = LinkListFrontendModule::getTagOptions();
		$aResult['template'] = array_keys(LinkListFrontendModule::getTemplateOptions());
		if(count($aLinkCategories) > 0) {
			$aResult['sort_by'] = LinkListFrontendModule::getSortOptions();
		}
		return $aResult;
	}

	public function saveData($mData) {
		return $this->oFrontendModule->widgetSave($mData);
	}
}
