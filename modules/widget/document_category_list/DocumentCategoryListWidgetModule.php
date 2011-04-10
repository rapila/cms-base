<?php
/**
 * @package modules.widget
 */
class DocumentCategoryListWidgetModule extends PersistentWidgetModule {

	private $oListWidget;
	private $oDelegateProxy;
	private $oDocumentCategoryManagedInputFilter;
	private $bInternallyManagedOnly;
	
	public function __construct($sSessionKey = null) {
		parent::__construct($sSessionKey);
		$this->oListWidget = new ListWidgetModule();
		$this->oDelegateProxy = new CriteriaListWidgetDelegate($this, "DocumentCategory", 'name');
		$this->oListWidget->setDelegate($this->oDelegateProxy);
		$this->oDocumentCategoryManagedInputFilter = WidgetModule::getWidget('document_category_managed_input', null, true);
		$this->oDelegateProxy->setInternallyManagedOnly(true);
	}
	
	public function setIsExternallyManaged($bIsExternallyManaged) {
		$this->oDelegateProxy->setInternallyManagedOnly($bIsExternallyManaged);
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
				$aResult['heading'] = StringPeer::getString('wns.name');
				$aResult['is_sortable'] = true;
				break;
			case 'settings':
				$aResult['heading'] = StringPeer::getString('wns.document_category.settings');
				break;
			case 'link_to_document_data':
				$aResult['heading'] = StringPeer::getString('wns.documents_count');
				$aResult['display_type'] = ListWidgetModule::DISPLAY_TYPE_URL;
				break;
			case 'is_externally_managed':
        $aResult['heading'] = StringPeer::getString('wns.internally_managed_only');
				$aResult['heading_filter'] = array('document_category_managed_input', $this->oDocumentCategoryManagedInputFilter->getSessionKey());
				$aResult['is_sortable'] = false;
				break;
			case 'delete':
				$aResult['heading'] = ' ';
				$aResult['display_type'] = ListWidgetModule::DISPLAY_TYPE_ICON;
				$aResult['field_name'] = 'trash';
				break;
		}
		return $aResult;
	}
	
	public function setInternallyManagedOnly($bInternallyManagedOnly) {
	  $this->bInternallyManagedOnly = $bInternallyManagedOnly;
	}
	
	public function getCriteria() {
		$oCriteria = DocumentCategoryQuery::create();
		if($this->bInternallyManagedOnly) {
			$oCriteria->filterByIsExternallyManaged(false);
		}
		return $oCriteria;
	}
}