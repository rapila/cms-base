<?php
/**
 * @package modules.widget
 */
class DocumentTypeListWidgetModule extends WidgetModule {

	private $oListWidget;
	private $sDocumentKind;
	
	public function __construct() {
		$this->oListWidget = new ListWidgetModule();
		$oDelegateProxy = new CriteriaListWidgetDelegate($this, "DocumentType", 'extension');
		$this->oListWidget->setDelegate($oDelegateProxy);
	}
	
	public function doWidget() {
		$aTagAttributes = array('class' => 'document_type_list');
		$oListTag = new TagWriter('table', $aTagAttributes);
		$this->oListWidget->setListTag($oListTag);
		return $this->oListWidget->doWidget();
	}
	
	public function setDocumentKind($sDocumentKind = null) {
		$this->sDocumentKind = $sDocumentKind;
	}
	
	public function getColumnIdentifiers() {
		return array('id', 'extension', 'document_kind', 'mimetype', 'is_office_doc', 'document_count', 'delete');
	}
	
	public function getMetadataForColumn($sColumnIdentifier) {
		$aResult = array('is_sortable' => true);
		switch($sColumnIdentifier) {
			case 'extension':
				$aResult['heading'] = StringPeer::getString('extension');
				break;
			case 'document_kind':
				$aResult['heading'] = StringPeer::getString('document_kind');
				break;			
			case 'mimetype':
				$aResult['heading'] = StringPeer::getString('mimetype');
				break;
			case 'is_office_doc':
				$aResult['heading'] = StringPeer::getString('is_office_doc');
				break;
			case 'document_count':
				$aResult['heading'] = StringPeer::getString('document.count');
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

	public function getSortColumnForDisplayColumn($sDisplayColumn) {
		if($sDisplayColumn === 'document_kind') {
			return DocumentTypePeer::MIMETYPE;
		}
		return null;
	}
	
	public function getCriteria() {
		$oCriteria = new Criteria();
		if($this->sDocumentKind) {
			$oCriteria->add(DocumentTypePeer::MIMETYPE, $this->sDocumentKind.'/%', Criteria::LIKE);
		}
		return $oCriteria;
	}
}