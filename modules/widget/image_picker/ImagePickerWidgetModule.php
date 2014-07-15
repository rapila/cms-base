<?php
/**
 * @package modules.widget
 */
class ImagePickerWidgetModule extends PersistentWidgetModule {

	private $aDisplayedCategories = null;

	public function listImages() {
		$oCriteria = DocumentQuery::create();
		if($this->aDisplayedCategories !== null) {
			$oCategoriesCriterion = null;
			foreach($this->aDisplayedCategories as $sValue) {
				$mComparison = $sValue === CriteriaListWidgetDelegate::SELECT_WITHOUT ? Criteria::ISNULL : Criteria::EQUAL;
				$sValue = $mComparison === Criteria::ISNULL ? null : $sValue;
				if($oCategoriesCriterion === null) {
					$oCategoriesCriterion = $oCriteria->getNewCriterion(DocumentPeer::DOCUMENT_CATEGORY_ID, $sValue, $mComparison);
				} else {
					$oCategoriesCriterion->addOr($oCriteria->getNewCriterion(DocumentPeer::DOCUMENT_CATEGORY_ID, $sValue, $mComparison));
				}
			}
			$oCriteria->add($oCategoriesCriterion);
		}
		$oCriteria->filterByDocumentKind('image');
		// always exclude externally managed images
		$oCriteria->excludeExternallyManaged();
		return WidgetJsonFileModule::jsonBaseObjects($oCriteria->find(), array('name', 'description', 'id', 'language_id'));
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
