<?php
/**
 * @package modules.widget
 */
class DocumentKindInputWidgetModule extends PersistentWidgetModule {

	private $sSelectedDocumentKind = null;

	public function getDocumentKinds($bWithDocumentsOnly = false) {
		return self::getDocumentKindsAssoc($bWithDocumentsOnly);
	}

	public static function getDocumentKindsAssoc($bWithDocumentsOnly = false) {
		$aResult = array();
		$oQuery = DocumentTypeQuery::create();
		if($bWithDocumentsOnly) {
			$oQuery->joinDocument();
		}
		foreach($oQuery->find() as $oDocumentType) {
			$aKind = explode('/', $oDocumentType->getMimeType());
			$aResult[$aKind[0]] = self::getDocumentKindName($aKind[0]);
		}
		asort($aResult);
		return $aResult;
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
		if($this->sSelectedDocumentKind === null) {
			return CriteriaListWidgetDelegate::SELECT_ALL;
		}
		return $this->sSelectedDocumentKind;
	}

	public static function getDocumentKindName($sKey) {
		return TranslationPeer::getString('wns.document_kind.'.$sKey);
	}
	
}