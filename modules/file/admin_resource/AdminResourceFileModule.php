<?php

class AdminResourceFileModule extends TemplateResourceFileModule {
  protected function getModuleType() {
		return AdminModule::getType();
	}
}