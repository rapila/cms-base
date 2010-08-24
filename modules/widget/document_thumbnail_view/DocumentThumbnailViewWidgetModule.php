<?php
/**
 * @package modules.widget
 */
class DocumentThumbnailViewWidgetModule extends PersistentWidgetModule {
	
	private $aAllowedCategories = null;
	private $sDocumentKind = null;
	
	private $bInitialAllowsMultiselect = false;
	
	public function listImages() {
		$oCriteria = new Criteria();
		if($this->aAllowedCategories !== null) {
			$oCriteria->add(DocumentPeer::DOCUMENT_CATEGORY_ID, $this->aAllowedCategories, Criteria::IN);
		}
		if($this->sDocumentKind !== null) {
			$oCriteria->add(DocumentPeer::DOCUMENT_TYPE_ID, array_keys(DocumentTypePeer::getDocumentTypeAndMimetypeByDocumentKind($this->sDocumentKind)), Criteria::IN);
		}
		$aDocuments = DocumentPeer::doSelect($oCriteria);
		return WidgetJsonFileModule::jsonBaseObjects($aDocuments, array('name', 'description', 'id', 'language_id'));
	}
		
	public function setInitialAllowsMultiselect($bInitialAllowsMultiselect) {
			$this->bInitialAllowsMultiselect = $bInitialAllowsMultiselect;
	}

	public function getInitialAllowsMultiselect() {
			return $this->bInitialAllowsMultiselect;
	}
	
	public function setDocumentKind($sDocumentKind) {
	    $this->sDocumentKind = $sDocumentKind;
	}

	public function getDocumentKind() {
	    return $this->sDocumentKind;
	}
	
	public function setAllowedCategories($aAllowedCategories) {
		$this->aAllowedCategories = $aAllowedCategories;
	}
	
	public function getElementType() {
		return null;
	}
}