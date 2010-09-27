<?php
/**
	* @package modules.page_type
	*/


require_once("cssparser/CSSParser.php");

class DefaultPageTypeModule extends PageTypeModule {
	
	private $oFrontendTemplate;
	private $iModuleId;
	private $sContainerName;
	private $sLanguageId;
	private $bIsPreview;
	
	private static $COMPARISONS = array("eq" => "==",
																			"ne" => "!==",
																			"gt" => ">",
																			"gte" => ">=",
																			"lt" => "<",
																			"lte" => "<=",
																			"~" => "~",
																			"contains" => "contains",
																			"file_exists" => "file_exists");
	
	public function __construct(Page $oPage, $sLanguageId = null) {
		parent::__construct($oPage);
    $this->sLanguageId = $sLanguageId;
	}
	
	//Frontend stuff
	public function display(Template $oTemplate, $bIsPreview = false) {
		$this->bIsPreview = $bIsPreview;
		if($this->bIsPreview) {
			ResourceIncluder::defaultIncluder()->addResource('preview/preview-default.css');
		}
		if($this->sLanguageId === null) {
  		$this->sLanguageId = $this->bIsPreview ? AdminManager::getContentLanguage() : Session::language();
		}
		$this->oFrontendTemplate = $oTemplate;
		$this->iModuleId = 1;
		$this->oFrontendTemplate->replaceIdentifierCallback("container", $this, "fillContainer", Template::NO_HTML_ESCAPE);
	}
	
