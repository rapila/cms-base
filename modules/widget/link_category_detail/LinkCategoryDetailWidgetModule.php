<?php
/**
 * @package modules.widget
 */
class LinkCategoryDetailWidgetModule extends PersistentWidgetModule {

	private $iCategoryId = null;
	
	public function setCategoryId($iCategoryId) {
		$this->iCategoryId = $iCategoryId;
	}
	
	public function getCategoryData() {
		$oLinkCategory = LinkCategoryPeer::retrieveByPK($this->iCategoryId);
		$aResult = $oLinkCategory->toArray();
		$aResult['CreatedInfo'] = Util::formatCreatedInfo($oLinkCategory);
		$aResult['UpdatedInfo'] = Util::formatUpdatedInfo($oLinkCategory);
    return $aResult;
	}

	private function validate($aLinkTypeData) {
		$oFlash = Flash::getFlash();
		$oFlash->setArrayToCheck($aLinkTypeData);
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