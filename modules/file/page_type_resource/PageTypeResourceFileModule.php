<?php

class PageTypeResourceFileModule extends TemplateResourceFileModule {
  protected function getModuleType() {
		return PageTypeModule::getType();
	}
}