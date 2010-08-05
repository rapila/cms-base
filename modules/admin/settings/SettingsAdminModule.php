<?php
class SettingsAdminModule extends AdminModule {
	private $oChooserList;
	
	public function __construct() {
		$this->oChooserList = WidgetModule::getWidget('list');
		$this->oChooserList->setDelegate($this);
		$this->addResourceParameter(ResourceIncluder::RESOURCE_TYPE_JS, 'chooser', $this->oChooserList->getSessionKey());
	}
	
	public function usedWidgets() {
		return array($this->oChooserList);
	}
	
	public function getColumnIdentifiers() {
		return array('title', 'key');
	}
	
	public function getMetadataForColumn($sColumnIdentifier) {
		$aResult = array();
		if($sColumnIdentifier === 'key') {
			$aResult['display_type'] = ListWidgetModule::DISPLAY_TYPE_DATA;
		} else {
			$oUser = Session::getSession()->getUser();
			$aResult['heading'] = StringPeer::getString('widget.settings.sidebar_heading', null, null, array('user_name' => $oUser->getFullName()));
		}
		return $aResult;
	}
	
	public function getListContents($iRowStart = 0, $iRowCount = null) {
		$aResult = array();
		$aSettingOptions = array('admin_menu', 'rich_text', 'dashboard');
		foreach($aSettingOptions as $sAction) {
			$aResult[] = array('key' => $sAction, 'title' => StringPeer::getString('widget.settings.type.'.$sAction));
		}
		if($iRowCount === null) {
			$iRowCount = count($aResult);
		}
		return array_splice($aResult, $iRowStart, $iRowCount);
	}
}