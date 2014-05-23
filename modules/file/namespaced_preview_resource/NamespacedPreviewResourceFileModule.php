<?php

class NamespacedPreviewResourceFileModule extends TemplateResourceFileModule {
  protected function getModuleType() {
		return WidgetModule::getType();
	}
	
	public function renderFile() {
		$oTemplate = new Template("$this->sModuleName.$this->sModuleType.$this->sResourceType", array(DIRNAME_MODULES, $this->sModuleType, $this->sModuleName, DIRNAME_TEMPLATES));
		$sContents = $oTemplate->render();
		$sModuleClass = Module::getClassNameByTypeAndName($this->sModuleType, $this->sModuleName);
		if($this->sResourceType === ResourceIncluder::RESOURCE_TYPE_CSS && $sModuleClass::USE_NAMESPACED_CSS) {
			$oFile = ResourceFinder::findResourceObject(array(DIRNAME_MODULES, $this->sModuleType, $this->sModuleName, DIRNAME_TEMPLATES, "$this->sModuleName.$this->sModuleType.$this->sResourceType.tmpl"));
			NamespacedPreviewCssFileModule::processCSSContent($sContents, $oFile);
		} else {
			header("Content-Type: text/css;charset=".Settings::getSetting('encoding', 'browser', 'utf-8'));
			print($sContents);
		}
	}
}