	public function fillContainer($oTemplateIdentifier, $iFlags) {
		if($oTemplateIdentifier->hasParameter('autofill')) {
			$oTemplate = new Template(TemplateIdentifier::constructIdentifier('container'), null, true);
			$oModule = FrontendModule::getModuleInstance($oTemplateIdentifier->getParameter('autofill'), $oTemplateIdentifier->getParameter('data'));
			$oTemplate->replaceIdentifierMultiple("container", $oModule->renderFrontend(), null, Template::NO_HTML_ESCAPE);
			if(($sCss = $oModule->getCssForFrontend()) !== null) {
				ResourceIncluder::defaultIncluder()->addCustomCss($sCss);
			}
			if(($sJs = $oModule->getJsForFrontend()) !== null) {
				ResourceIncluder::defaultIncluder()->addCustomJs($sJs);
			}
			return $oTemplate;
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
		if($oPageContents === null) {
			return false;
		}
		if($oContentObject->getConditionSerialized() !== null) {
			$oConditionTemplate = unserialize(stream_get_contents($oContentObject->getConditionSerialized()));
			if($oConditionTemplate->render() === '') {
				return false;
			}
		}
		$oModule = FrontendModule::getModuleInstance($oContentObject->getObjectType(), $oPageContents, $iModuleId);
		$sFrontentContents = $this->getModuleContents($oModule);
		if($sFrontentContents === null) {
			return false;
		}
		// module_id
		FilterModule::getFilters()->handleDefaultPageTypeFilledContainerWithModule($oContentObject, $oModule, $oTemplate, $this->oFrontendTemplate, $this->iModuleId);
		if($this->bIsPreview) {
			$sFrontentContents = $this->getPreviewMarkup($oContentObject, $sFrontentContents);
		}
		$oTemplate->replaceIdentifierMultiple("container", $sFrontentContents, null, Template::NO_HTML_ESCAPE);
		if(($sCss = $oModule->getCssForFrontend()) !== null) {
			ResourceIncluder::defaultIncluder()->addCustomCss($sCss);
		}
		if(($sJs = $oModule->getJsForFrontend()) !== null) {
			ResourceIncluder::defaultIncluder()->addCustomJs($sJs);
		}
		return true;
	}
	
	protected function getPreviewMarkup($oContentObject, $sFrontentContents) {
		return TagWriter::quickTag('div', array('data-object-id' => $oContentObject->getId(), 'data-container' => $oContentObject->getContainerName(), 'class' => 'filled-container'), $sFrontentContents);
	}
	
	protected function getModuleContents($oModule, $bAllowTemplate = true) {
		$mResult = $oModule->renderFrontend();
		if(!$bAllowTemplate && $mResult instanceof Template) {
			$mResult = $mResult->render();
		}
		return $mResult;
	}
	
	public function setIsDynamicAndAllowedParameterPointers(&$bIsDynamic, &$aAllowedParams, $aModulesToCheck = null) {
		foreach($this->oPage->getContentObjects() as $oContentObject) {
			if($aModulesToCheck && !in_array($oContentObject->getContainerName(), $aModulesToCheck)) {
				continue;
			}
			$sModuleName = Module::getClassNameByTypeAndName(FrontendModule::getType(), $oContentObject->getObjectType());
			if(call_user_func(array($sModuleName, "isDynamic"))) {
				$bIsDynamic = true;
				$aAllowedParams = array_merge($aAllowedParams, call_user_func(array($sModuleName, "acceptedRequestParams")));
			}
		}
	}
	
	//Admin stuff
	private $aContentObjects = array();
	private $aModuleInstances = array();
	
	private function contentObjectById($iObjectId) {
		if(!isset($this->aContentObjects[$iObjectId])) {
			$this->aContentObjects[$iObjectId] = ContentObjectPeer::retrieveByPK($iObjectId);
		}
		return $this->aContentObjects[$iObjectId];
	}
	
	private function moduleInstanceByLanguageObject($oLanguageObject) {
		$sKey = $oLanguageObject->getId();
		if(!isset($this->aModuleInstances[$sKey])) {
			$this->aModuleInstances[$sKey] = FrontendModule::getModuleInstance($oLanguageObject->getContentObject()->getObjectType(), $oLanguageObject);
		}
		return $this->aModuleInstances[$sKey];
	}
	
	public function adminListPossibleFrontendModules() {
		return FrontendModule::listContentModules();
	}
	
	public function adminListFilledFrontendModules() {
	  if($this->sLanguageId === null) {
		  $this->sLanguageId = AdminManager::getContentLanguage();
	  }
		$aContainers = $this->oPage->getTemplate()->identifiersMatching("container", Template::$ANY_VALUE);
		asort($aContainers);
		$aResult = array();
		foreach($aContainers as $oContainer) {
			if($oContainer->hasParameter('autofill')) {
				continue;
			}
			$sContainerName = $oContainer->getValue();
			$aObjects = $this->oPage->getObjectsForContainer($sContainerName);
			$bHasNoObjects = count($aObjects) === 0;
			
			$oInheritedFrom = null;
			if(BooleanParser::booleanForString($oContainer->getParameter('inherit')) && $bHasNoObjects) {
				$oInheritedFrom = $this->oPage;
				$iInheritedObjectCount = 0;
				while ($iInheritedObjectCount === 0 && ($oInheritedFrom = $oInheritedFrom->getParent()) !== null) {
					$iInheritedObjectCount = $oInheritedFrom->countObjectsForContainer($sContainerName);
				}
			}
			$aResult[$sContainerName]['inherited_from'] = null;
			if($oInheritedFrom !== null) {
				$aResult[$sContainerName]['inherited_from'] = $oInheritedFrom->getId();
			}
			
			$iCount = 0;	
			foreach($aObjects as $iCount => $oObject) {
				$iCount++;
				$oLanguageObject = $oObject->getLanguageObject($this->sLanguageId);
				if($oLanguageObject === null) {
					$aResult[$sContainerName]['contents'][$oObject->getId()]['content_info'] = false;
				} else {
					$sFrontendModuleClass = FrontendModule::getClassNameByName($oObject->getObjectType());
					$mContentInfo = call_user_func(array($sFrontendModuleClass, 'getContentInfo'), $oLanguageObject);
					$aResult[$sContainerName]['contents'][$oObject->getId()]['content_info'] = $mContentInfo;		
				}		
				$aResult[$sContainerName]['contents'][$oObject->getId()]['object_type'] = $oObject->getObjectType();		
				$aResult[$sContainerName]['contents'][$oObject->getId()]['object_type_display_name'] = Module::getDisplayNameByName($oObject->getObjectType());		
			}
			if(!isset($aResult[$sContainerName]['contents'])) {
				$aResult[$sContainerName]['contents'] = array();
			}
		}

		return $aResult;
	}
	
	public function adminAddObjectToContainer($sContainerName, $sObjectType, $iSort=0) {
		foreach($this->oPage->getObjectsForContainer($sContainerName, $iSort) as $oObject) {
			$oObject->setSort($oObject->getSort()+1);
			$oObject->save();
		}
		$oContentObject = new ContentObject();
		$oContentObject->setContainerName($sContainerName);
		$oContentObject->setObjectType($sObjectType);
		$oContentObject->setSort($iSort);
		$oContentObject->setPageId($this->oPage->getId());
		$oContentObject->save();
		return $oContentObject->getId();
	}
	
	public function adminEdit($iObjectId) {
	  if($this->sLanguageId === null) {
		  $this->sLanguageId = AdminManager::getContentLanguage();
	  }
		$oCurrentContentObject = $this->contentObjectById($iObjectId);
		$oCurrentLanguageObject = $oCurrentContentObject->getLanguageObject($this->sLanguageId);
		if($oCurrentLanguageObject === null) {
			$oCurrentLanguageObject = new LanguageObject();
			$oCurrentLanguageObject->setLanguageId($this->sLanguageId);
			$oCurrentLanguageObject->setContentObject($oCurrentContentObject);
			$oCurrentLanguageObject->setData(null);
		}
		$oModuleInstance = $this->moduleInstanceByLanguageObject($oCurrentLanguageObject);
		$oWidget = null;
		if($oModuleInstance instanceof WidgetBasedFrontendModule) {
			$oWidget = $oModuleInstance->getWidget();
		} else {
			$oWidget = WidgetModule::getWidget('legacy_frontend_module', null, $oModuleInstance);
		}
		if($oWidget instanceof WidgetModule) {
			return array($oWidget->getModuleName(), $oWidget->getSessionKey());
		}
		return array($oWidget, null);
	}
	
	public function adminPreview($iObjectId) {
	  if($this->sLanguageId === null) {
		  $this->sLanguageId = AdminManager::getContentLanguage();
	  }
		$oCurrentContentObject = $this->contentObjectById($iObjectId);
		$oCurrentLanguageObject = $oCurrentContentObject->getLanguageObject($this->sLanguageId);
		$oModuleInstance = $this->moduleInstanceByLanguageObject($oCurrentLanguageObject);
		return array('preview_contents' => $this->getModuleContents($oModuleInstance, false));
	}
	
	public function adminMoveObject($iObjectId, $iSort, $sNewContainerName=null) {
		$iSort = (int) $iSort;
		$oContentObject = ContentObjectPeer::retrieveByPK((int) $iObjectId);
		$bSortAsc = $iSort > $oContentObject->getSort();
		if($sNewContainerName) {
			$oContentObject->setContainerName($sNewContainerName);
			$oContentObject->setSort($iSort);
			$oContentObject->setUpdatedAt(time());
		} else {
			$oContentObject->setSort($iSort);
			$oContentObject->setUpdatedAt(time());
		}
		$oContentObject->save();
		$this->adminSortObjects($oContentObject, $bSortAsc);
		return $oContentObject->getId();
	}
		
	private function adminSortObjects($oContentObject, $bSortAsc) {
		foreach($this->oPage->getObjectsForContainer($oContentObject->getContainerName(), null, $bSortAsc) as $i => $oObject) {
			$oObject->setSort($i);
			$oObject->save();
		}
	}
	
	public function adminRemoveObject($iObjectId) {
		return ContentObjectPeer::doDelete($iObjectId);
	}

	public function adminGetContainers() {
		$oIncluder = ResourceIncluder::namedIncluder(get_class($this));
		
		$oTemplate = $this->oPage->getTemplate();
		foreach($oTemplate->identifiersMatching('container', Template::$ANY_VALUE) as $oIdentifier) {
			$oTemplate->replaceIdentifierMultiple($oIdentifier, TagWriter::quickTag('span', array('class' => 'template-container-description'), StringPeer::getString('widget.page.template_container', null, null, array('container' => StringPeer::getString('widget.container.'.$oIdentifier->getValue(), null, $oIdentifier->getValue())), true)), null);
			$oTemplate->replaceIdentifier($oIdentifier, TagWriter::quickTag('ol', array('class' => 'template-container template-container-'.$oIdentifier->getValue(), 'data-container-name' => $oIdentifier->getValue(), 'data-container-string' => StringPeer::getString('container_name.'.$oIdentifier->getValue(), null, $oIdentifier->getValue()))));
		}
		
		foreach($oTemplate->identifiersMatching('addResourceInclude', Template::$ANY_VALUE) as $oIdentifier) {
			$oIncluder->addResourceFromTemplateIdentifier($oIdentifier);
		}
		
		$sCssContents = "";
		foreach($oIncluder->getAllIncludedResources() as $sIdentifier => $aResource) {
			if($aResource['resource_type'] === ResourceIncluder::RESOURCE_TYPE_CSS && !isset($aResource['ie_condition'])) {
				if(isset($aResource['media'])) {
					$sCssContents.= "@media {$aResource['media']} {";
				}
				if(isset($aResource['file_resource'])) {
					$sCssContents .= file_get_contents($aResource['file_resource']->getFullPath());
				} else {
					// Absolute link, requires fopen wrappers
					$sCssContents .= file_get_contents($aResource['location']);
				}
				if(isset($aResource['media'])) {
					$sCssContents.= "}";
				}
			}
		}
		
		$oParser = new CSSParser($sCssContents, Settings::getSetting("encoding", "browser", "utf-8"));
		$oCss = $oParser->parse();
		$this->cleanupCSS($oCss);
		
		$sTemplate = $oTemplate->render();
		
		$sTemplate = substr($sTemplate, strpos($sTemplate, '<body')+5);
		$sTemplate = substr($sTemplate, strpos($sTemplate, '>')+1);
		$sTemplate = substr($sTemplate, 0, strpos($sTemplate, '</body'));
		$oParser = new TagParser("<body>$sTemplate</body>");
		$oTag = $oParser->getTag();
		$this->cleanupContainerStructure($oTag);
		$oStyle = new HtmlTag('style');
		$oStyle->addParameters(array('scoped' => 'scoped'));
		$oStyle->appendChild(Template::htmlEncode($oCss->__toString()));
		$oTag->appendChild($oStyle);
		$sResult = $oTag->__toString();
		$sResult = substr($sResult, strpos($sResult, '<body>')+6);
		$sResult = substr($sResult, 0, strrpos($sResult, '</body>'));
		return $sResult;
	}
	
	private function cleanupContainerStructure($mTag, $oParent = null) {
		if(!($mTag instanceof HtmlTag)) {
			//Text node
			if(!$oParent->hasParameter('data-container-name') && $oParent->getParameter('class') != 'template-container-description') {
				$oParent->removeChild($mTag);
			}
			return;
		}
		foreach($mTag->getChildren() as $mChild) {
			$this->cleanupContainerStructure($mChild, $mTag);
		}
		if(count($mTag->getChildren()) === 0 && !$mTag->hasParameter('data-container-name') && ($oParent === null || $oParent->getParameter('class') != 'template-container-description')) {
			if($oParent === null) {
				return null;
			}
			$oParent->removeChild($mTag);
		} else if($mTag->hasParameter('data-container-name')) {
			$sStyle = $mTag->getParameter('style');
			if($sStyle === null) {
				$sStyle = '';
			}
			$mTag->setParameter('style', "margin:0!important;padding:0!important;$sStyle");
		}
	}
	
	private function cleanupCSS($oCss) {
		//Change selectors
		$sContainerClass = '.filled_modules';
		$aMatches;
		foreach($oCss->getAllSelectors() as $oSelector) {
			$aSelector = $oSelector->getSelector();
			foreach($aSelector as $iKey => $sSelector) {
				if(preg_match('/\\bhtml\\b.+\\bbody\\b/i', $sSelector, $aMatches, PREG_OFFSET_CAPTURE) === 1) {
					$aSelector[$iKey] = substr($sSelector, 0, $aMatches[0][1]).substr($sSelector, $aMatches[0][1]+strlen($aMatches[0][0]));
				}
				if(preg_match('/\\b(html|body)\\b/i', $sSelector, $aMatches, PREG_OFFSET_CAPTURE) === 1) {
					$aSelector[$iKey] = substr($sSelector, 0, $aMatches[0][1]).$sContainerClass.substr($sSelector, $aMatches[0][1]+strlen($aMatches[0][0]));
				} else {
					$aSelector[$iKey] = "$sContainerClass $sSelector";
				}
			}
			$oSelector->setSelector($aSelector);
		}
		
		//Change values
		foreach($oCss->getAllValues() as $mValue) {
			if($mValue instanceof CSSSize && !$mValue->isRelative()) {
				$mValue->setSize($mValue->getSize()/3);
			}
		}
		
		//Remove properties
		foreach($oCss->getAllRuleSets() as $oRuleSet) {
			$oRuleSet->removeRule('font-');
			$oRuleSet->removeRule('background-');
			$oRuleSet->removeRule('list-');
			$oRuleSet->removeRule('cursor');
		}
	}

	public function getAjax($aPath) {
		$sContainerName = $_REQUEST['container'];
		$iItemNumber = $_REQUEST['item_number']+0;
		foreach($this->oPage->getObjectsForContainer($sContainerName) as $iCount => $oContentObject) {
			if($iItemNumber === $iCount+1) {
				$iCount++;
			} else if($iItemNumber === $iCount) {
				$iCount--;
			}
			$oContentObject->setSort($iCount);
			$oContentObject->save();
		}
		$oDocument = new DOMDocument();
		$oRoot = $oDocument->createElement("success");
		$oDocument->appendChild($oRoot);
		return $oDocument;
	}
}