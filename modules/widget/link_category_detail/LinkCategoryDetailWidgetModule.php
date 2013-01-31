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
		$mReload = LinkCategoryQuery::create()->count() === 0 ? 'reload_list' : null;
		if(!Flash::noErrors()) {
			throw new ValidationException();
		}
		$aResult = $oCategory->save();
		if($mReload) {
			return $mReload;
		}
		return $aResult;
	}
}