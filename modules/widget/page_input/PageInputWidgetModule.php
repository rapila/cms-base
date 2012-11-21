<?php
/**
 * @package modules.widget
 */
class PageInputWidgetModule extends WidgetModule {
	
	public function pages($bIncludeVirtual = false) {
		$aResult = array();
		$cGather = function($aNavigationItems, $iLevel) use(&$aResult, &$cGather, $bIncludeVirtual) {
			foreach($aNavigationItems as $oNavigationItem) {
				if(!$bIncludeVirtual && !($oNavigationItem instanceof PageNavigationItem)) {
					continue;
				}
				$oResult = new StdClass();
				$oResult->level = $iLevel;
				$oResult->page_id = $oNavigationItem->getId();
				$oResult->name = $oNavigationItem->getName();
				$aResult[] = $oResult;
				if($oNavigationItem->hasChildren(null, false, true)) {
					$cGather($oNavigationItem->getChildren(null, false, true), $iLevel+1);
				}
			}
		};
		$cGather(array(PageNavigationItem::navigationItemForPage(PagePeer::getRootPage())), 0);
		return $aResult;
	}
	
  public function getElementType() {
		return 'select';
	}
}
