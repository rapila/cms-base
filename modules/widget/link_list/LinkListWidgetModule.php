<?php
/**
 * @package modules.widget
 */
class LinkListWidgetModule extends WidgetModule {

	private $oListWidget;
	private $iLinkCategoryId;
	public $oDelegateProxy;
	
	public function __construct() {
		$this->oListWidget = new ListWidgetModule();
		$this->oDelegateProxy = new CriteriaListWidgetDelegate($this, "Link", "name", "asc");
		$this->oListWidget->setDelegate($this->oDelegateProxy);
	}
	
	public function doWidget() {
		$aTagAttributes = array('class' => 'link_list');
		$oListTag = new TagWriter('table', $aTagAttributes);
		$this->oListWidget->setListTag($oListTag);
		return $this->oListWidget->doWidget();
	}
	
	public function toggleIsInactive($aRowData) {
		$oLink = LinkPeer::retrieveByPK($aRowData['id']);
		if($oLink) {
			$oLink->setIsInactive(!$oLink->getIsInactive());
			$oLink->save();
		}
	}
	
	public function getColumnIdentifiers() {
		return array('id', 'name', 'url', 'description', 'category_name', 'updated_at_formatted', 'delete');
	}
	
	public function getMetadataForColumn($sColumnIdentifier) {
		$aResult = array('is_sortable' => true);
		switch($sColumnIdentifier) {
			case 'name':
				$aResult['heading'] = StringPeer::getString('name');
				break;
			case 'url':
				$aResult['heading'] = StringPeer::getString('url');
				$aResult['display_type'] = ListWidgetModule::DISPLAY_TYPE_URL;
				break;
			case 'description':
				$aResult['heading'] = StringPeer::getString('description');
				break;
			case 'category_name':
				$aResult['heading'] = StringPeer::getString('widget.link_category_list');
				break;
			case 'updated_at_formatted':
				$aResult['heading'] = StringPeer::getString('updated_at');
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

	public function getFilterTypeForColumn($sColumnName) {
		if($sColumnName === 'link_category_id') {
			return CriteriaListWidgetDelegate::FILTER_TYPE_IS;
		}
		return null;
	}

	
	public function getDatabaseColumnForDisplayColumn($sDisplayColumn) {
		if($sDisplayColumn === 'category_name') {
			return LinkPeer::LINK_CATEGORY_ID;
		}
		if($sDisplayColumn === 'updated_at_formatted') {
			return LinkPeer::UPDATED_AT;
		}
		return null;
	}

	public function getCriteria() {
		$oCriteria = new Criteria();
		if($this->iLinkCategoryId && $this->iLinkCategoryId !== CriteriaListWidgetDelegate::SELECT_ALL) {
			$oCriteria->add(LinkPeer::LINK_CATEGORY_ID, $this->iLinkCategoryId);
		}
		return $oCriteria;
	}
}