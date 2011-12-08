<?php
/**
 * @package modules.widget
 */
class LinkInputWidgetModule extends WidgetModule {
	
	public function externalLinks() {		
		$aResult = array();
		foreach(LinkCategoryQuery::create()->filterByHasLinks()->orderByName()->find() as $oLinkCategory) {
			foreach(LinkQuery::create()->filterByLinkCategoryId($oLinkCategory->getId())->orderByName()->find() as $oLink) {
				$aResult[$oLinkCategory->getName()][$oLink->getId()] = $oLink->getName();
			}
		}
		$sWithoutCategory = StringPeer::getString('wns.links.select_without_title');
		foreach(LinkQuery::create()->filterByLinkCategoryId(null, Criteria::ISNULL)->orderByName()->find() as $oLink) {
			$aResult[$sWithoutCategory][$oLink->getId()] = $oLink->getName();
		}		
		return $aResult;
	}

	public function getElementType() {
		return 'select';
	}
}
