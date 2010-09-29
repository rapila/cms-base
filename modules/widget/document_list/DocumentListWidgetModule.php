<?php
/**
 * @package modules.widget
 */
class DocumentListWidgetModule extends PersistentWidgetModule {

	private $oListWidget;
	public $oDelegateProxy;
	private $iDocumentCategoryId;
	private $oDocumentKindFilter;
	
	public function __construct() {
		parent::__construct();
		$this->oListWidget = new ListWidgetModule();
		$this->oDelegateProxy = new CriteriaListWidgetDelegate($this, "Document", "name", "asc");
		$this->oListWidget->setDelegate($this->oDelegateProxy);
		$this->iDocumentCategoryId = null;
		$this->oDocumentKindFilter = WidgetModule::getWidget('document_kind_input', null, true);
	}

	public function doWidget() {
		return parent::doWidget();
	}
	
	public function getElementType() {
		$aTagAttributes = array('class' => 'document_list');
		$oListTag = new TagWriter('table', $aTagAttributes);
		$this->oListWidget->setListTag($oListTag);
		return new TagWriter('div', array(), $this->oListWidget->doWidget());
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
		return array('id', 'name', 'sort', 'file_info', 'document_kind', 'category_name', 'language_id', 'is_protected', 'updated_at_formatted', 'edit', 'delete');
	}
	
	public function getMetadataForColumn($sColumnIdentifier) {
		$aResult = array('is_sortable' => true);
		switch($sColumnIdentifier) {
			case 'name':
				$aResult['heading'] = StringPeer::getString('name');
				break;
			case 'sort':
				$aResult['heading'] = StringPeer::getString('widget.sort');
				break;
			case 'file_info':
				$aResult['heading'] = StringPeer::getString('file.info');
				break;
			case 'document_kind':
				$aResult['display_type'] = ListWidgetModule::DISPLAY_TYPE_ICON;
				$aResult['has_data'] = true;
				$aResult['heading'] = '';
				$aResult['heading_filter'] = array('document_kind_input', $this->oDocumentKindFilter->getSessionKey());
				$aResult['is_sortable'] = false;
				break;			
			case 'category_name':
				$aResult['heading'] = StringPeer::getString('label_list.file_category_list');
				break;
			case 'language_id':
				$aResult['heading'] = StringPeer::getString('widget.language');
				break;
			case 'is_protected':
				$aResult['heading'] = StringPeer::getString('widget.document.is_protected');
				$aResult['icon_false'] = 'radio-on';
				$aResult['icon_true'] = 'key';
        $aResult['has_function'] = true;
				break;
			case 'updated_at_formatted':
				$aResult['heading'] = StringPeer::getString('widget.updated_at');
				break;
			case 'edit':
				$aResult['heading'] = ' ';
				$aResult['display_type'] = ListWidgetModule::DISPLAY_TYPE_ICON;
				$aResult['field_name'] = 'pencil';
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
	
	public function getDatabaseColumnForDisplayColumn($sDisplayColumn) {
		if($sDisplayColumn === 'category_name') {
			return DocumentPeer::DOCUMENT_CATEGORY_ID;
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
		if($sColumnName === 'document_category_id') {
			return CriteriaListWidgetDelegate::FILTER_TYPE_IS;
		}
		return null;
	}
	
	public function setOption($sName, $mValue) {
		if($this->oListWidget->getOption($sName) == $mValue) {
			return false;
		}
		$this->oListWidget->setOption($sName, $mValue);
		return true;
	}
	
	public function getCriteria() {
		$oCriteria = new Criteria();
		// addJoin to Document Types for sort speed, sort order and filter
		$oCriteria->addJoin(DocumentPeer::DOCUMENT_TYPE_ID, DocumentTypePeer::ID, Criteria::LEFT_JOIN);
		// Speed only
		$oCriteria->addJoin(DocumentPeer::DOCUMENT_CATEGORY_ID, DocumentCategoryPeer::ID, Criteria::LEFT_JOIN);
		return $oCriteria;
	}
}