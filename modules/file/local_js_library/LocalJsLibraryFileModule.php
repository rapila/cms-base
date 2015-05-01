<?php

class LocalJsLibraryFileModule extends FileModule {
	private $aLibraryName;
	private $sVersion;
	private $bUseCompression;

	public function __construct($aRequestPath) {
		parent::__construct($aRequestPath);
		$this->aLibraryName = Manager::usePath();
		$this->aVersion = Manager::usePath();
		$sExtension = Manager::usePath();
		$this->bUseCompression = $sExtension === 'min.js';
	}

	public function renderFile() {
		$oCache = new Cache(implode('/', Manager::getUsedPath()), 'versioned');
		header("Content-Type: text/javascript;charset=utf-8");
		if($oCache->entryExists()) {
			$oCache->sendCacheControlHeaders();
			$oCache->passContents(); exit;
		}
		$oIncluder = new ResourceIncluder();
		//Don’t use SSL for downloads
		$oIncluder->addJavaScriptLibrary($this->aLibraryName, $this->aVersion, $this->bUseCompression, false, false, ResourceIncluder::PRIORITY_NORMAL, false);
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