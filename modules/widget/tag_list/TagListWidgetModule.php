<?php
/**
 * @package modules.widget
 */
class TagListWidgetModule extends WidgetModule {

	private $oListWidget;
	public $oDelegateProxy;
	
	public function __construct() {
		$this->oListWidget = new ListWidgetModule();
		$this->oDelegateProxy = new CriteriaListWidgetDelegate($this, "Tag", 'name');
		$this->oListWidget->setDelegate($this->oDelegateProxy);
	}

	public function doWidget() {
		$aTagAttributes = array('class' => 'tag_list');
		$oListTag = new TagWriter('table', $aTagAttributes);
		$this->oListWidget->setListTag($oListTag);
		return $this->oListWidget->doWidget();
	}

	public function getColumnIdentifiers() {
		return array('id', 'name', 'tag_instance_count', 'available_strings', 'delete');
	}

	public function getMetadataForColumn($sColumnIdentifier) {
		$aResult = array('is_sortable' => false);
		switch($sColumnIdentifier) {
			case 'id':
				$aResult['heading'] = false;
				$aResult['display_type'] = ListWidgetModule::DISPLAY_TYPE_DATA;
				break;
			case 'name':
				$aResult['heading'] = StringPeer::getString('wns.tag.name');
				$aResult['is_sortable'] = true;
				break;
			case 'tag_instance_count':
				$aResult['heading'] = StringPeer::getString('wns.tag.instance_count');
				break;
			case 'available_strings':
				$aResult['heading'] = StringPeer::getString('wns.tag.available_strings');
				break;
			case 'delete':
				$aResult['heading'] = ' ';
				$aResult['display_type'] = ListWidgetModule::DISPLAY_TYPE_ICON;
				$aResult['field_name'] = 'trash';
				break;
		}
		return $aResult;
	}
	
	public function getCriteria() {
		$aExcludes = array(CriteriaListWidgetDelegate::SELECT_ALL, 'Tag');
		$oQuery = TagQuery::create()->distinct();
		if(!in_array($this->oDelegateProxy->getModelName(), $aExcludes)) {
			$oQuery->joinTagInstance()->useQuery('TagInstance')->filterByModelName($this->oDelegateProxy->getModelName())->endUse();
		}
		return $oQuery;
	}
	
}