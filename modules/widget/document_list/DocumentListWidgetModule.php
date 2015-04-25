<?php
/**
 * @package modules.widget
 */
class DocumentListWidgetModule extends SpecializedListWidgetModule {

	public $oDelegateProxy;
	public $oDocumentKindFilter;
	public $oLanguageFilter;
	public $oTagFilter;

	protected function createListWidget() {
		$oListWidget = new ListWidgetModule();
		$this->oDelegateProxy = new CriteriaListWidgetDelegate($this, "Document", "name_truncated", "asc");
		$oListWidget->setDelegate($this->oDelegateProxy);
		$oListWidget->setSetting('row_model_drag_and_drop_identifier', 'id');
		$this->oDocumentKindFilter = WidgetModule::getWidget('document_kind_input', null, true);
		$this->oDocumentKindFilter->setSetting('with_documents_only', false);
		if(!LanguageInputWidgetModule::isMonolingual()) {
			$this->oLanguageFilter = WidgetModule::getWidget('language_input', null, true);
		}
		$this->oTagFilter = WidgetModule::getWidget('tag_input', null, true);
		$this->oTagFilter->setSetting('model_name', 'Document');
		return $oListWidget;
	}

	public function getColumnIdentifiers() {
		$aResult = array('id', 'name_truncated', 'has_description', 'document_kind', 'extension', 'file_size');
		if($this->oLanguageFilter !== null) {
			$aResult[] = 'language_id';
		}
		if(self::hasTags()) {
			$aResult[] = 'has_tags';
		}
		return array_merge($aResult, array('is_protected', 'sort', 'updated_at_formatted', 'delete'));
	}

