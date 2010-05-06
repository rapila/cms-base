<?php
/**
 * @package modules.widget
 */
class PageListWidgetModule extends WidgetModule {
	private $oListWidget;
	
	public function __construct() {
		$this->oListWidget = new ListWidgetModule();
		$oDelegateProxy = new CriteriaListWidgetDelegate($this, "Page");
		$this->oListWidget->setDelegate($oDelegateProxy);
	}
	
	public function doWidget() {
		$aTagAttributes = array('class' => 'page_list');
		$oListTag = new TagWriter('ul', $aTagAttributes);
		$this->oListWidget->setListTag($oListTag);
		return $this->oListWidget->doWidget();
	}
	
	public function getColumnIdentifiers() {
		return array('id', 'page_title', 'name', 'parent_id', 'is_protected', 'is_hidden', 'is_inactive');
	}
	
	public function getMetadataForColumn($sColumnIdentifier) {
		$aResult = array();
		switch($sColumnIdentifier) {
			case 'page_title':
        $aResult['display_heading'] = false;
				break;
			case 'name':
				$aResult['display_type'] = ListWidgetModule::DISPLAY_TYPE_DATA;
				break;
			case 'parent_id':
				$aResult['display_type'] = ListWidgetModule::DISPLAY_TYPE_DATA;
				break;
			case 'is_protected':
				$aResult['display_type'] = ListWidgetModule::DISPLAY_TYPE_DATA;
				break;
			case 'is_hidden':
				$aResult['display_type'] = ListWidgetModule::DISPLAY_TYPE_DATA;
				break;
			case 'is_inactive':
				$aResult['display_type'] = ListWidgetModule::DISPLAY_TYPE_DATA;
				break;
		}
		return $aResult;
	}
	
	public static function getCriteria() {
		return PagePeer::getPagesRecursiveCriteria();
	}
}