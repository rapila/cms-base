<?php
/**
 * @package modules.widget
 */
class DocumentThumbnailViewWidgetModule extends PersistentWidgetModule {
	
	private $iDocumentCategoryId = null;
	private $sDocumentKind = null;
	
	private $bInitialAllowsMultiselect = false;
	
	public function listDocuments($iThumbnailSize) {
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
			$aResults[] = $this->rowData($oDocument, $iThumbnailSize);
		}
		return $aResults;
	}
	
	private function rowData($oDocument, $iThumbnailSize) {
		return array('name' => $oDocument->getName(), 'description' => $oDocument->getDescription(), 'id' => $oDocument->getId(), 'preview' => $this->thumbnail($oDocument->getId(), $iThumbnailSize));
	}
	
	public function singleDocument($iDocumentId, $iThumbnailSize) {
		return $this->rowData(DocumentPeer::retrieveByPK($iDocumentId), $iThumbnailSize);
	}
	
	public function thumbnail($iDocumentId, $iThumbnailSize) {
		return DocumentDetailWidgetModule::documentPreview($iDocumentId, $iThumbnailSize);
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