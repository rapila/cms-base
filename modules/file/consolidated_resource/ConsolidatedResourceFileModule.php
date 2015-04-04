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
		$oCachingStrategy = clone CachingStrategy::fromConfig('file');
		$oCache = new Cache($sKey, DIRNAME_PRELOAD, $oCachingStrategy);
		$oCache->sendCacheControlHeaders();
		if(!$oCache->entryExists(false)) {
			foreach($aKeys as $sItemKey) {
				$oCachingStrategy = clone $oCachingStrategy;
				$oCachingStrategy->init(array('key_encode' => null));
				$oItemCache = new Cache($sItemKey, DIRNAME_PRELOAD, $oCachingStrategy);
				if(!$oItemCache->entryExists(false)) {
					throw new Exception("Consolidated resource $sItemKey does not exist.");
				}
				$oCache->setContents($oItemCache->getContentsAsString()."\n", false, true);
			}
		}
		$oCache->sendCacheControlHeaders();
		$oCache->passContents(true);
	}
}