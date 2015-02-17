<?php

abstract class SpecializedListWidgetModule extends WidgetModule {
	protected $oListWidget = null;

	public function __construct() {
		$this->oListWidget = $this->createListWidget();
		$this->oListWidget->specialize($this);
		parent::setSetting('list_widget_session', $this->oListWidget->getSessionKey());
	}

	protected abstract function createListWidget();

	public function getListWidget() {
		return $this->oListWidget;
	}

	/**
	 * @param optional int / string $iPageSize
	 * @param optional string $sModule ExampleNameModule > example_name
	 * configure page_size per site or module
	 * – globally by configuring section admin: page_size
	 * – overwrite page_size locally configuring admin: example_name-page_size
	 */
	public function addPaging($iPageSize = null, $sModule = null) {
		$sConfigKey = 'page_size';
		if($sModule) {
			$iPageSize = Settings::getSetting('admin', "$sModule-$sConfigKey", null);
		}
		$iPageSize = $iPageSize ? $iPageSize : Settings::getSetting('admin', $sConfigKey, 20);
		if(is_numeric($iPageSize)) {
			$this->oListWidget->setSetting('page_size', $iPageSize);
		}
	}

	public function getSessionKey() {
		return $this->oListWidget->getSessionKey();
	}

	public function doWidget() {
		return $this->oListWidget->doWidget();
	}

	public function setSetting($sSettingName, $mSettingValue) {
		parent::setSetting($sSettingName, $mSettingValue);
		// Duplicate settings onto the list widget
		$this->oListWidget->setSetting($sSettingName, $mSettingValue);
	}

}