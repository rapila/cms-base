<?php
/**
 * @package modules.widget
 */
class PageDetailWidgetModule extends PersistentWidgetModule {
	private $iPageId = null;
	
	public function setPageId($iPageId) {
		$this->iPageId = $iPageId;
	}
	
	public function getPageData() {
		return PagePeer::retrieveByPK($this->iPageId)->toArray();
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