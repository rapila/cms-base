<?php
/**
 * @package modules.widget
 */
class ImagePickerWidgetModule extends PersistentWidgetModule {
	
	private $aAllowedCategories = null;
	private $bAllowsMultiselect = false;
	
	public function listImages() {
		$oCriteria = new Criteria();
		if($this->aAllowedCategories !== null) {
			$oCriteria->add(DocumentPeer::DOCUMENT_CATEGORY_ID, $this->aAllowedCategories, Criteria::IN);
		}
		$oCriteria->add(DocumentPeer::DOCUMENT_TYPE_ID, array_keys(DocumentTypePeer::getDocumentTypeAndMimetypeByDocumentKind('image')), Criteria::IN);
		$aDocuments = DocumentPeer::doSelect($oCriteria);
		return WidgetJsonFileModule::jsonBaseObjects($aDocuments, array('name', 'description', 'id', 'language_id'));
	}
		
	public function setAllowsMultiselect($bAllowsMultiselect) {
			$this->bAllowsMultiselect = $bAllowsMultiselect;
	}

	public function getAllowsMultiselect() {
			return $this->bAllowsMultiselect;
	}
	
	public function setAllowedCategories($aAllowedCategories) {
		$this->aAllowedCategories = $aAllowedCategories;
	}
}