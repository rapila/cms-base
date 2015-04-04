<?php

class NamespacedPreviewCssFileModule extends FileModule {
	private $oFile;
	
	public function __construct($aRequestPath) {
		parent::__construct($aRequestPath);

		// if(!Session::getSession()->isAuthenticated() || !Session::getSession()->getUser()->getIsBackendLoginEnabled()) {
		// 	throw new Exception("Not allowed");
		// }

		array_unshift($aRequestPath, DIRNAME_WEB, ResourceIncluder::RESOURCE_TYPE_CSS);
		$this->oFile = ResourceFinder::findResourceObject($aRequestPath);
	}
	
	public function renderFile() {
		if($this->oFile === null) {
			throw new Exception("File ".implode('/', $this->aPath)." not found");
		}
		self::processCSSContent(file_get_contents($this->oFile->getFullPath()), $this->oFile);
	}
	
	public static function processCSSContent($sContent, $oFile) {
		$oCache = new Cache('preview_css'.$oFile->getInternalPath(), DIRNAME_TEMPLATES);
		header("Content-Type: text/css;charset=".Settings::getSetting('encoding', 'browser', 'utf-8'));
		if($oCache->entryExists() && !$oCache->isOutdated($oFile->getFullPath())) {
			$oCache->sendCacheControlHeaders();
			$oCache->passContents(); exit;
		}

		$oParser = new Sabberworm\CSS\Parser($sContent, Sabberworm\CSS\Settings::create()->withDefaultCharset(Settings::getSetting('encoding', 'browser', 'utf-8')));
		$oCssContents = $oParser->parse();

		//Make all rules important
		// foreach($oCssContents->getAllRuleSets() as $oCssRuleSet) {
		//	foreach($oCssRuleSet->getRules() as $oRule) {
		//		$oRule->setIsImportant(true);
		//	}
		// }

		//Multiply all rules and prepend specific strings
		$aPrependages = array('#rapila_admin_menu', '.filled-container.editing', '.ui-dialog', '.cke_dialog_contents', '#widget-notifications', '.cke_reset', 'body > .cke_reset_all', '.tag_panel');
		foreach($oCssContents->getAllDeclarationBlocks() as $oBlock) {
			$aNewSelector = array();
			foreach($oBlock->getSelectors() as $iKey => $oSelector) {
				$sSelector = $oSelector->getSelector();
				if(StringUtil::startsWith($sSelector, "body ") || StringUtil::startsWith($sSelector, "html ")) {
					$aNewSelector[] = $sSelector;
				} else {
					foreach($aPrependages as $sPrependage) {
						if(StringUtil::startsWith($sSelector, "$sPrependage ") || StringUtil::startsWith($sSelector, "$sPrependage.") || $sSelector === $sPrependage) {
							$aNewSelector[] = $sSelector;
						} else {
							$aNewSelector[] = "$sPrependage $sSelector";
						}
					}
				}
			}
			$oBlock->setSelector($aNewSelector);
		}

		//Absolutize all URLs
		foreach($oCssContents->getAllValues() as $oValue) {
			if($oValue instanceof Sabberworm\CSS\Value\URL) {
				$sURL = $oValue->getURL()->getString();

				if(!StringUtil::startsWith($sURL, '/') && !preg_match('/^\\w+:/', $sURL)) {
					$sURL = $oFile->getFrontendDirectoryPath().DIRECTORY_SEPARATOR.$sURL;
				}

				$oValue->setURL(new Sabberworm\CSS\Value\String($sURL));
			}
		}

		$sContents = $oCssContents->render(Sabberworm\CSS\OutputFormat::createCompact());

		$oCache->setContents($sContents);
		$oCache->sendCacheControlHeaders();
		print($sContents);

	}
}
