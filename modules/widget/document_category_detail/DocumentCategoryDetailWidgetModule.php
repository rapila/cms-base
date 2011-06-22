<?php
/**
 * @package modules.widget
 */
class DocumentCategoryDetailWidgetModule extends PersistentWidgetModule {

	private $iCategoryId = null;
	
	public function setCategoryId($iCategoryId) {
		$this->iCategoryId = $iCategoryId;
	}
	
	public function categoryData() {
		$oDocumentCategory = DocumentCategoryPeer::retrieveByPK($this->iCategoryId);
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
			$oCategory = DocumentCategoryPeer::retrieveByPK($this->iCategoryId);
		}
		$oCategory->setName($aDocumentCategoryData['name']);
		$oCategory->setMaxWidth($aDocumentCategoryData['max_width'] == null ? null : $aDocumentCategoryData['max_width']);
		$oCategory->setIsExternallyManaged($aDocumentCategoryData['is_externally_managed']);
		
		$oCategory->setIsInactive(isset($aDocumentCategoryData['is_inactive']));
    $this->validate($aDocumentCategoryData);
		if(!Flash::noErrors()) {
			throw new ValidationException();
		}

		return $oCategory->save();
	}
}