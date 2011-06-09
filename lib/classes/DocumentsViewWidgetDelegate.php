<?php
/**
 * @package modules.widget
 */
class DocumentsViewWidgetDelegate {

	public $oDelegateProxy;
	
	private $oDocumentKindFilter;
	private $oLanguageFilter;
	
	public function __construct() {
		$this->oDelegateProxy = new CriteriaListWidgetDelegate($this, "Document", "name_truncated", "asc");
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
				$aResult['display_type'] = ListWidgetModule::DISPLAY_TYPE_REORDERABLE;
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
	
	public function allowSort($sSortColumn) {
		$aListSettings = $this->oDelegateProxy->getListSettings();
		if($aListSettings->getFilterColumnValue('document_category_id') === CriteriaListWidgetDelegate::SELECT_ALL || $aListSettings->getFilterColumnValue('document_category_id') === CriteriaListWidgetDelegate::SELECT_WITHOUT) {
			return false;
		}
		foreach($aListSettings->allFilterColumns() as $sColumnName) {
			if($sColumnName === 'document_category_id') {
				continue;
			}
			if($aListSettings->getFilterColumnValue($sColumnName) !== CriteriaListWidgetDelegate::SELECT_ALL) {
				return false;
			}
		}
		return true;
	}
	
	public function doSort($sColumnIdentifier, $oDocumentToSort, $oRelatedDocument, $sPosition = 'before') {
		$iNewPosition = $oRelatedDocument->getSort() + ($sPosition === 'before' ? 0 : 1);
		if($oDocumentToSort->getSort() < $oRelatedDocument->getSort()) {
			$iNewPosition--;
		}
		$oDocumentToSort->setSort($iNewPosition);
		$oDocumentToSort->save();
		$oQuery = $this->oDelegateProxy->getCriteria();
		$oQuery->filterById($oDocumentToSort->getId(), Criteria::NOT_EQUAL);
		$oQuery->orderBySort();
		$i = 1;
		foreach($oQuery->find() as $oDocument) {
			if($i == $iNewPosition) {
				$i++;
			}
			$oDocument->setSort($i);
			$oDocument->save();
			$i++;
		}
	}
	
	public function getCriteria() {
		return DocumentQuery::create()->joinDocumentType(null, Criteria::LEFT_JOIN)->excludeExternallyManaged();
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