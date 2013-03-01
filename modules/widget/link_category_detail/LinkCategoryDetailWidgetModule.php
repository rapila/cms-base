<?php
/**
 * @package modules.widget
 */
class LinkCategoryDetailWidgetModule extends PersistentWidgetModule {

	private $iCategoryId = null;
	
	public function setLinkCategoryId($iCategoryId) {
		$this->iCategoryId = $iCategoryId;
	}
	
	public function loadData() {
		$oLinkCategory = LinkCategoryQuery::create()->findPk($this->iCategoryId);
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
			$oCategory = LinkCategoryQuery::create()->findPk($this->iCategoryId);
		}
		$oCategory->fromArray($aLinkCategoryData, BasePeer::TYPE_FIELDNAME);
		if($aLinkCategoryData['max_width'] == null) {
			$oCategory->setMaxWidth(null);
		}
		$this->validate($aLinkCategoryData);
		if(!Flash::noErrors()) {
			throw new ValidationException();
		}
		$oCategory->save();
		
		$oResult = new stdClass();
		$oResult->id = $oCategory->getId();
		if($this->iCategoryId === null) {
			$oResult->inserted = true;
		} else {
			$oResult->updated = true;
		}
		$this->iCategoryId = $oResult->id;
		return $oResult;
	}
}