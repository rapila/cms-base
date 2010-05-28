<?php
/**
 * @package modules.widget
 */
class PageDetailWidgetModule extends PersistentWidgetModule {
	private $iPageId = null;
	
	public function doWidget() {
		return $this->constructTemplate('edit');
	}
	
	public function setPageId($iPageId) {
		$this->iPageId = $iPageId;
	}
	
	public function getPageData() {
		$oPage = PagePeer::retrieveByPK($this->iPageId);
		$aResult = $oPage->toArray(BasePeer::TYPE_PHPNAME, false);
		$oPageString = $oPage->getActivePageString();
		$aResult['active_page_string'] = $oPageString->toArray(BasePeer::TYPE_PHPNAME, false);
		$aResult['active_page_string']['LinkTextOnly'] = $oPageString->getLinkTextOnly();
		$aResult['PageHref'] = 'http://Weblink';
		return $aResult;
	}
	
	public function saveData($aPageData) {
		if($this->iPageId === null) {
			$oPage = new Page();
		} else {
			$oPage = PagePeer::retrieveByPK($this->iPageId);
		}
		$oPage->setName($aPageData['name']);
		$oPage->setIsInactive(isset($aPageData['is_inactive']));
		return $oPage->save();
	}
}