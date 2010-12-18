<?php
/**
 * @package modules.admin
 */
class TagsAdminModule extends AdminModule {

	private $oListWidget;
	private $oSidebarWidget;
	
	public function __construct() {
		$this->oListWidget 		= new TagListWidgetModule();
		$this->addResourceParameter(ResourceIncluder::RESOURCE_TYPE_JS, 'model_name', $this->oListWidget->oDelegateProxy->getModelName());

		$this->oSidebarWidget = new ListWidgetModule();
		$this->oSidebarWidget->setListTag(new TagWriter('ul'));
		$this->oSidebarWidget->setDelegate($this);
	}
	
	public function mainContent() {
		return $this->oListWidget->doWidget();
	}
	
	public function sidebarContent() {
		return $this->oSidebarWidget->doWidget();
	}
	
	public function getColumnIdentifiers() {
		return array('title', 'model_name', 'magic_column');
	}
	
	public function getMetadataForColumn($sColumnIdentifier) {
		$aResult = array();
		switch($sColumnIdentifier) {
			case 'title':
				$aResult['heading'] = StringPeer::getString('wns.tag_instance.model_name');
				break;
			case 'model_name':
				$aResult['display_type'] = ListWidgetModule::DISPLAY_TYPE_DATA;
				break;
			case 'magic_column':
				$aResult['display_type'] = ListWidgetModule::DISPLAY_TYPE_CLASSNAME;
				$aResult['has_data'] = false;
				break;
		}
		return $aResult;
	}
	
	public static function getCustomListElements() {
		if(TagInstancePeer::doCount(TagInstancePeer::getTaggedModelsCriteria())) {
		 	return array(
				array('model_name' => CriteriaListWidgetDelegate::SELECT_ALL,
							'title' => StringPeer::getString('wns.documents.select_all_title'),
							'magic_column' => 'all')
			);
		}
		return array();
	}
	
	public static function getListContents($iRowStart = 0, $iRowCount = null) {
		$aResult = array();
		foreach(TagInstancePeer::getTaggedModels() as $sModel => $sModelName) {
			$aResult[] = array('title' => $sModelName, 'model_name' => $sModel);
		}
		if($iRowCount === null) {
			$iRowCount = count($aResult);
		}
		$aResult = array_merge(self::getCustomListElements(), $aResult);
		return $aResult;
	}

	public function usedWidgets() {
		return array($this->oSidebarWidget, $this->oListWidget);
	}
}
