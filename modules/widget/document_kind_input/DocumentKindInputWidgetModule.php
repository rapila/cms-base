<?php
/**
 * @package modules.widget
 */
class DocumentKindInputWidgetModule extends PersistentWidgetModule {

	private $sSelectedDocumentKind = null;
		
	public function getDocumentKinds() {
		return DocumentTypePeer::getAllDocumentKindsWhereDocumentsExist();
	}
	
	public function setSelectedDocumentKind($sSelectedDocumentKind) {
		if($sSelectedDocumentKind === '') {
			$sSelectedDocumentKind = null;
		}
		$this->sSelectedDocumentKind = $sSelectedDocumentKind;
	}
	
	public function getElementType() {
		return 'select';
	}

	public function getSelectedDocumentKind() {
		return $this->sSelectedDocumentKind;
	}
}