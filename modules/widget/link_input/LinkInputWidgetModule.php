<?php
/**
 * @package modules.widget
 */
class LinkInputWidgetModule extends WidgetModule {
	
	public function getExternalLinks() {
		$aCategories = LinkCategoryPeer::getAllSorted(true);
		foreach($aCategories as $oCategory) {
			$aLinks = LinkPeer::getLinksByLinkCategory($oCategory->getId());
			foreach($aLinks as $oLink) {
				$aResult[$oCategory->getName()][$oLink->getId()] = $oLink->getName();
			}
		}
		$sWithoutCategory = StringPeer::getString('widget.links.select_without_title');
		foreach(self::getLinksWithoutCategoryId() as $oLink) {
			$aResult[$sWithoutCategory][$oLink->getId()] = $oLink->getName();
		}
		return $aResult;
	}

	private static function getLinksWithoutCategoryId() {
		$oCriteria = new Criteria();
		$oCriteria->add(LinkPeer::LINK_CATEGORY_ID, null, Criteria::ISNULL);
		$oCriteria->addAscendingOrderByColumn(LinkPeer::NAME);
		return LinkPeer::doSelect($oCriteria);
	}
	
	public function getElementType() {
		return 'select';
	}
}