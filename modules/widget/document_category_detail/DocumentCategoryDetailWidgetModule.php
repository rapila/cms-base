<?php
/**
 * @package modules.widget
 */
class DocumentCategoryDetailWidgetModule extends PersistentWidgetModule {

	private $iCategoryId = null;
	
	public function setCategoryId($iCategoryId) {
		$this->iCategoryId = $iCategoryId;
	}
	
	public function getCategoryData() {
		return DocumentCategoryPeer::retrieveByPK($this->iCategoryId)->toArray();
	}
	
	public function saveData($aDocumentCategoryData) {
		if($this->iCategoryId === null) {
			$oCategory = new DocumentCategory();
		} else {
			$oCategory = DocumentCategoryPeer::retrieveByPK($this->iCategoryId);
		}
		$oCategory->setName($aDocumentCategoryData['name']);
		$oCategory->setMaxWidth($aDocumentCategoryData['max_width'] == null ? null : $aDocumentCategoryData['max_width']);
		$oCategory->setIsExternallyManaged(isset($aDocumentCategoryData['is_externally_managed']));
		$oCategory->setIsInactive(isset($aDocumentCategoryData['is_inactive']));
		return $oCategory->save();
	}
}