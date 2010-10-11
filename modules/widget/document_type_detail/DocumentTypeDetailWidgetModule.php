<?php
/**
 * @package modules.widget
 */
class DocumentTypeDetailWidgetModule extends PersistentWidgetModule {

	private $iTypeId = null;
	
	public function setTypeId($iTypeId) {
		$this->iTypeId = $iTypeId;
	}
	
	public function getTypeData() {
		return DocumentTypePeer::retrieveByPK($this->iTypeId)->toArray();
	}
	
	private function validate($aDocumentTypeData) {
		$oFlash = Flash::getFlash();
		$oFlash->setArrayToCheck($aDocumentTypeData);
		$oFlash->checkForValue('extension', 'extension_required');
		$oFlash->checkForValue('mimetype', 'mimetype_required');
		$oFlash->finishReporting();
	}

	public function saveData($aDocumentTypeData) {
		if($this->iTypeId === null) {
			$oType = new DocumentType();
		} else {
			$oType = DocumentTypePeer::retrieveByPK($this->iTypeId);
		}
		$this->validate($aDocumentTypeData);
		if(!Flash::noErrors()) {
			throw new ValidationException();
		}

		$oType->setExtension($aDocumentTypeData['extension']);
		$oType->setMimetype($aDocumentTypeData['mimetype']);
		return $oType->save();
	}
}