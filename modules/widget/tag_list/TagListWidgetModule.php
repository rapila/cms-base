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
		return array('id', 'name', 'tag_instance_count', 'delete');
	}
	
	public function getMetadataForColumn($sColumnIdentifier) {
		$aResult = array('is_sortable' => false);
		switch($sColumnIdentifier) {
			case 'id':
				$aResult['heading'] = false;
				$aResult['display_type'] = ListWidgetModule::DISPLAY_TYPE_DATA;
				break;
			case 'name':
				$aResult['heading'] = StringPeer::getString('widget.tag.name');
				$aResult['is_sortable'] = true;
				break;
			case 'tag_instance_count':
				$aResult['heading'] = StringPeer::getString('widget.tag.instance_count');
				break;
			case 'delete':
				$aResult['heading'] = ' ';
				$aResult['display_type'] = ListWidgetModule::DISPLAY_TYPE_ICON;
				$aResult['field_name'] = 'trash';
				break;
		}
		return $aResult;
	}

	public function getDatabaseColumnForDisplayColumn($sDisplayColumn) {
		if($sDisplayColumn === 'model_name') {
			return TagInstancePeer::MODEL_NAME;
		}
		return null;
	}

	public function getFilterTypeForColumn($sColumnName) {
		if($sColumnName === 'model_name') {
			return CriteriaListWidgetDelegate::FILTER_TYPE_IS;
		}
		return null;
	}

	public function getCriteria() {
		$oCriteria = new Criteria();
		return $oCriteria->addJoin(TagPeer::ID, TagInstancePeer::TAG_ID);
	}
}