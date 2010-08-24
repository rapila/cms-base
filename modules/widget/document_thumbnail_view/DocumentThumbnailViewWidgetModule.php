<?php
/**
 * @package modules.widget
 */
class DocumentThumbnailViewWidgetModule extends PersistentWidgetModule {
	
	private $iDocumentCategoryId = null;
	private $sDocumentKind = null;
	
	private $bInitialAllowsMultiselect = false;
	
	public function listImages($iThumbnailSize) {
		$oCriteria = new Criteria();
		if($this->iDocumentCategoryId !== null && $this->iDocumentCategoryId !== CriteriaListWidgetDelegate::SELECT_ALL) {
			$oCriteria->add(DocumentPeer::DOCUMENT_CATEGORY_ID, $this->iDocumentCategoryId);
		}
		if($this->sDocumentKind !== null && $this->sDocumentKind !== CriteriaListWidgetDelegate::SELECT_ALL) {
			$oCriteria->add(DocumentPeer::DOCUMENT_TYPE_ID, array_keys(DocumentTypePeer::getDocumentTypeAndMimetypeByDocumentKind($this->sDocumentKind)), Criteria::IN);
		}
		$aDocuments = DocumentPeer::doSelect($oCriteria);
		$aResults = array();
		foreach($aDocuments as $oDocument) {
			$aResults[] = array('name' => $oDocument->getName(), 'description' => $oDocument->getDescription(), 'id' => $oDocument->getId(), 'preview' => DocumentDetailWidgetModule::documentPreview($oDocument->getId(), $iThumbnailSize));
		}
		return $aResults;
	}
		
	public function setInitialAllowsMultiselect($bInitialAllowsMultiselect) {
		$this->bInitialAllowsMultiselect = $bInitialAllowsMultiselect;
	}

	public function getInitialAllowsMultiselect() {
		return $this->bInitialAllowsMultiselect;
	}
	
	public function setDocumentKind($sDocumentKind) {
		if($this->sDocumentKind == $sDocumentKind) {
			return false;
		}
		$this->sDocumentKind = $sDocumentKind;
		return true;
	}

	public function getDocumentKind() {
		return $this->sDocumentKind;
	}
	
	public function setDocumentCategoryId($iDocumentCategoryId) {
		if($this->iDocumentCategoryId == $iDocumentCategoryId) {
			return false;
		}
		$this->iDocumentCategoryId = $iDocumentCategoryId;
		return true;
	}

	public function getDocumentCategoryId() {
		return $this->iDocumentCategoryId;
	}
		
	public function getElementType() {
		return 'div';
	}
}