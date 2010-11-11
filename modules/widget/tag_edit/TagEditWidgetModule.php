<?php
class TagEditWidgetModule extends PersistentWidgetModule {
	private $oFrontendModule;
	private $sDisplayMode;
	
	public function __construct($sSessionKey, $oFrontendModule) {
		parent::__construct($sSessionKey);
		$this->oFrontendModule = $oFrontendModule;
		$this->sDisplayMode = $this->oFrontendModule->widgetData();
	}
	
	public function getConfiguredMode() {
		return $this->sDisplayMode;
	}
	
	public function allTagedItems() {
	}
	
	public function getConfigurationModes() {
		$aResult = array();
		$aResult['templates'] = AdminManager::getSiteTemplatesForListOutput();
		$aResult['tags'] = array();
		foreach(TagPeer::doSelect(new Criteria()) as $oTag) {
			$aResult['tags'][] = array('name' => $oTag->getName(), 'count' => $oTag->countTagInstances(), 'id' => $oTag->getId());
		}
		$aResult['types'] = TagInstancePeer::getTaggedModels();
		return $aResult;
	}
	
	public function saveData($mData) {
		return $this->oFrontendModule->widgetSave($mData);
	}
	
	public function getElementType() {
		return 'form';
	}
}