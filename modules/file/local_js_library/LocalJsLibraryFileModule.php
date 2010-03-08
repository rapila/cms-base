<?php

class LocalJsLibraryFileModule extends FileModule {
	private $aLibraryName;
	
	public function __construct($aRequestPath) {
		parent::__construct($aRequestPath);
		$this->aLibraryName = Manager::usePath();
	}
	
	public function renderFile() {
		$oCache = new Cache($this->aLibraryName.''.serialize($_GET), DIRNAME_TEMPLATES);
		$oCache->sendCacheControlHeaders();
		header("Content-Type: text/javascript");
		if($oCache->cacheFileExists(true)) {
			$oCache->passContents(); exit;
		}
		$oIncluder = new ResourceIncluder();
		$sLibraryVersion = $_GET['version'];
		$bUseCompression = BooleanParser::booleanForString($_GET['use_compression']);
		$bUseSsl = BooleanParser::booleanForString($_GET['use_ssl']);
		$oIncluder->addJavaScriptLibrary($this->aLibraryName, $sLibraryVersion, $bUseCompression, false, $bUseSsl, ResourceIncluder::PRIORITY_NORMAL, false);
		$sContents = '';
		foreach($oIncluder->getLocationsForIncludedResourcesOfPriority() as $sLocation) {
			$sContents .= file_get_contents($sLocation);
		}
		$oCache->setContents($sContents);
		print($sContents);
	}
}