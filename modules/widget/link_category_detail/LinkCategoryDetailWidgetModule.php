<?php
/**
 * @package modules.widget
 */
class LinkCategoryDetailWidgetModule extends PersistentWidgetModule {

	private $iLinkCategoryId = null;

	public function setLinkCategoryId($iLinkCategoryId) {
		$this->iLinkCategoryId = $iLinkCategoryId;
	}

	public function loadData() {
		$oLinkCategory = LinkCategoryQuery::create()->findPk($this->iLinkCategoryId);
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
		if($this->iLinkCategoryId === null) {
			$oLinkCategory = new LinkCategory();
		} else {
			$oLinkCategory = LinkCategoryQuery::create()->findPk($this->iLinkCategoryId);
		}
		$this->validate($aLinkCategoryData);
		if(!Flash::noErrors()) {
			throw new ValidationException();
		}
		$oLinkCategory->setName($aLinkCategoryData['name']);
		$oLinkCategory->setIsExternallyManaged($aLinkCategoryData['is_externally_managed']);
		$oLinkCategory->save();

		$oResult = new stdClass();
		if($this->iLinkCategoryId === null) {
			$oResult->inserted = true;
		} else {
			$oResult->updated = true;
		}
		$oResult->id = $this->iLinkCategoryId = $oLinkCategory->getId();
		return $oResult;
	}
}
