<?php
/**
	* @package modules.page_type
	*/
require_once("cssparser/CSSParser.php");

class DefaultPageTypeModule extends PageTypeModule {
	
	private $oFrontendTemplate;
	private $iModuleId;
	private $sContainerName;
	protected $sLanguageId;
	private $bIsPreview;
	
	public function __construct(Page $oPage = null, NavigationItem $oNavigationItem = null, $sLanguageId = null) {
		parent::__construct($oPage, $oNavigationItem);
		$this->sLanguageId = $sLanguageId;
	}
	
	//Frontend stuff
	public function display(Template $oTemplate, $bIsPreview = false) {
		$this->bIsPreview = $bIsPreview;
		if($this->bIsPreview) {
			ResourceIncluder::defaultIncluder()->addResource('preview/preview-default.css');
			ResourceIncluder::defaultIncluder()->addResource('preview/jquery.ba-resize.min.js');
		}
		if($this->sLanguageId === null) {
			$this->sLanguageId = $this->bIsPreview ? AdminManager::getContentLanguage() : Session::language();
		}
		$this->oFrontendTemplate = $oTemplate;
		$this->iModuleId = 1;
		$this->oFrontendTemplate->replaceIdentifierCallback("autofill", $this, "fillAutofill", Template::NO_HTML_ESCAPE);
		$this->oFrontendTemplate->replaceIdentifierCallback("container", $this, "fillContainer", Template::NO_HTML_ESCAPE);
	}
	
	public function fillAutofill($oTemplateIdentifier, $iFlags) {
		$oModule = FrontendModule::getModuleInstance($oTemplateIdentifier->getValue(), $oTemplateIdentifier->getParameter('data'));
		$mResult = $oModule->renderFrontend();
		if(($sCss = $oModule->getCssForFrontend()) !== null) {
			ResourceIncluder::defaultIncluder()->addCustomCss($sCss);
		}
		if(($sJs = $oModule->getJsForFrontend()) !== null) {
			ResourceIncluder::defaultIncluder()->addCustomJs($sJs);
		}
		return $mResult;
	}
	
