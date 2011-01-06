<?php

class WidgetResourceFileModule extends TemplateResourceFileModule {
  protected function getModuleType() {
		return WidgetModule::getType();
	}
}