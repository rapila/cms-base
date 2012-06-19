<?php
/**
 * @package modules.widget
 */
class LinkCategoryListWidgetModule extends PersistentWidgetModule {

	private $oListWidget;
	private $oDelegateProxy;
	private $oExternallyManagedInputFilter;
	private $bExcludeExternallyManaged;
	
	public function __construct($sSessionKey = null) {
		parent::__construct($sSessionKey);
		$this->oListWidget = new ListWidgetModule();
		$this->oDelegateProxy = new CriteriaListWidgetDelegate($this, "LinkCategory", 'name');
		$this->oListWidget->setDelegate($this->oDelegateProxy);
		$this->oExternallyManagedInputFilter = WidgetModule::getWidget('externally_managed_input', null, true);
		$this->oDelegateProxy->setInternallyManagedOnly(true);
	}

	public function doWidget() {
		$aTagAttributes = array('class' => 'link_category_list');
		$oListTag = new TagWriter('table', $aTagAttributes);
		$this->oListWidget->setListTag($oListTag);
		return $this->oListWidget->doWidget();
	}

	public function toggleIsInactive($aRowData) {
		$oLinkCategory = LinkCategoryQuery::create()->findPk($aRowData['id']);
		if($oLinkCategory) {
			$oLinkCategory->setIsInactive(!$oLinkCategory->getIsInactive());
			$oLinkCategory->save();
		}
	}

	public function getColumnIdentifiers() {
		return array('id', 'name', 'link_to_link_data', 'is_externally_managed', 'delete');
	}

	public function getMetadataForColumn($sColumnIdentifier) {
		$aResult = array();
		switch($sColumnIdentifier) {
			case 'name':
				$aResult['heading'] = StringPeer::getString('wns.name');
				$aResult['is_sortable'] = true;
				break;
			case 'link_to_link_data':
				$aResult['heading'] = StringPeer::getString('wns.links_count');
				$aResult['display_type'] = ListWidgetModule::DISPLAY_TYPE_URL;
				break;
			case 'is_externally_managed':
        $aResult['heading'] = StringPeer::getString('wns.internally_managed_only');
				$aResult['heading_filter'] = array('externally_managed_input', $this->oExternallyManagedInputFilter->getSessionKey());
				$aResult['is_sortable'] = true;
				break;
			case 'delete':
				$aResult['heading'] = ' ';
				$aResult['display_type'] = ListWidgetModule::DISPLAY_TYPE_ICON;
				$aResult['field_name'] = 'trash';
				break;
		}
		return $aResult;
	}

	public function setIsExternallyManaged($bIsExternallyManaged) {
		$this->oDelegateProxy->setInternallyManagedOnly($bIsExternallyManaged);
	}
	
	public function setInternallyManagedOnly($bExcludeExternallyManaged) {
	  $this->bExcludeExternallyManaged = $bExcludeExternallyManaged;
	}
	
	public function getCriteria() {
		$oCriteria = LinkCategoryQuery::create()->distinct();
		if($this->bExcludeExternallyManaged) {
			$oCriteria->filterByIsExternallyManaged(false);
		}
		return $oCriteria;
	}
}