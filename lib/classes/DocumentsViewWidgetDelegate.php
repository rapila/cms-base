<?php
/**
 * @package modules.widget
 */
class DocumentsViewWidgetDelegate {

	public $oDelegateProxy;
	
	private $oDocumentKindFilter;
	private $oLanguageFilter;
	
	public function __construct() {
		$this->oDelegateProxy = new CriteriaListWidgetDelegate($this, "Document", "name", "asc");
		$this->oDocumentKindFilter = WidgetModule::getWidget('document_kind_input', null, true);
		$this->oLanguageFilter = WidgetModule::getWidget('language_input', null, true);
	}
	
	public function setDelegateProxy($oDelegateProxy) {
		$this->oDelegateProxy = $oDelegateProxy;
	}

	public function getDelegateProxy() {
		return $this->oDelegateProxy;
	}

	public function toggleIsInactive($aRowData) {
		$oDocument = DocumentPeer::retrieveByPK($aRowData['id']);
		if($oDocument) {
			$oDocument->setIsInactive(!$oDocument->getIsInactive());
			$oDocument->save();
		}
	}

	public function toggleIsProtected($aRowData) {
		$oDocument = DocumentPeer::retrieveByPK($aRowData['id']);
		if($oDocument) {
			$oDocument->setIsProtected(!$oDocument->getIsProtected());
			$oDocument->save();
		}
	}
	
	public function getColumnIdentifiers() {
		return array('id', 'name_truncated', 'sort', 'file_info', 'document_kind', 'category_name', 'language_id', 'is_protected', 'updated_at_formatted', 'delete');
	}
	
	public function getMetadataForColumn($sColumnIdentifier) {
		$aResult = array('is_sortable' => true);
		switch($sColumnIdentifier) {
			case 'name_truncated':
				$aResult['heading'] = StringPeer::getString('wns.name');
				break;
			case 'sort':
				$aResult['heading'] = StringPeer::getString('wns.sort');
				break;
			case 'file_info':
				$aResult['heading'] = StringPeer::getString('wns.document.file.info');
				break;
			case 'document_kind':
				$aResult['display_type'] = ListWidgetModule::DISPLAY_TYPE_ICON;
				$aResult['has_data'] = true;
				$aResult['heading'] = '';
				$aResult['heading_filter'] = array('document_kind_input', $this->oDocumentKindFilter->getSessionKey());
				$aResult['is_sortable'] = false;
				break;			
			case 'category_name':
				$aResult['heading'] = StringPeer::getString('wns.category');
				break;
			case 'language_id':
				// $aResult['heading'] = StringPeer::getString('wns.language');
				$aResult['has_data'] = true;
				$aResult['heading'] = '';
				$aResult['heading_filter'] = array('language_input', $this->oLanguageFilter->getSessionKey());
				$aResult['is_sortable'] = false;
				break;
			case 'is_protected':
				$aResult['heading'] = StringPeer::getString('wns.document.is_protected');
				$aResult['icon_false'] = 'radio-on';
				$aResult['icon_true'] = 'key';
				$aResult['has_function'] = true;
				break;
			case 'updated_at_formatted':
				$aResult['heading'] = StringPeer::getString('wns.updated_at');
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
	
	public function getDatabaseColumnForDisplayColumn($sDisplayColumn) {
		if($sDisplayColumn === 'category_name') {
			return DocumentPeer::DOCUMENT_CATEGORY_ID;
		}		
		if($sDisplayColumn === 'name_truncated') {
			return DocumentPeer::NAME;
		}
		if($sDisplayColumn === 'file_info') {
			return "OCTET_LENGTH(DATA)";
		}
		if($sDisplayColumn === 'updated_at_formatted') {
			return DocumentPeer::UPDATED_AT;
		}		
		if($sDisplayColumn === 'document_kind') {
			return DocumentTypePeer::MIMETYPE;
		}
		return null;
	}
	
	public function getFilterTypeForColumn($sColumnName) {
		if($sColumnName === 'document_kind') {
			return CriteriaListWidgetDelegate::FILTER_TYPE_BEGINS;
		}
		if($sColumnName === 'language_id') {
			return CriteriaListWidgetDelegate::FILTER_TYPE_IS;
		}
		if($sColumnName === 'document_category_id') {
			return CriteriaListWidgetDelegate::FILTER_TYPE_IS;
		}
		return null;
	}
	
	public function getCriteria() {
		$oCriteria = new Criteria();
		// addJoin to Document Types for sort speed, sort order and filter
		$oCriteria->addJoin(DocumentPeer::DOCUMENT_TYPE_ID, DocumentTypePeer::ID, Criteria::LEFT_JOIN);
		// Speed only
		$oCriteria->addJoin(DocumentPeer::DOCUMENT_CATEGORY_ID, DocumentCategoryPeer::ID, Criteria::LEFT_JOIN);
		return $oCriteria;
	}
	
	public function setDocumentKind($sDocumentKind) {
		return $this->oDelegateProxy->setDocumentKind($sDocumentKind);
	}

	public function getDocumentKind() {
		return $this->oDelegateProxy->getDocumentKind();
	}
	
	public function setDocumentCategoryId($iDocumentCategoryId) {
		return $this->oDelegateProxy->setDocumentCategoryId($iDocumentCategoryId);
	}

	public function getDocumentCategoryId() {
		return $this->oDelegateProxy->getDocumentCategoryId();
	}
	
	public function getDocumentCategoryName() {
		$oDocumentCategory = DocumentCategoryPeer::retrieveByPK($this->getDocumentCategoryId());
		if($oDocumentCategory) {
			return $oDocumentCategory->getName();
		}
		if($this->getDocumentCategoryId() === CriteriaListWidgetDelegate::SELECT_WITHOUT) {
			return StringPeer::getString('wns.documents.without_category');
		}
		return $this->getDocumentCategoryId();
	}
	
	public function getDocumentKindName() {
		if($this->getDocumentKind() === CriteriaListWidgetDelegate::SELECT_ALL) {
			return $this->getDocumentKind();
		}
		return DocumentTypePeer::getDocumentKindName($this->getDocumentKind());
	}

	public function setSearch($sSearch) {
		return $this->oDelegateProxy->setSearch($sSearch);
	}

	public function getSearch() {
		return $this->oDelegateProxy->getSearch();
	}
}