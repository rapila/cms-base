<?php

class NamespacedPreviewResourceFileModule extends TemplateResourceFileModule {
  protected function getModuleType() {
		return WidgetModule::getType();
	}
	
	public function renderFile() {
		$oTemplate = new Template("$this->sModuleName.$this->sModuleType.$this->sResourceType", array(DIRNAME_MODULES, $this->sModuleType, $this->sModuleName, DIRNAME_TEMPLATES));
		NamespacedPreviewCssFileModule::processCSSContent($oTemplate->render(), ResourceFinder::findResourceObject(array(DIRNAME_MODULES, $this->sModuleType, $this->sModuleName, DIRNAME_TEMPLATES, "$this->sModuleName.$this->sModuleType.$this->sResourceType.tmpl")));
	}
}