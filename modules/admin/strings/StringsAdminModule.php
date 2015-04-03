<?php
/**
 * @package modules.admin
 */
class StringsAdminModule extends AdminModule implements ListWidgetDelegate {

	private $oListWidget;
	private $oSidebarWidget;

	public function __construct() {
		$this->oListWidget = new StringListWidgetModule();
		$this->oListWidget->addPaging();
		$this->oSidebarWidget = new ListWidgetModule();
		$this->oSidebarWidget->setListTag(new TagWriter('ul'));
		$this->oSidebarWidget->setDelegate($this);
    $this->oSidebarWidget->setSetting('initial_selection', array('name_space' => $this->oListWidget->oDelegateProxy->getNameSpace()));
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
				$aResult['heading'] = StringPeer::getString('wns.string.name_space');
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
		if(count(StringPeer::getNamespaces()) > 0) {
		 	$aElements = array(
				array('name_space' => CriteriaListWidgetDelegate::SELECT_ALL,
							'title' => StringPeer::getString('wns.strings.select_all_title'),
							'magic_column' => 'all')
			);
			if(StringQuery::create()->filterByKeysWithoutNamespace()->count() > 0) {
			 	$aElementsWithout = array(
					array('name_space' => CriteriaListWidgetDelegate::SELECT_WITHOUT,
								'title' => StringPeer::getString('wns.strings.select_without_title'),
								'magic_column' => 'without')
				);
				$aElements = array_merge($aElements, $aElementsWithout);
			}
			return $aElements;
		}
		return array();
	}

	public function getListContents($iRowStart = 0, $iRowCount = null) {
		$aResult = array();
		foreach(StringPeer::getNamespaces() as $sNameSpace) {
			$aResult[] = array('title' => $sNameSpace, 'name_space' => "$sNameSpace.");
		}
		$aResult = array_merge(self::getCustomListElements(), $aResult);
		return $aResult;
	}

	public function numberOfRows() {
		return count($this->getListContents());
	}

	public function usedWidgets() {
		return array($this->oSidebarWidget, $this->oListWidget);
	}
}
