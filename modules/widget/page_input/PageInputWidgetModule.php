<?php
/**
 * @package modules.widget
 */
class PageInputWidgetModule extends WidgetModule {
	
	public function pages() {
		$aResult = array();
		$cGather = function($oIterator, $iLevel) use(&$aResult, &$cGather) {
			$oCurrentPage = null;
			while(($oCurrentPage = $oIterator->current()) !== null) {
				$oResult = new StdClass();
				$oResult->level = $iLevel;
				$oResult->page_id = $oCurrentPage->getId();
				$oResult->name = $oCurrentPage->getName();
				$aResult[] = $oResult;
				if($oIterator->hasChildren()) {
					$cGather($oIterator->getChildren(), $iLevel+1);
				}
				$oIterator->next();
			}
		};
		$cGather(PagePeer::getRootPage()->getIterator(), 0);
		return $aResult;
	}
	
  public function getElementType() {
		return 'select';
	}
}
