<?php
class ConsolidatedResourceFileModule extends FileModule {
	private $sType;
	private $oCache;
	
	public function __construct($aRequestPath) {
		parent::__construct($aRequestPath);
		$this->sType = Manager::usePath();
		$sCacheKey = Manager::usePath();
		$this->oCache = new Cache($sCacheKey, DIRNAME_PRELOAD, Cache::FLAG_FILE_DIRECT);
	}
	
	public function renderFile() {
		if(!$this->oCache->cacheFileExists(false)) {
			throw new Exception('Consolidated resource does not exist.');
		}
		$sCharset = Settings::getSetting('encoding', 'browser', 'utf-8');
		if($this->sType === ResourceIncluder::RESOURCE_TYPE_CSS) {
			header("Content-Type: text/css;charset=$sCharset");
		} else if($this->sType === ResourceIncluder::RESOURCE_TYPE_JS) {
			header("Content-Type: text/javascript;charset=$sCharset");
		}
		$this->oCache->sendCacheControlHeaders();
		$this->oCache->passContents(true);
	}
}