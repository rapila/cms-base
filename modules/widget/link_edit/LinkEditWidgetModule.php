<?php
class LinkEditWidgetModule extends PersistentWidgetModule {
	private $oFrontendModule;
	private $sDisplayMode;
	
	public function __construct($sSessionKey, $oFrontendModule) {
		parent::__construct($sSessionKey);
		$this->oFrontendModule = $oFrontendModule;
		$this->sDisplayMode = $this->oFrontendModule->widgetData();
	}
	
	public function setDisplayMode($sDisplayMode) {
		$this->sDisplayMode = $sDisplayMode;
	}

	public function getDisplayMode($sKey=null) {
		if($sKey === null) {
			return $this->sDisplayMode;
		}
		if(isset($this->sDisplayMode[$sKey])) {
			return $this->sDisplayMode[$sKey];
		}
		return null;
	}
	
	public function allLinks() {
		$aOptions = $this->sDisplayMode;
		$oCriteria = LinkQuery::create();

		if(isset($aOptions['link_category_option']) && is_array($aOptions['link_category_option']) && (count($aOptions['link_category_option']) > 0)) {
			$oCriteria->add(LinkPeer::LINK_CATEGORY_ID, $aOptions['link_category_option'], Criteria::IN);
		}
		if(isset($aOptions['sort_option']) && $aOptions['sort_option'] === LinkListFrontendModule::SORT_OPTION_BY_SORT) {
			$oCriteria->orderBySort();
		}
		$oCriteria->orderByName();
		$oCriteria->clearSelectColumns()->addSelectColumn(LinkPeer::ID)->addSelectColumn(LinkPeer::NAME);
		return LinkPeer::doSelectStmt($oCriteria)->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function getConfigurationModes() {
		$aResult = array();
		$aResult['link_category_option'] = LinkListFrontendModule::getCategoryOptions();
		$aResult['template_option'] = LinkListFrontendModule::getTemplateOptions();
		$aResult['sort_option'] = LinkListFrontendModule::getSortOptions();
		return $aResult;
	}
	
	public function saveData($mData) {
		return $this->oFrontendModule->widgetSave($mData);
	}
	
	public function getElementType() {
		return 'form';
	}
}