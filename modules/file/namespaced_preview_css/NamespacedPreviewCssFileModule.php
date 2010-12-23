<?php

require_once("cssparser/CSSParser.php");

class NamespacedPreviewCssFileModule extends FileModule {
	private $oFile;
	
	public function __construct($aRequestPath) {
		parent::__construct($aRequestPath);
		
		if(!Session::getSession()->isAuthenticated() || !Session::getSession()->getUser()->getIsBackendLoginEnabled()) {
			throw new Exception("Not allowed");
		}
		
		array_unshift($aRequestPath, DIRNAME_WEB, ResourceIncluder::RESOURCE_TYPE_CSS);
		$this->oFile = ResourceFinder::findResourceObject($aRequestPath);
	}
	
	public function renderFile() {
		if($this->oFile === null) {
			throw new Exception("File ".implode('/', $this->aPath)." not found");
		}
		
		$oCache = new Cache('preview_css'.$this->oFile->getInternalPath(), DIRNAME_TEMPLATES);
		$oCache->sendCacheControlHeaders();
		header("Content-Type: text/css;charset=".Settings::getSetting('encoding', 'browser', 'utf-8'));
		if($oCache->cacheFileExists() && !$oCache->isOutdated($this->oFile->getFullPath())) {
			$oCache->passContents(); exit;
		}
		
		$oParser = new CSSParser(file_get_contents($this->oFile->getFullPath()), Settings::getSetting('encoding', 'browser', 'utf-8'));
		$oCssContents = $oParser->parse();
		
		//Make all rules important
		foreach($oCssContents->getAllRuleSets() as $oCssRuleSet) {
			foreach($oCssRuleSet->getRules() as $oRule) {
				$oRule->setIsImportant(true);
			}
		}
		
		//Triple all rules and prepend specific strings
		$aPrependages = array('#cmos_admin_menu', '.filled-container.editing', '.ui-dialog', '.cke_dialog_contents');
		foreach($oCssContents->getAllSelectors() as $oSelector) {
			$aNewSelector = array();
			foreach($oSelector->getSelector() as $iKey => $sSelector) {
				foreach($aPrependages as $sPrependage) {
					$aNewSelector[] = "$sPrependage $sSelector";
				}
			}
			$oSelector->setSelector($aNewSelector);
		}
		
		//Absolutize all URLs
		foreach($oCssContents->getAllValues() as $oValue) {
			if($oValue instanceof CSSURL) {
				$sURL = $oValue->getURL()->getString();
				
				if(!StringUtil::startsWith($sURL, '/') && !preg_match('/^\\w+:/', $sURL)) {
					$sURL = $this->oFile->getFrontendDirectoryPath().DIRECTORY_SEPARATOR.$sURL;
				}
				
				$oValue->setURL(new CSSString($sURL));
			}
		}
		
		$sContents = $oCssContents->__toString();
		
		$oCache->setContents($sContents);
		$oCache->sendCacheControlHeaders();
		print($sContents);
	}
}