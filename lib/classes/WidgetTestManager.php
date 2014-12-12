<?php

class WidgetTestManager extends AdminManager {
	public function renderAdmin(Template $oTemplate = null) {
		$oTemplate->replaceIdentifier("title", "Widget Test" . ($this->getModuleName() ? ': ' . WidgetModule::getDisplayNameByName($this->getModuleName()) : ''));
		$this->listInSidebar($oTemplate);
		$this->content($oTemplate);
	}

	private function listInSidebar(Template $oTemplate) {
		$aWidgets = Module::listModulesByType(WidgetModule::getType());
		$oLinks = new Template(TemplateIdentifier::constructIdentifier('links'), null, true);
		foreach($aWidgets as $sWidgetName => $aWidgetInfo) {
			$oLink = new Template('<a href="{{href}}">{{name}}</a><br />', null, true);
			$oLink->replaceIdentifier('href', LinkUtil::link(array($sWidgetName), get_class()));
			$oLink->replaceIdentifier('name', WidgetModule::getDisplayNameByName($sWidgetName));
			$oLinks->replaceIdentifierMultiple('links', $oLink);
		}
		$oTemplate->replaceIdentifierMultiple('sidebar_content', $oLinks);
	}
	
	private function content(Template $oTemplate) {
		$sWidgetName = $this->getModuleName();
		$sWidgetClass = WidgetModule::getClassNameByName($sWidgetName);
		if(is_callable(array($sWidgetClass, 'testWidget'))) {
			$oWidget = $sWidgetClass::testWidget();
		} else {
			$oWidget = WidgetModule::getWidget($sWidgetName, null);
		}

		$oTemplate->replaceIdentifierMultiple('main_content', $oWidget->doWidget());
	}
}