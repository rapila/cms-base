<?php

class PageObjectFillHelper {
	private $oPage;
	private $oNavigationItem;
	private $sLanguageId;
	private $oFrontendTemplate;
	private $bIsPreview;

	private $iModuleId = 1;

	public function __construct($oPage, $oNavigationItem) {
		$this->oPage = $oPage;
		$this->oNavigationItem = $oNavigationItem;
	}

	public function fill($sLanguageId, $oTemplate, $bIsPreview = false) {
		$this->sLanguageId = $sLanguageId;
		$this->oFrontendTemplate = $oTemplate;
		$this->bIsPreview = $bIsPreview;
		$this->oFrontendTemplate->replaceIdentifierCallback("container", $this, "fillContainer", Template::NO_HTML_ESCAPE);
	}

	public function fillContainer($oTemplateIdentifier, $iFlags) {
		if($oTemplateIdentifier->hasParameter('declaration_only')) {
			// Container exists only to appear in admin area, not be rendered in frontend (at least not directly)
			return;
		}
		$bInheritContainer = BooleanParser::booleanForString($oTemplateIdentifier->getParameter("inherit"));
		$sContainerName = $oTemplateIdentifier->getValue();
		$aPageObjects = $this->oPage->getObjectsForContainer($sContainerName);
		if(count($aPageObjects) === 0 && $bInheritContainer) {
			$oParent = $this->oPage;
			while (($oParent = $oParent->getParent()) !== null && count($aPageObjects) === 0) {
				$aPageObjects = $oParent->getObjectsForContainer($sContainerName);
			}
		}
		if(count($aPageObjects) === 0) {
			return null;
		}

		$aObjectTypes = array();
		$oTemplate = new Template(TemplateIdentifier::constructIdentifier('container'), null, true);
		foreach($aPageObjects as $oContainer) {
			if($this->fillContainerWithModule($oContainer, $oTemplate, $this->iModuleId) === false) {
				continue;
			}
			FilterModule::getFilters()->handleDefaultPageTypeFilledContainer($oContainer, $this->oPage, $oTemplate, $this->oFrontendTemplate, $this->iModuleId);
			$this->iModuleId++;

			if(isset($aObjectTypes[$oContainer->getObjectType()])) {
				$aObjectTypes[$oContainer->getObjectType()]++;
			} else {
				$aObjectTypes[$oContainer->getObjectType()] = 1;
			}
		}
		$this->oFrontendTemplate->replaceIdentifier("container_filled_types", implode(',', array_keys($aObjectTypes)), $sContainerName);

		if(count($aObjectTypes) === 0) {
			return null;
		}
		return $oTemplate;
	} // fillOneContainer()

	/**
	 * fillContainerWithModule()
	 */
	private function fillContainerWithModule($oContentObject, $oTemplate, $iModuleId) {
		$oPageContents = $oContentObject->getLanguageObject($this->sLanguageId);
		if($this->bIsPreview && $oPageContents === null) {
			//Need to get unsaved drafts in preview
			$oPageContents = new LanguageObject();
			$oPageContents->setLanguageId($this->sLanguageId);
			$oPageContents->setContentObject($oContentObject);
			$oPageContents = $oPageContents->getDraft(true);
		}
		if($oPageContents === null) {
			return false;
		}
		if($oContentObject->getConditionSerialized() !== null && !$this->bIsPreview) {
			$oConditionTemplate = unserialize(stream_get_contents($oContentObject->getConditionSerialized()));
			if($oConditionTemplate->render() === '') {
				return false;
			}
		}
		$sObjectType = $oContentObject->getObjectType();
		if(!Module::moduleExists($sObjectType, FrontendModule::getType()) || !Module::isModuleEnabled(FrontendModule::getType(), $sObjectType)) {
			$sLink = implode('/', $this->oNavigationItem->getLink());
			ErrorHandler::handleError(E_WARNING, "Disabled or non-existing frontend module $sObjectType in use on page $sLink ($this->sLanguageId)", __FILE__, __LINE__, null, debug_backtrace(), true);
			if($this->bIsPreview) {
				$oTemplate->replaceIdentifierMultiple("container", "<strong>Disabled or non-existing frontend module $sObjectType in use!</strong>", null, Template::NO_HTML_ESCAPE);
				return true;
			}
			return false;
		}
		$aPath = $this->oNavigationItem->getLink();
		if($this->bIsPreview) {
			$oModule = FrontendModule::getModuleInstance($oContentObject->getObjectType(), $oPageContents->getDraft(), $aPath, $iModuleId);
		} else {
			$oModule = FrontendModule::getModuleInstance($oContentObject->getObjectType(), $oPageContents, $aPath, $iModuleId);
		}
		$sFrontentContents = self::getModuleContents($oModule, true, $this->bIsPreview);
		if($sFrontentContents === null) {
			return false;
		}
		// module_id
		FilterModule::getFilters()->handleDefaultPageTypeFilledContainerWithModule($oContentObject, $oModule, $oTemplate, $this->oFrontendTemplate, $iModuleId);
		if($this->bIsPreview) {
			$sFrontentContents = $this->getPreviewMarkup($oContentObject, $sFrontentContents);
		}
		$oTemplate->replaceIdentifierMultiple("container", $sFrontentContents, null, Template::NO_HTML_ESCAPE);
		if(($sCss = $oModule->getCssForFrontend()) !== null) {
			ResourceIncluder::defaultIncluder()->addCustomCss($sCss, ResourceIncluder::PRIORITY_LAST);
		}
		if(($sJs = $oModule->getJsForFrontend()) !== null) {
			ResourceIncluder::defaultIncluder()->addCustomJs($sJs, ResourceIncluder::PRIORITY_LAST);
		}
		return true;
	}

	protected function getPreviewMarkup($oContentObject, $mFrontentContents) {
		if(!($mFrontentContents instanceof Template)) {
			$mFrontentContents = new Template($mFrontentContents, null, true);
		}
		return TagWriter::quickTag('div', array('data-object-id' => $oContentObject->getId(), 'data-container' => $oContentObject->getContainerName(), 'class' => 'filled-container'), $mFrontentContents);
	}

	public static function getModuleContents(FrontendModule $oModule, $bAllowTemplate = true, $bIsPreview = false) {
		$mResult = $oModule->cachedFrontend($bIsPreview);
		if(!$bAllowTemplate && $mResult instanceof Template) {
			$mResult = $mResult->render();
		}
		return $mResult;
	}
}
