<?php
class ConsolidatedResourceFileModule extends FileModule {
	private $sType;

	public function __construct($aRequestPath) {
		parent::__construct($aRequestPath);
		$this->sType = Manager::usePath();
	}

	public function renderFile() {
		if(!$this->sType) {
			throw new UserError("No type given.");
		}
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
		if(empty($aKeys)) {
			throw new UserError("No items requested.");
		}
		$sKey = 'consolidated-output-'.$this->sType.'-'.implode('|', $aKeys);
		$oCachingStrategy = clone CachingStrategy::fromConfig('file');
		$oCache = new Cache($sKey, 'resource', $oCachingStrategy);
		$oItemCachingStrategy = clone $oCachingStrategy;
		$oItemCachingStrategy->init(array('key_encode' => null));
		$oCache->sendCacheControlHeaders();
		if(!$oCache->entryExists(false)) {
			foreach($aKeys as $sItemKey) {
				if(!preg_match('/^[0-9a-f]+$/', $sItemKey)) {
					// User tried to load resource with a string that is not a cache key
					throw new UserError("Consolidated resource $sItemKey does not exist.");
				}
				$oItemCache = new Cache($sItemKey, DIRNAME_PRELOAD, $oItemCachingStrategy);
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