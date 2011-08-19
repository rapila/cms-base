<?php
/**
 * @package modules.widget
 */
class ImagePickerWidgetModule extends PersistentWidgetModule {
	
	private $aAllowedCategories = null;
	
	public function listImages() {
		$oCriteria = new Criteria();
		if($this->aAllowedCategories !== null) {
			$oCriteria->add(DocumentPeer::DOCUMENT_CATEGORY_ID, $this->aAllowedCategories, Criteria::IN);
		}
		$oCriteria->add(DocumentPeer::DOCUMENT_TYPE_ID, array_keys(DocumentTypePeer::getDocumentTypeAndMimetypeByDocumentKind('image')), Criteria::IN);
		// always exclude externally managed images
		$oCriteria->addJoin(DocumentPeer::DOCUMENT_CATEGORY_ID, DocumentCategoryPeer::ID);
		$oCriteria->add(DocumentCategoryPeer::IS_EXTERNALLY_MANAGED, false);
		$aDocuments = DocumentPeer::doSelect($oCriteria);
		return WidgetJsonFileModule::jsonBaseObjects($aDocuments, array('name', 'description', 'id', 'language_id'));
	}
		
	public function setAllowsMultiselect($bAllowsMultiselect) {
		$this->setSetting('allows_multiselect', $bAllowsMultiselect);
	}
	
	public function setAllowedCategories($aAllowedCategories) {
		$this->aAllowedCategories = $aAllowedCategories;
	}
	
	public function getElementType() {
		return 'div';
	}
}