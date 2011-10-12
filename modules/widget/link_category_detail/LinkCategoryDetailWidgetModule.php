<?php
/**
 * @package modules.widget
 */
class LinkCategoryDetailWidgetModule extends PersistentWidgetModule {

	private $iCategoryId = null;
	
	public function setLinkCategoryId($iCategoryId) {
		$this->iCategoryId = $iCategoryId;
	}
	
	public function getLinkCategoryData() {
		$oLinkCategory = LinkCategoryPeer::retrieveByPK($this->iCategoryId);
		$aResult = $oLinkCategory->toArray();
		$aResult['CreatedInfo'] = Util::formatCreatedInfo($oLinkCategory);
		$aResult['UpdatedInfo'] = Util::formatUpdatedInfo($oLinkCategory);
    return $aResult;
	}

	private function validate($aLinkCategoryData) {
		$oFlash = Flash::getFlash();
		$oFlash->setArrayToCheck($aLinkCategoryData);
		$oFlash->checkForValue('name', 'name_required');
		$oFlash->finishReporting();
	}
	
	public function saveData($aLinkCategoryData) {
		if($this->iCategoryId === null) {
			$oCategory = new LinkCategory();
		} else {
			$oCategory = LinkCategoryPeer::retrieveByPK($this->iCategoryId);
		}
		$oCategory->setName($aLinkCategoryData['name']);
		$oCategory->setIsExternallyManaged($aLinkCategoryData['is_externally_managed']);
    $this->validate($aLinkCategoryData);
		if(!Flash::noErrors()) {
			throw new ValidationException();
		}
		return $oCategory->save();
	}
}