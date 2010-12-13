<?php
/**
 * @package modules.widget
 */
class DocumentCategoryListWidgetModule extends PersistentWidgetModule {

	private $oListWidget;
	
	public function __construct($sSessionKey = null) {
		parent::__construct($sSessionKey);
		$this->oListWidget = new ListWidgetModule();
		$oDelegateProxy = new CriteriaListWidgetDelegate($this, "DocumentCategory", 'name');
		$this->oListWidget->setDelegate($oDelegateProxy);
	}

	public function doWidget() {
		$aTagAttributes = array('class' => 'document_category_list');
		$oListTag = new TagWriter('table', $aTagAttributes);
		$this->oListWidget->setListTag($oListTag);
		return $this->oListWidget->doWidget();
	}

	public function toggleIsInactive($aRowData) {
		$oDocumentCategory = DocumentCategoryPeer::retrieveByPK($aRowData['id']);
		if($oDocumentCategory) {
			$oDocumentCategory->setIsInactive(!$oDocumentCategory->getIsInactive());
			$oDocumentCategory->save();
		}
	}

	public function getColumnIdentifiers() {
		return array('id', 'name', 'link_to_document_data', 'settings', 'is_externally_managed', 'delete');
	}

	public function getMetadataForColumn($sColumnIdentifier) {
		$aResult = array();
		switch($sColumnIdentifier) {
			case 'name':
				$aResult['heading'] = StringPeer::getString('widget.name');
				$aResult['is_sortable'] = true;
				break;
			case 'settings':
				$aResult['heading'] = StringPeer::getString('widget.document_category.settings');
				break;
			case 'link_to_document_data':
				$aResult['heading'] = StringPeer::getString('widget.documents_count');
				$aResult['display_type'] = ListWidgetModule::DISPLAY_TYPE_URL;
				break;
			case 'is_externally_managed':
				$aResult['is_sortable'] = true;
				$aResult['heading'] = StringPeer::getString('widget.is_externally_managed');
				break;
			case 'delete':
				$aResult['heading'] = ' ';
				$aResult['display_type'] = ListWidgetModule::DISPLAY_TYPE_ICON;
				$aResult['field_name'] = 'trash';
				break;
		}
		return $aResult;
	}
}