<?php
class TagFrontendConfigWidgetModule extends FrontendConfigWidgetModule {
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
}