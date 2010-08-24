<?php
/**
 * @package modules.widget
 */
class DocumentThumbnailViewWidgetModule extends PersistentWidgetModule {
	
	private $iDocumentCategoryId = null;
	private $sDocumentKind = null;
	
	private $bInitialAllowsMultiselect = false;
	
	public function listImages() {
		$oCriteria = new Criteria();
		if($this->iDocumentCategoryId !== null && $this->iDocumentCategoryId !== CriteriaListWidgetDelegate::SELECT_ALL) {
			$oCriteria->add(DocumentPeer::DOCUMENT_CATEGORY_ID, $this->iDocumentCategoryId);
		}
		if($this->sDocumentKind !== null && $this->sDocumentKind !== CriteriaListWidgetDelegate::SELECT_ALL) {
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
	
	public function setDocumentCategoryId($iDocumentCategoryId) {
	    $this->iDocumentCategoryId = $iDocumentCategoryId;
	}

	public function getDocumentCategoryId() {
	    return $this->iDocumentCategoryId;
	}
		
	public function getElementType() {
		return 'div';
	}
}