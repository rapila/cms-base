<?php

class LocalJsLibraryFileModule extends FileModule {
	private $aLibraryName;
	
	public function __construct($aRequestPath) {
		parent::__construct($aRequestPath);
		$this->aLibraryName = Manager::usePath();
	}
	
	public function renderFile() {
		$oCache = new Cache($this->aLibraryName.''.serialize($_GET), DIRNAME_TEMPLATES);
		header("Content-Type: text/javascript");
		$oCache->sendCacheControlHeaders();
		if($oCache->cacheFileExists(true)) {
			$oCache->passContents(); exit;
		}
		$oIncluder = new ResourceIncluder();
		$sLibraryVersion = $_GET['version'];
		$bUseCompression = BooleanParser::booleanForString($_GET['use_compression']);
		//Don’t use SSL for downloads
		$oIncluder->addJavaScriptLibrary($this->aLibraryName, $sLibraryVersion, $bUseCompression, false, false, ResourceIncluder::PRIORITY_NORMAL, false);
		$sContents = '';
		foreach($oIncluder->getResourceInfosForIncludedResourcesOfPriority() as $aInfo) {
			if(isset($aInfo['file_resource'])) {
				$sContents .= file_get_contents($aInfo['file_resource']->getFullPath());
			} else {
				$sLocation = $aInfo['location'];
				if(StringUtil::startsWith($sLocation, '//')) {
					$sLocation = 'http:'.$sLocation;
				}
				$sContents .= file_get_contents($sLocation);
			}
		}
		$oCache->setContents($sContents);
		$oCache->sendCacheControlHeaders();
		print($sContents);
	}
}