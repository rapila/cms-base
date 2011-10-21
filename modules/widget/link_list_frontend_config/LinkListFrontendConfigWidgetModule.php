<?php
class LinkListFrontendConfigWidgetModule extends FrontendConfigWidgetModule {
	public function allLinks($aOptions = array()) {
		$oCriteria = LinkQuery::create();

		if(isset($aOptions['link_categories']) && is_array($aOptions['link_categories']) && (count($aOptions['link_categories']) > 0)) {
			$oCriteria->add(LinkPeer::LINK_CATEGORY_ID, $aOptions['link_categories'], Criteria::IN);
		}
		if(isset($aOptions['sort_by']) && $aOptions['sort_by'] === LinkListFrontendModule::SORT_BY_SORT) {
			$oCriteria->orderBySort();
		}
		$oCriteria->filterByDisplayLanguage(AdminManager::getContentLanguage())->orderByName();
		$oCriteria->clearSelectColumns()->addSelectColumn(LinkPeer::ID)->addSelectColumn(LinkPeer::NAME);
		return LinkPeer::doSelectStmt($oCriteria)->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function getConfigurationModes() {
		$aResult = array();
		$aLinkCategories = LinkListFrontendModule::getCategoryOptions();
		$aResult['link_categories'] = $aLinkCategories;
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
