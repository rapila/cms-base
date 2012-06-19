<?php
/**
 * @package modules.widget
 */
class DocumentTypeDetailWidgetModule extends PersistentWidgetModule {

	private $iTypeId = null;
	
	public function setTypeId($iTypeId) {
		$this->iTypeId = $iTypeId;
	}
	
	public function typeData() {
		return DocumentTypeQuery::create()->findPk($this->iTypeId)->toArray();
	}
	
	private function validate($aDocumentTypeData, $oType) {
		$oFlash = Flash::getFlash();
		$oFlash->setArrayToCheck($aDocumentTypeData);
		if($oFlash->checkForValue('extension', 'extension_required') & $oFlash->checkForValue('mimetype', 'mimetype_required')) {
			if(($oType->getExtension() !== $aDocumentTypeData['extension'] || $oType->getMimetype() !== $aDocumentTypeData['mimetype'])
				&& DocumentTypeQuery::create()->filterByExtension($aDocumentTypeData['extension'])->filterByMimetype($aDocumentTypeData['mimetype'])->count() > 0) {
				$oFlash->addMessage('document_type_duplicate');
			}
		}
		$oFlash->finishReporting();
	}

	public function saveData($aDocumentTypeData) {
		if($this->iTypeId === null) {
			$oType = new DocumentType();
		} else {
			$oType = DocumentTypeQuery::create()->findPk($this->iTypeId);
		}
		$this->validate($aDocumentTypeData, $oType);
		if(!Flash::noErrors()) {
			throw new ValidationException();
		}

		$oType->setExtension($aDocumentTypeData['extension']);
		$oType->setMimetype($aDocumentTypeData['mimetype']);
		return $oType->save();
	}
}