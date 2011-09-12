<?php
/**
 * @package modules.widget
 */
class ImagePickerWidgetModule extends PersistentWidgetModule {
	
	private $aDisplayedCategories = null;
	
	public function listImages() {
		$oCriteria = new Criteria();
		if($this->aDisplayedCategories !== null) {
			$oCategoriesCriterion = null;
			foreach($this->aDisplayedCategories as $sValue) {
				$sValue = CriteriaListWidgetDelegate::SELECT_WITHOUT === $sValue ? null : $sValue;
				if($oCategoriesCriterion === null) {
					$oCategoriesCriterion = $oCriteria->getNewCriterion(DocumentPeer::DOCUMENT_CATEGORY_ID, $sValue);
				} else {
					$oCategoriesCriterion->addOr($oCriteria->getNewCriterion(DocumentPeer::DOCUMENT_CATEGORY_ID, $sValue));
				}
			}			
			$oCriteria->add($oCategoriesCriterion);
		}
		$oCriteria->add(DocumentPeer::DOCUMENT_TYPE_ID, array_keys(DocumentTypePeer::getDocumentTypeAndMimetypeByDocumentKind('image')), Criteria::IN);
		// always exclude externally managed images
		$oCriteria->addJoin(DocumentPeer::DOCUMENT_CATEGORY_ID, DocumentCategoryPeer::ID, Criteria::LEFT_JOIN);
		$oCriteria->add(DocumentCategoryPeer::IS_EXTERNALLY_MANAGED, false);
		$aDocuments = DocumentPeer::doSelect($oCriteria);
		return WidgetJsonFileModule::jsonBaseObjects($aDocuments, array('name', 'description', 'id', 'language_id'));
	}
		
	public function setAllowsMultiselect($bAllowsMultiselect) {
		$this->setSetting('allows_multiselect', $bAllowsMultiselect);
	}
	
	public function setDisplayedCategories($aDisplayedCategories) {
		$this->aDisplayedCategories = $aDisplayedCategories;
	}
	
	public function getElementType() {
		return 'div';
	}
}