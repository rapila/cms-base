<?php
/**
 * @package modules.widget
 */
class LinkCategoryListWidgetModule extends SpecializedListWidgetModule {

	private $oDelegateProxy;
	private $oExternallyManagedInputFilter;
	private $bExcludeExternallyManaged;

	protected function createListWidget() {
		$oListWidget = new ListWidgetModule();
		$this->oDelegateProxy = new CriteriaListWidgetDelegate($this, "LinkCategory", 'name');
		$oListWidget->setDelegate($this->oDelegateProxy);
		$this->oExternallyManagedInputFilter = WidgetModule::getWidget('externally_managed_input', true);
		$this->oDelegateProxy->setInternallyManagedOnly(true);
		return $oListWidget;
	}

	public function getColumnIdentifiers() {
		return array('id', 'name', 'link_to_link_data', 'is_externally_managed', 'delete');
	}

	public function getMetadataForColumn($sColumnIdentifier) {
		$aResult = array();
		switch($sColumnIdentifier) {
			case 'name':
				$aResult['heading'] = TranslationPeer::getString('wns.name');
				$aResult['is_sortable'] = true;
				break;
			case 'link_to_link_data':
				$aResult['heading'] = TranslationPeer::getString('wns.links_count');
				$aResult['display_type'] = ListWidgetModule::DISPLAY_TYPE_URL;
				break;
			case 'is_externally_managed':
        $aResult['heading'] = TranslationPeer::getString('wns.internally_managed_only');
				$aResult['heading_filter'] = array('externally_managed_input', $this->oExternallyManagedInputFilter->getSessionKey());
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
		$oQuery = LinkCategoryQuery::create()->distinct();
		if($this->bExcludeExternallyManaged) {
			$oQuery->filterByIsExternallyManaged(false);
		}
		return $oQuery;
	}

}