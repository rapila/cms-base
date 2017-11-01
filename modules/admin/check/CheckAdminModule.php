<?php
/**
 * @package modules.admin
 */
class CheckAdminModule extends AdminModule implements ListWidgetDelegate {

	private $sAction = null;
	private $oTemplate;
	private $oCheckOptionWidget;
	private $aCheckOptions = array("pages", "strings", "static_strings", "config", "tags", "content");

	private static $EMPTY_STRING_KEY = "139c4e89cdbedaf144d05ca54a12a57b";

	private static $CONFIG_SETTINGS_SHOULD = array( "magic_quotes_gpc" => "0",
																									"safe_mode" => "",
																									"file_uploads" => "1",
																									"allow_url_fopen" => "1",
																									"output_buffering" => "1",
																									"magic_quotes_runtime" => "");

	private static $CONFIG_SETTINGS_SHOULD_NOT = array( "last_modified" => '1',
																											"register_globals" => '1');
	const LOG_LEVEL_INFO = 0;
	const LOG_LEVEL_NOTICE = 2;
	const LOG_LEVEL_WARNING = 4;
	const LOG_LEVEL_ERROR = 6;

	public function __construct() {
		$this->oCheckOptionWidget = new ListWidgetModule();
		$this->oCheckOptionWidget->setListTag(new TagWriter('ul'));
		$this->oCheckOptionWidget->setDelegate($this);
	}

	public function sidebarContent() {
		return $this->oCheckOptionWidget->doWidget();
	}

	public function mainContent() {
		// return $this->constructTemplate('main');
	}

	public function setAction($sAction) {
	  $this->sAction = $sAction;
	}

	public function getColumnIdentifiers() {
		return array('action', 'title');
	}

	public function getMetadataForColumn($sColumnIdentifier) {
		$aResult = array();
		switch($sColumnIdentifier) {
			case 'action':
				$aResult['display_type'] = ListWidgetModule::DISPLAY_TYPE_DATA;
				break;
			case 'title':
				$aResult['heading'] = TranslationPeer::getString('wns.check.sidebar_heading');
				break;
		}
		return $aResult;
	}

	public function numberOfRows() {
		return count($this->aCheckOptions);
	}

	public function getListContents($iRowStart = 0, $iRowCount = null) {
		$aResult = array();
		foreach($this->aCheckOptions as $sAction) {
			$aResult[] = array('action' => $sAction, 'title' => TranslationPeer::getString('wns.check.'.$sAction));
		}
		if($iRowCount === null) {
			$iRowCount = count($aResult);
		}
		return array_splice($aResult, $iRowStart, $iRowCount);
	}

	public function usedWidgets() {
		return array($this->oCheckOptionWidget);
	}
}
