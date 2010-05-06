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
	
	public function saveData($aDocumentTypeData) {
		if($this->iTypeId === null) {
			$oType = new DocumentType();
		} else {
			$oType = DocumentTypePeer::retrieveByPK($this->iTypeId);
		}
		$oType->setExtension($aDocumentTypeData['extension']);
		$oType->setMimetype($aDocumentTypeData['mimetype']);
		$oType->setIsOfficeDoc(isset($aDocumentTypeData['is_office_doc']));
		return $oType->save();
	}
}