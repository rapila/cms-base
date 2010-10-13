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
		$aResult['CreatedInfo'] = Util::formatCreatedAtForAdmin($oDocument).' / '.Util::getCreatedByIfSet($oDocument);
		$aResult['UpdatedInfo'] = Util::formatUpdatedAtForAdmin($oDocument).' / '.Util::getUpdatedByIfSet($oDocument);
		$aReferences = ReferencePeer::getReferences($oDocument);
		if(count($aReferences) > 0) {
			// $aResult['References'] = $aReferences[0]->toArray();
		}
		return $aResult;
	}
	
	public static function documentPreview($iDocumentId, $iSize) {
		$aOptions = array();
		$aOptions['document_id'] = $iDocumentId;
		$oDocument = DocumentPeer::retrieveByPK($iDocumentId);
		if($oDocument->getDocumentType()->getDocumentKind() === 'image') {
			// Objects don’t get displayed otherwise
			$aOptions['max_width'] = $iSize;
			$aOptions['max_height'] = $iSize;
			$aOptions['force_refresh'] = true;
		} else {
			$aOptions['width'] = $iSize;
			$aOptions['height'] = $iSize*0.747;
		}
		
		$oModule = FrontendModule::getModuleInstance('media_object', serialize(array($aOptions)));
		return $oModule->renderFrontend()->render();
	}
	
	public function preview() {
		return self::documentPreview($this->iDocumentId, 190);
	}
	
	private function validate($aDocumentData) {
		$oFlash = Flash::getFlash();
		$oFlash->setArrayToCheck($aDocumentData);
		$oFlash->checkForValue('name', 'name_required');
		$oFlash->finishReporting();
	}
		
	public function saveData($aDocumentData) {
		if($this->iDocumentId === null) {
			$oDocument = new Document();
		} else {
			$oDocument = DocumentPeer::retrieveByPK($this->iDocumentId);
		}
		$this->validate($aDocumentData);
		if(!Flash::noErrors()) {
			throw new ValidationException();
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