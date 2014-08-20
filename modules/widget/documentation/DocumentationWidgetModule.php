<?php
class DocumentationWidgetModule extends PersistentWidgetModule {
	public function __construct($sSessionKey = null) {
		parent::__construct($sSessionKey);
	}

	public function loadDocumentations() {
		$aMetaData = DocumentationProviderTypeModule::completeMetaData();
		return $aMetaData;
	}
}