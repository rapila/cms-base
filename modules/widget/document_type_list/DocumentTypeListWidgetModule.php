<?php
/**
 * @package modules.widget
 */
class DocumentTypeListWidgetModule extends WidgetModule {

	private $oListWidget;
	private $sDocumentKind;
	public $oDelegateProxy;
	
	public function __construct() {
		$this->oListWidget = new ListWidgetModule();
		$this->oDelegateProxy = new CriteriaListWidgetDelegate($this, "DocumentType", 'extension');
		$this->oListWidget->setDelegate($this->oDelegateProxy);
	}
	
	public function doWidget() {
		$aTagAttributes = array('class' => 'document_type_list');
		$oListTag = new TagWriter('table', $aTagAttributes);
		$this->oListWidget->setListTag($oListTag);
		return $this->oListWidget->doWidget();
	}
	
	public function getColumnIdentifiers() {
		return array('id', 'extension', 'document_kind', 'mimetype', 'document_count', 'delete');
	}
	
	public function getMetadataForColumn($sColumnIdentifier) {
		$aResult = array('is_sortable' => true);
		switch($sColumnIdentifier) {
			case 'extension':
				$aResult['heading'] = StringPeer::getString('wns.extension');
				break;
			case 'document_kind':
				$aResult['heading'] = StringPeer::getString('wns.document_kind');
				break;			
			case 'mimetype':
				$aResult['heading'] = StringPeer::getString('wns.mimetype');
				break;
			case 'document_count':
				$aResult['heading'] = StringPeer::getString('wns.documents_count');
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