<?php
interface WidgetBasedFrontendModule {
	public function widgetData();
	public function widgetSave($mData);
	public function getWidget();
}