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

	public function addPaging($iPageSize = null) {
		$iPageSize = $iPageSize ? $iPageSize : Settings::getSetting('admin', 'page_size', 20);
		$this->oListWidget->setSetting('page_size', $iPageSize);
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