	public function getMetadataForColumn($sColumnIdentifier) {
		$aResult = array('is_sortable' => true);
		switch($sColumnIdentifier) {
			case 'name_truncated':
				$aResult['heading'] = StringPeer::getString('wns.name');
				$aResult['display_type'] = ListWidgetModule::DISPLAY_TYPE_TEXT;
				break;
			case 'has_description':
				$aResult['heading'] = StringPeer::getString('wns.document.has_description');
				$aResult['is_sortable'] = false;
				break;
			case 'sort':
				$aResult['heading'] = StringPeer::getString('wns.sort');
				$aResult['display_type'] = ListWidgetModule::DISPLAY_TYPE_REORDERABLE;
				break;
			case 'file_size':
				$aResult['heading'] = StringPeer::getString('wns.document.file.size');
				$aResult['display_type'] = ListWidgetModule::DISPLAY_TYPE_NUMERIC;
				break;
			case 'extension':
				$aResult['heading'] = StringPeer::getString('wns.document.file.info');
				break;
			case 'document_kind':
				$aResult['heading'] = '';
				$aResult['heading_filter'] = array('document_kind_input', $this->oDocumentKindFilter->getSessionKey());
				$aResult['display_type'] = ListWidgetModule::DISPLAY_TYPE_HTML;
				$aResult['field_name'] = 'preview_for_admin_list';
				$aResult['is_sortable'] = false;
				break;
			case 'language_id':
				$aResult['heading'] = '';
				$aResult['heading_filter'] = array('language_input', $this->oLanguageFilter->getSessionKey());
				$aResult['is_sortable'] = false;
				break;
			case 'has_tags':
				$aResult['heading'] = '';
				$aResult['heading_filter'] = array('tag_input', $this->oTagFilter->getSessionKey());
				$aResult['is_sortable'] = false;
				break;
			case 'is_protected':
				$aResult['heading'] = StringPeer::getString('wns.document.is_protected');
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

	public function getDatabaseColumnForColumn($sColumnIdentifier) {
		if($sColumnIdentifier === 'name_truncated') {
			return DocumentPeer::NAME;
		}
		if($sColumnIdentifier === 'file_size') {
			return DocumentDataPeer::DATA_SIZE;
		}
		if($sColumnIdentifier === 'extension') {
			return DocumentTypePeer::EXTENSION;
		}
		if($sColumnIdentifier === 'updated_at_formatted') {
			return DocumentPeer::UPDATED_AT;
		}
		if($sColumnIdentifier === 'document_kind') {
			return DocumentTypePeer::MIMETYPE;
		}
		return null;
	}

	public function getFilterTypeForColumn($sColumnIdentifier) {
		if($sColumnIdentifier === 'document_kind') {
			return CriteriaListWidgetDelegate::FILTER_TYPE_BEGINS;
		}
		if($sColumnIdentifier === 'language_id') {
			return CriteriaListWidgetDelegate::FILTER_TYPE_IS;
		}
		if($sColumnIdentifier === 'document_category_id') {
			return CriteriaListWidgetDelegate::FILTER_TYPE_IS;
		}
		if($sColumnIdentifier === 'has_tags') {
			return CriteriaListWidgetDelegate::FILTER_TYPE_MANUAL;
		}
		return null;
	}

	private static function hasTags() {
		return TagInstanceQuery::create()->filterByModelName('Document')->count() > 0;
	}

	public function allowSort($sSortColumn) {
		$aListSettings = $this->oDelegateProxy->getListSettings();
		if(!is_numeric($this->getDocumentCategoryId())) {
			return false;
		}
		// make sure that no filters are active except for sidebar category
		foreach($aListSettings->allFilterColumns() as $sColumnIdentifier) {
			if($sColumnIdentifier === 'document_category_id') {
				continue;
			}
			if($aListSettings->getFilterColumnValue($sColumnIdentifier) !== CriteriaListWidgetDelegate::SELECT_ALL) {
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

	public function toggleIsProtected($aRowData) {
		$oDocument = DocumentQuery::create()->findPk($aRowData['id']);
		if($oDocument) {
			$oDocument->setIsProtected(!$oDocument->getIsProtected());
			$oDocument->save();
		}
	}

	public function getDocumentKindName() {
		if($this->getDocumentKind() !== CriteriaListWidgetDelegate::SELECT_ALL) {
			return $this->getDocumentKind();
		}
		return DocumentKindInputWidgetModule::getDocumentKindName($this->getDocumentKind());
	}

	public function getDocumentCategoryId() {
		return $this->oDelegateProxy->getDocumentCategoryId();
	}

	public function setDocumentCategoryId($iDocumentCategoryId = null) {
		return $this->oDelegateProxy->setDocumentCategoryId($iDocumentCategoryId);
	}

	public function setDocumentKind($sDocumentKind) {
		return $this->oDelegateProxy->setDocumentKind($sDocumentKind);
	}

	public function getDocumentKind() {
		return $this->oDelegateProxy->getDocumentKind();
	}

	public function getLanguageName() {
		return StringPeer::getString('language.'.$this->oDelegateProxy->getLanguageId(), null, $this->oDelegateProxy->getLanguageId());
	}

	public function getDocumentCategoryName() {
		$oDocumentCategory = DocumentCategoryQuery::create()->findPk($this->oDelegateProxy->getDocumentCategoryId());
		if($oDocumentCategory) {
			return $oDocumentCategory->getName();
		}
		if($this->oDelegateProxy->getDocumentCategoryId() === CriteriaListWidgetDelegate::SELECT_WITHOUT) {
			return StringPeer::getString('wns.documents.without_category');
		}
		return $this->oDelegateProxy->getDocumentCategoryId();
	}

	public function getTagName() {
		if($iTagId = $this->oDelegateProxy->getListSettings()->getFilterColumnValue('has_tags')) {
			return TagQuery::create()->filterById($iTagId)->select('Name')->findOne();
		}
		return null;
	}

	public function getCategoryHasDocuments($iDocumentCategoryId) {
		return DocumentQuery::create()->filterByDocumentCategoryId($iDocumentCategoryId)->count() > 0;
	}

	public function getCriteria() {
		$oQuery = DocumentQuery::create()->joinDocumentType(null, Criteria::LEFT_JOIN)->joinDocumentData();
		if(!Session::getSession()->getUser()->getIsAdmin() || Settings::getSetting('admin', 'hide_externally_managed_document_categories', true)) {
			$oQuery->excludeExternallyManaged();
		}
		if($this->oTagFilter && $this->oDelegateProxy->getListSettings()->getFilterColumnValue('has_tags') !== CriteriaListWidgetDelegate::SELECT_ALL) {
			$oQuery->filterByTagId($this->oDelegateProxy->getListSettings()->getFilterColumnValue('has_tags'));
		}
		return $oQuery;
	}

}
