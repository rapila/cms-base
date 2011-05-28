<?php
/**
 * @package modules.widget
 */
class DocumentDetailWidgetModule extends PersistentWidgetModule {

	private $iDocumentId = null;
	
	public function setDocumentId($iDocumentId) {
		$this->iDocumentId = $iDocumentId;
	}
	
	public function getDocumentData() {
		$aResult = array();
		$oDocument = DocumentPeer::retrieveByPK($this->iDocumentId);
		$aResult = $oDocument->toArray(BasePeer::TYPE_PHPNAME, false);
		$aResult['FileInfo'] = $oDocument->getExtension().'/'.DocumentPeer::getDocumentSize($oDocument->getDataSize(), 'auto_iso');
		$aResult['CreatedInfo'] = Util::formatCreatedInfo($oDocument);
		$aResult['UpdatedInfo'] = Util::formatUpdatedInfo($oDocument);
    // self::addReferences($oDocument, $aResult);
		return $aResult;
	}
	
	private static function addReferences($oDocument, &$aResult) {
		if($oDocument->isInternallyManaged()) {
		  $aResult['References'] = array();
		  foreach(ReferencePeer::getReferences($oDocument) as $oReference) {
        $aResult['References'][] = $oReference->toArray();
		  }
		}
	}
	
	public static function documentPreview($iDocumentId, $iSize) {
		return DocumentPeer::retrieveByPK($iDocumentId)->getPreview($iSize);
	}
	
	public function preview() {
		return self::documentPreview($this->iDocumentId, 190);
	}
	
	public function validate($aDocumentData, $oDocument) {
		$oFlash = Flash::getFlash();
		$oFlash->setArrayToCheck($aDocumentData);
		if($this->iDocumentId === null) {
			$oFlash->addMessage('document.requires_file');
		}
		$oFlash->finishReporting();
	}
			
	public function saveData($aDocumentData) {
		if($this->iDocumentId === null) {
			$oDocument = new Document();
		} else {
			$oDocument = DocumentPeer::retrieveByPK($this->iDocumentId);
		}
		$this->validate($aDocumentData, $oDocument);
		if(!Flash::noErrors()) {
			throw new ValidationException();
		}
		$oDocument->setName($aDocumentData['name']);
		$oDocument->setDescription($aDocumentData['description'] == '' ? null : $aDocumentData['description']);
		$iOriginalDocCatId = $oDocument->getDocumentCategoryId();
		$sLanguageId = isset($aDocumentData['language_id']) && $aDocumentData['language_id'] != null ? $aDocumentData['language_id'] : null;
		$oDocument->setLanguageId($sLanguageId);
		
		// only handle if not called externally
		if($aDocumentData['is_called_externally'] === false) {
  		$oDocument->setDocumentCategoryId($aDocumentData['document_category_id']);
  		$oDocument->setIsProtected($aDocumentData['is_protected']);
  		if($oDocument->getDocumentCategoryId() != null) {
  			if($oDocument->isNew() || $oDocument->isColumnModified(DocumentPeer::DOCUMENT_CATEGORY_ID)) {
  				$oDocument->setSort(DocumentPeer::getHightestSortByCategory($oDocument->getDocumentCategoryId()) + 1);
  			}
  		}
		  $oDocument->setIsInactive(isset($aDocumentData['is_inactive']) && $aDocumentData['is_inactive']);
		}
    return $oDocument->save();
	}
}