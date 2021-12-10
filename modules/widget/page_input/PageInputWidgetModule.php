<?php
/**
 * @package modules.widget
 */
class PageInputWidgetModule extends WidgetModule {
	public function pages($bIncludeVirtual = false) {
		$cGather = function($oNavigationItem) use(&$cGather, $bIncludeVirtual) {
			if(!$bIncludeVirtual && !($oNavigationItem instanceof PageNavigationItem)) {
				return null;
			}
			$oResult = new StdClass();
			$oResult->page_id = $oNavigationItem->getPathId();
			$oResult->name = ($oNavigationItem->isRoot() ? '' : $oNavigationItem->getName()) . '/';
			$oResult->children = array_filter(
				array_map(
					$cGather,
					array_values($oNavigationItem->getChildren(null, false, true))
				),
				'boolval'
			);
			return $oResult;
		};
		return $cGather(PageNavigationItem::navigationItemForPage(PagePeer::getRootPage()));
	}
	
  public function getElementType() {
		return 'div';
	}
}