	public function getWords() {
		$aWords = array();

		$aObjects = $this->oPage->getContentObjects();
		foreach($aObjects as $oObject) {
			$oLanguageObject = $oObject->getLanguageObject();
			if($oLanguageObject === null) {
				continue;
			}
			$oModule = FrontendModule::getModuleInstance($oObject->getObjectType(), $oLanguageObject);
			$aWords = array_merge($aWords, $oModule->getWords());
		}
		return $aWords;
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
		if($this->bIsPreview) {
			$oModule = FrontendModule::getModuleInstance($oContentObject->getObjectType(), $oPageContents->getDraft(), $iModuleId);
		} else {
			$oModule = FrontendModule::getModuleInstance($oContentObject->getObjectType(), $oPageContents, $iModuleId);
		}
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
			ResourceIncluder::defaultIncluder()->addCustomCss($sCss, ResourceIncluder::PRIORITY_LAST);
		}
		if(($sJs = $oModule->getJsForFrontend()) !== null) {
			ResourceIncluder::defaultIncluder()->addCustomJs($sJs, ResourceIncluder::PRIORITY_LAST);
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
			if($sModuleName::isDynamic()) {
				$bIsDynamic = true;
				$aAllowedParams = array_merge($aAllowedParams, $sModuleName::acceptedRequestParams());
			}
		}
	}

	//Admin stuff
	private $aContentObjects = array();
	
	private function contentObjectById($iObjectId) {
		if(!isset($this->aContentObjects[$iObjectId])) {
			$this->aContentObjects[$iObjectId] = ContentObjectPeer::retrieveByPK($iObjectId);
		}
		return $this->aContentObjects[$iObjectId];
	}
	
	private function backendModuleInstanceByLanguageObject($oLanguageObject) {
		return FrontendModule::getModuleInstance($oLanguageObject->getContentObject()->getObjectType(), $oLanguageObject->getDraft());
	}
	
	public function adminListPossibleFrontendModules() {
		$aContainers = $this->oPage->getTemplate()->identifiersMatching("container", Template::$ANY_VALUE);
		$bContentIsInherited = false;
		foreach($aContainers as $oContainer) {
			if(BooleanParser::booleanForString($oContainer->getParameter('inherit'))) {
				$bContentIsInherited = true;
				break;
			}
		}
		return FrontendModule::listContentModules($bContentIsInherited);
	}
	
	public function adminListFilledFrontendModules() {
		if($this->sLanguageId === null) {
			$this->sLanguageId = AdminManager::getContentLanguage();
		}
		$aContainers = $this->oPage->getTemplate()->identifiersMatching("container", Template::$ANY_VALUE);
		asort($aContainers);
		$aResult = array();

		foreach($aContainers as $oContainer) {
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
			$aResult[$sContainerName]['contents'] = array();
			foreach($aObjects as $oObject) {
				$aResult[$sContainerName]['contents'][] = $this->paramsForObject($oObject);
			}
		}
		return $aResult;
	}

	private function paramsForObject($oObject) {
		$aObject = array('id' => $oObject->getId());
		$aObject['language_objects'] = array();
		
		foreach(LanguageQuery::create()->orderById()->find() as $oLanguage) {
			$aLanguageInfo = array();
			$oLanguageObject = $oObject->getLanguageObject($oLanguage->getId());
			$aLanguageInfo['exists_in_language'] = $oLanguageObject !== null;
			if($oLanguageObject === null) {
				$oLanguageObject = LanguageObjectHistoryQuery::create()->filterByLanguageId($oLanguage->getId())->filterByObjectId($oObject->getId())->sort()->findOne();
				$aLanguageInfo['is_draft'] = $oLanguageObject !== null;
			} else {
				$aLanguageInfo['is_draft'] = $oLanguageObject->getHasDraft();
			}
			if($oLanguageObject !== null) {
				$sFrontendModuleClass = FrontendModule::getClassNameByName($oObject->getObjectType());
				$mContentInfo = $sFrontendModuleClass::getContentInfo($oLanguageObject);
				$aLanguageInfo['content_info'] = $mContentInfo;
			} else {
				$aLanguageInfo['content_info'] = null;
			}
			$aObject['language_objects'][$oLanguage->getId()] = $aLanguageInfo;
		}
		$aObject['object_type'] = $oObject->getObjectType();
		$aObject['has_condition'] = $oObject->getConditionSerialized() !== null;
		$aObject['object_type_display_name'] = FrontendModule::getDisplayNameByName($oObject->getObjectType());
		return $aObject;
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
		return $this->paramsForObject($oContentObject);
	}
	
	public function adminEdit($iObjectId, $sLanguageId = null) {
		if($sLanguageId !== null) {
			$this->sLanguageId = $sLanguageId;
		}
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
		
		$oModuleInstance = $this->backendModuleInstanceByLanguageObject($oCurrentLanguageObject);
		$oWidget = WidgetModule::getWidget('language_object_control', null, $oCurrentLanguageObject, $oModuleInstance);
		return $oWidget->getSessionKey();
	}
	
	public function adminPreview($iObjectId) {
		if($this->sLanguageId === null) {
			$this->sLanguageId = AdminManager::getContentLanguage();
		}
		$oCurrentContentObject = $this->contentObjectById($iObjectId);
		$oCurrentLanguageObject = $oCurrentContentObject->getLanguageObject($this->sLanguageId);
		
		//Some frontend modules use this
		FrontendManager::$CURRENT_PAGE = $oCurrentContentObject->getPage();
		//Some frontend modules generate links into the current manager – those need to be correct
		PreviewManager::setTemporaryManager();
		$oModuleInstance = $this->backendModuleInstanceByLanguageObject($oCurrentLanguageObject);
		$aResult = array('preview_contents' => $this->getModuleContents($oModuleInstance, false));
		PreviewManager::revertTemporaryManager();
		return $aResult;
	}
	
	public function adminMoveObject($iObjectId, $iSort, $sNewContainerName=null) {
		$iSort = (int) $iSort;
		$oContentObject = ContentObjectPeer::retrieveByPK((int) $iObjectId);
		// fix if content object is deleted in trash, it is moved at the same time but not found anymore!
		if($oContentObject === null) {
			return;
		}
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

	public function adminDropDraft($iObjectId) {
		$oCurrentContentObject = $this->contentObjectById($iObjectId);
		if($this->sLanguageId === null) {
			$this->sLanguageId = AdminManager::getContentLanguage();
		}
		$oCurrentLanguageObject = $oCurrentContentObject->getLanguageObject($this->sLanguageId);
		if($oCurrentLanguageObject === null) {
			///In this case, we have to remove all stored history objects in order to remove the draft status
			return LanguageObjectHistoryQuery::create()->filterByContentObject($oCurrentContentObject)->delete();
		}
		$oCurrentLanguageObject->setHasDraft(false);
		return $oCurrentLanguageObject->save();
	}
	
	public function adminRemoveObject($iObjectId, $bForce = false) {
		$oCurrentContentObject = $this->contentObjectById($iObjectId);
		if(!Session::getSession()->getUser()->mayEditPageStructure($oCurrentContentObject->getPage())) {
			return false;
		} 
		if($bForce) {
			return ContentObjectPeer::doDelete($iObjectId);
		}
		if($this->sLanguageId === null) {
			$this->sLanguageId = AdminManager::getContentLanguage();
		}
		$oCurrentLanguageObject = $oCurrentContentObject->getLanguageObject($this->sLanguageId);
		if($oCurrentLanguageObject === null) {
			return true;
		}
		$oCurrentLanguageObject->newHistory(false)->save();
		$oCurrentLanguageObject->delete();
		return true;
	}

	public function adminGetContainers() {
		$oTemplate = $this->oPage->getTemplate();
		foreach($oTemplate->identifiersMatching('container', Template::$ANY_VALUE) as $oIdentifier) {
			$oTemplate->replaceIdentifierMultiple($oIdentifier, TagWriter::quickTag('span', array('class' => 'template-container-description'), StringPeer::getString('wns.page.template_container', null, null, array('container' => StringPeer::getString('template_container.'.$oIdentifier->getValue(), null, $oIdentifier->getValue())), true)), null);
			$oTemplate->replaceIdentifier($oIdentifier, TagWriter::quickTag('ol', array('class' => 'template-container template-container-'.$oIdentifier->getValue(), 'data-container-name' => $oIdentifier->getValue(), 'data-container-string' => StringPeer::getString('container_name.'.$oIdentifier->getValue(), null, $oIdentifier->getValue()))));
		}
		
		$bUseParsedCss = Settings::getSetting('admin', 'use_parsed_css_in_config', true);
		$oStyle = null;
		
		if($bUseParsedCss) {
			$sTemplateName = $this->oPage->getTemplateNameUsed().Template::$SUFFIX;
			$sCacheKey = 'parsed-css-'.$sTemplateName;
			$oCssCache = new Cache($sCacheKey, DIRNAME_PRELOAD);

			$sCssContents = "";
			if(!$oCssCache->cacheFileExists() || $oCssCache->isOutdated(ResourceFinder::create(array(DIRNAME_TEMPLATES, $sTemplateName)))) {
				$oIncluder = new ResourceIncluder();
				foreach($oTemplate->identifiersMatching('addResourceInclude', Template::$ANY_VALUE) as $oIdentifier) {
					$oIncluder->addResourceFromTemplateIdentifier($oIdentifier);
				}
				foreach($oIncluder->getAllIncludedResources() as $sIdentifier => $aResource) {
					if($aResource['resource_type'] === ResourceIncluder::RESOURCE_TYPE_CSS && !isset($aResource['ie_condition']) && !isset($aResource['frontend_specific'])) {
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
				$sCssContents = Template::htmlEncode($oCss->__toString());
				$oCssCache->setContents($sCssContents);
			} else {
				$sCssContents = $oCssCache->getContentsAsString();
			}
			
			$oStyle = new HtmlTag('style');
			$oStyle->addParameters(array('scoped' => 'scoped'));
			$oStyle->appendChild($sCssContents);
		}
		
		$sTemplate = $oTemplate->render();
		
		$sTemplate = substr($sTemplate, strpos($sTemplate, '<body')+5);
		$sTemplate = substr($sTemplate, strpos($sTemplate, '>')+1);
		$sTemplate = substr($sTemplate, 0, strpos($sTemplate, '</body'));
		$oParser = new TagParser("<body>$sTemplate</body>");
		$oTag = $oParser->getTag();
		$this->cleanupContainerStructure($oTag);
		if($bUseParsedCss) {
			$oTag->appendChild($oStyle);
		}
		$sResult = $oTag->__toString();
		$sResult = substr($sResult, strpos($sResult, '<body>')+6);
		$sResult = substr($sResult, 0, strrpos($sResult, '</body>'));
		return array('html' => $sResult, 'css_parsed' => $bUseParsedCss);
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
		foreach($oCss->getAllDeclarationBlocks() as $oBlock) {
			$aSelectors = $oBlock->getSelectors();
			foreach($aSelectors as $iKey => $oSelector) {
				$sSelector = $oSelector->getSelector();
				if(preg_match('/\\bhtml\\b.+\\bbody\\b/i', $sSelector, $aMatches, PREG_OFFSET_CAPTURE) === 1) {
					$sSelector = substr($sSelector, 0, $aMatches[0][1]).substr($sSelector, $aMatches[0][1]+strlen($aMatches[0][0]));
				}
				if(preg_match('/\\b(html|body)\\b/i', $sSelector, $aMatches, PREG_OFFSET_CAPTURE) === 1) {
					$sSelector = substr($sSelector, 0, $aMatches[0][1]).$sContainerClass.substr($sSelector, $aMatches[0][1]+strlen($aMatches[0][0]));
				} else {
					$sSelector = "$sContainerClass $sSelector";
				}
				$oSelector->setSelector($sSelector);
			}
		}
		
		//Change values
		foreach($oCss->getAllValues(null, true) as $mValue) {
			if($mValue instanceof CSSSize && $mValue->isSize() && !$mValue->isRelative()) {
				$mValue->setSize($mValue->getSize()/3);
			}
		}
		
		//Remove properties
		foreach($oCss->getAllRuleSets() as $oRuleSet) {
			$oRuleSet->removeRule('font-');
			$oRuleSet->removeRule('background-');
			$oRuleSet->removeRule('list-');
			$oRuleSet->removeRule('cursor');
			$oRuleSet->removeRule('z-index');
		}
	}
}
