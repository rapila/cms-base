<?php
/**
 * @package modules.widget
 */
class DocumentTypeListWidgetModule extends SpecializedListWidgetModule {

	public $oDelegateProxy;
	private $sDocumentKind;

	protected function createListWidget() {
		$oListWidget = new ListWidgetModule();
		$this->oDelegateProxy = new CriteriaListWidgetDelegate($this, "DocumentType", 'extension');
		$oListWidget->setDelegate($this->oDelegateProxy);
		return $oListWidget;
	}

	public function getColumnIdentifiers() {
		return array('id', 'extension', 'document_kind', 'mimetype', 'document_count', 'delete');
	}

	public function getMetadataForColumn($sColumnIdentifier) {
		$aResult = array('is_sortable' => true);
		switch($sColumnIdentifier) {
			case 'extension':
				$aResult['heading'] = TranslationPeer::getString('wns.extension');
				break;
			case 'document_kind':
				$aResult['heading'] = TranslationPeer::getString('wns.document_kind');
				break;
			case 'mimetype':
				$aResult['heading'] = TranslationPeer::getString('wns.mimetype');
				break;
			case 'document_count':
				$aResult['heading'] = TranslationPeer::getString('wns.documents_count');
				$aResult['is_sortable'] = false;
				break;
			case 'delete':
				$aResult['heading'] = ' ';
				$aResult['display_type'] = ListWidgetModule::DISPLAY_TYPE_ICON;
				$aResult['field_name'] = 'trash';
				$aResult['is_sortable'] = false;
				break;
		}
		return $aResult;
	}

	public function getDatabaseColumnForColumn($sColumnIdentifier) {
		if($sColumnIdentifier === 'document_kind') {
			return DocumentTypePeer::MIMETYPE;
		}
		return null;
	}

	public function getFilterTypeForColumn($sColumnIdentifier) {
		if($sColumnIdentifier === 'document_kind') {
			return CriteriaListWidgetDelegate::FILTER_TYPE_BEGINS;
		}
		return null;
	}

	public function getDocumentKindName() {
		if($this->oDelegateProxy->getDocumentKind() !== CriteriaListWidgetDelegate::SELECT_WITHOUT) {
			return DocumentKindInputWidgetModule::getDocumentKindName($this->oDelegateProxy->getDocumentKind());
		}
		return $this->oDelegateProxy->getDocumentKind();
	}

	public function getCriteria() {
		$oQuery = DocumentTypeQuery::create();
		if($this->oDelegateProxy->getDocumentKind() !== CriteriaListWidgetDelegate::SELECT_ALL) {
			$oQuery->filterByMimetype($this->oDelegateProxy->getDocumentKind().'/%', Criteria::LIKE);
		}
		return $oQuery;
	}
}