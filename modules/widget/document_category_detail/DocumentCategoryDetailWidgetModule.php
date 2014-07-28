<?php
/**
 * @package modules.widget
 */
class DocumentCategoryDetailWidgetModule extends PersistentWidgetModule {

	private $iDocumentCategoryId = null;

	public function setDocumentCategoryId($iDocumentCategoryId) {
		$this->iDocumentCategoryId = $iDocumentCategoryId;
	}

	public function categoryData() {
		$oDocumentCategory = DocumentCategoryQuery::create()->findPk($this->iDocumentCategoryId);
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
		if($this->iDocumentCategoryId === null) {
			$oDocumentCategory = new DocumentCategory();
		} else {
			$oDocumentCategory = DocumentCategoryQuery::create()->findPk($this->iDocumentCategoryId);
		}
		$this->validate($aDocumentCategoryData);
		if(!Flash::noErrors()) {
			throw new ValidationException();
		}

		$oDocumentCategory->setMaxWidth($aDocumentCategoryData['max_width'] == null ? null : $aDocumentCategoryData['max_width']);
		$oDocumentCategory->setName($aDocumentCategoryData['name']);
		$oDocumentCategory->setIsExternallyManaged($aDocumentCategoryData['is_externally_managed']);
		$oDocumentCategory->save();

		$oResult = new stdClass();
		if($this->iDocumentCategoryId === null) {
			$oResult->inserted = true;
		} else {
			$oResult->updated = true;
		}
		$oResult->id = $this->iDocumentCategoryId = $oDocumentCategory->getId();
		return $oResult;
	}
}