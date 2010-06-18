<?php
/**
 * @package modules.admin
 */
class StringsAdminModule extends AdminModule {

	private $oListWidget;
	private $oSidebarWidget;
	
	public function __construct() {
		$this->oListWidget 		= new StringListWidgetModule();
		$this->addResourceParameter(ResourceIncluder::RESOURCE_TYPE_JS, 'name_space', $this->oListWidget->oDelegateProxy->getNameSpace());

		$this->oSidebarWidget = new ListWidgetModule();
		$this->oSidebarWidget->setListTag(new TagWriter('ul', array('class' => 'use_sidebar_icons')));
		$this->oSidebarWidget->setDelegate($this);
	}
	
	public function mainContent() {
		return $this->oListWidget->doWidget();
	}
	
	public function sidebarContent() {
		return $this->oSidebarWidget->doWidget();
	}
	
	public function getColumnIdentifiers() {
		return array('title', 'name_space', 'magic_column');
	}
	
	public function getMetadataForColumn($sColumnIdentifier) {
		$aResult = array();
		switch($sColumnIdentifier) {
			case 'title':
				$aResult['display_heading'] = false;
				break;
			case 'name_space':
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
		if(StringPeer::doCount(new Criteria()) > 0) {
		 	return array(
				array('name_space' => CriteriaListWidgetDelegate::SELECT_ALL,
							'title' => StringPeer::getString('widget.documents.select_all_title'),
							'magic_column' => 'all')
			);
		}
		return array();
	}
	
	public static function getListContents($iRowStart = 0, $iRowCount = null) {
		$aResult = array();
		foreach(StringPeer::getNamespaces() as $sNameSpace) {
			$aResult[] = array('title' => $sNameSpace, 'name_space' => $sNameSpace);
		}
		if($iRowCount === null) {
			$iRowCount = count($aResult);
		}
		$aResult = array_merge(self::getCustomListElements(), $aResult);
		// array_unshift($aResult, self::getCustomListElements());
		// ErrorHandler::log($aResult);
		return $aResult;
		// return array_splice($aResult, $iRowStart, $iRowCount);
	}

	public function usedWidgets() {
		return array($this->oSidebarWidget, $this->oListWidget);
	}
}
