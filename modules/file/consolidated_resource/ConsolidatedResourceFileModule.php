<?php
class ConsolidatedResourceFileModule extends FileModule {
	private $sType;
	
	public function __construct($aRequestPath) {
		parent::__construct($aRequestPath);
		$this->sType = Manager::usePath();
	}
	
	public function renderFile() {
		//Send Content-Type
		$sCharset = Settings::getSetting('encoding', 'browser', 'utf-8');
		if($this->sType === ResourceIncluder::RESOURCE_TYPE_CSS) {
			header("Content-Type: text/css;charset=$sCharset");
		} else if($this->sType === ResourceIncluder::RESOURCE_TYPE_JS) {
			header("Content-Type: text/javascript;charset=$sCharset");
		}

		//Find consolidated resources
		$aKeys = array();
		while(Manager::hasNextPathItem()) {
			$aKeys[] = Manager::usePath();
		}
		$sKey = 'consolidated-output-'.$this->sType.'-'.implode('|', $aKeys);
		$oCache = new Cache($sKey, DIRNAME_PRELOAD);
		$oCache->sendCacheControlHeaders();
		if(!$oCache->cacheFileExists(false)) {
			foreach($aKeys as $sItemKey) {
				$oItemCache = new Cache($sItemKey, DIRNAME_PRELOAD, Cache::FLAG_FILE_DIRECT);
				if(!$oItemCache->cacheFileExists(false)) {
					throw new Exception("Consolidated resource $sItemKey does not exist.");
				}
				$oCache->setContents($oItemCache->getContentsAsString(), false, true);
			}
		}
		$oCache->sendCacheControlHeaders();
		$oCache->passContents(true);
	}
}