<?php
/**
 * @package modules.widget
 */
class DocumentCategoryDetailWidgetModule extends PersistentWidgetModule {

	private $iCategoryId = null;
	
	public function setDocumentCategoryId($iCategoryId) {
		$this->iCategoryId = $iCategoryId;
	}
	
	public function categoryData() {
		$oDocumentCategory = DocumentCategoryQuery::create()->findPk($this->iCategoryId);
		$aResult = $oDocumentCategory->toArray();
		$aResult['CreatedInfo'] = Util::formatCreatedInfo($oDocumentCategory);
		$aResult['UpdatedInfo'] = Util::formatUpdatedInfo($oDocumentCategory);
    return $aResult;
	}

	private function validate($aDocumentTypeData) {
		$oFlash = Flash::getFlash();
		$oFlash->setArrayToCheck($aDocumentTypeData);
		$oFlash->checkForValue('name', 'name_required');
		$oFlash->finishReporting();
	}
	
	public function saveData($aDocumentCategoryData) {
		if($this->iCategoryId === null) {
			$oCategory = new DocumentCategory();
		} else {
			$oCategory = DocumentCategoryQuery::create()->findPk($this->iCategoryId);
		}
		$oCategory->fromArray($aDocumentCategoryData, BasePeer::TYPE_FIELDNAME);
		if($aDocumentCategoryData['max_width'] == null) {
			$oCategory->setMaxWidth(null);
		}
    $this->validate($aDocumentCategoryData);
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