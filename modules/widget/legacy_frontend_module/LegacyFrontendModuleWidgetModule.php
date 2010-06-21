<?php
class LegacyFrontendModuleWidgetModule extends PersistentWidgetModule {
	private $oFrontendModule;
	
	public function __construct($sSessionKey, $oFrontendModule) {
		parent::__construct($sSessionKey);
		$this->oFrontendModule = $oFrontendModule;
	}
	
	public function getModuleContent() {
		$sClass = get_class($this->oFrontendModule);
		return $sClass::getContentInfo(LanguageObjectPeer::retrieveByPK($this->oFrontendModule->getLanguageObject()->getObjectId(), $this->oFrontendModule->getLanguageObject()->getLanguageId()));
		// return $this->oFrontendModule->renderFrontend()->render();
	}
}