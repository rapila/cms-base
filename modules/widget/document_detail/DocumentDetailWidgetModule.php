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
		$oDocument = DocumentPeer::retrieveByPK($this->iDocumentId);
		$aResult = $oDocument->toArray(BasePeer::TYPE_PHPNAME, false);
		$aResult['FileInfo'] = $oDocument->getExtension().'/'.DocumentUtil::getDocumentSize($oDocument->getDataSize(), 'auto_iso');
		$aResult['CreatedInfo'] = $oDocument->getCreatedAt(DetailWidgetModule::DATE_FORMAT).' / '.$oDocument->getUserRelatedByCreatedBy()->getUserName();
		$aResult['UpdatedInfo'] = $oDocument->getUpdatedAt(DetailWidgetModule::DATE_FORMAT).' / '.$oDocument->getUserRelatedByUpdatedBy()->getUserName();
		$aReferences = ReferencePeer::getReferences($oDocument);
		if(count($aReferences) > 0) {
			// $aResult['References'] = $aReferences[0]->toArray();
		}
		return $aResult;
	}
	
	public function preview() {
		$aOptions = array();
		$aOptions['document_id'] = $this->iDocumentId;
		$oDocument = DocumentPeer::retrieveByPK($this->iDocumentId);
		if($oDocument->getDocumentType()->getDocumentKind() === 'image') {
			// Objects don’t get displayed otherwise
			$aOptions['max_width'] = 190;
			$aOptions['max_height'] = 190;
		} else {
			$aOptions['width'] = 190;
			$aOptions['height'] = 142;
		}
		
		$oModule = FrontendModule::getModuleInstance('media_object', serialize(array($aOptions)));
		return $oModule->renderFrontend()->render();
	}
		
	public function saveData($aDocumentData) {
		if($this->iDocumentId === null) {
			$oDocument = new Document();
		} else {
			$oDocument = DocumentPeer::retrieveByPK($this->iDocumentId);
		}
		$oDocument->setName($aDocumentData['name']);
		$oDocument->setDescription($aDocumentData['description'] == '' ? null : $aDocumentData['description']);
		$oDocument->setDocumentCategoryId($aDocumentData['document_category_id']);
		$sLanguageId = isset($aDocumentData['language_id']) && $aDocumentData['language_id'] != null ? $aDocumentData['language_id'] : null;
		$oDocument->setLanguageId($sLanguageId);
		$oDocument->setIsProtected(isset($aDocumentData['is_protected']));
		$oDocument->setIsInactive(isset($aDocumentData['is_inactive']));
		return $oDocument->save();
	}
}