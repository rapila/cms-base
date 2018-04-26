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
	 * configure page_size per site or list-widget
	 * – by configuring global value or local overwrite value in config.yml
	 * admin:
	 *   page_size: number [0, none]
	 *   example_list_page_size:  number [0, none]
	 */
	public function addPaging($iPageSize = 'default') {
		$sConfigKey = 'page_size';
		if($iPageSize === 'default') {
			$iPageSize = Settings::getSetting('admin', $this->getModuleName()."_$sConfigKey", 'default');
		}
		if($iPageSize === 'default') {
			$iPageSize = Settings::getSetting('admin', $sConfigKey, 25);
		}
		if(is_numeric($iPageSize) && $iPageSize > 0) {
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