<?php
/**
	* @package modules.page_type
	*/

class DefaultPageTypeModule extends PageTypeModule {

	protected $sLanguageId;

	private $oFillHelper;

	public function __construct(Page $oPage = null, NavigationItem $oNavigationItem = null, $sLanguageId = null) {
		parent::__construct($oPage, $oNavigationItem);
		$this->sLanguageId = $sLanguageId;
		$this->oFillHelper = new PageObjectFillHelper($oPage, $oNavigationItem);
	}

	//Frontend stuff
	public function display(Template $oTemplate, $bIsPreview = false) {
		if($bIsPreview) {
			ResourceIncluder::defaultIncluder()->addResource('preview/jquery.ba-resize.min.js');
		}
		if($this->sLanguageId === null) {
			$this->sLanguageId = $bIsPreview ? AdminManager::getContentLanguage() : Session::language();
		}
		$this->oFillHelper->fill($this->sLanguageId, $oTemplate, $bIsPreview);
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

	public function acceptedRequestParams($aModulesToCheck = null) {
		$aResult = array();
		foreach($this->oPage->getContentObjects() as $oContentObject) {
			if($aModulesToCheck && !in_array($oContentObject->getContainerName(), $aModulesToCheck)) {
				continue;
			}
			$sModuleName = Module::getClassNameByTypeAndName(FrontendModule::getType(), $oContentObject->getObjectType());
			if(class_exists($sModuleName, true)) {
				$aResult = array_merge($aResult, $sModuleName::acceptedRequestParams());
			}
		}
		return $aResult;
	}

	//Admin stuff
	private $aContentObjects = array();

	private function contentObjectById($iObjectId) {
		if(!isset($this->aContentObjects[$iObjectId])) {
			$this->aContentObjects[$iObjectId] = ContentObjectQuery::create()->findPk($iObjectId);
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

		// Create a list of all containers (including unused)
		$aContainers = $this->oPage->getTemplate()->identifiersMatching("container", Template::$ANY_VALUE);
		$aContainers = array_map(function($oContainer) {
			return $oContainer->getValue();
		}, $aContainers);
		$aContainers[] = ContentObject::UNUSED_OBJECTS_KEY;
		asort($aContainers);

		// Create the result (an object whose key is the name of the container [or “unused_objects”] and whose value is an object with the “contents” property for all objects)
		$aResult = array();
		foreach($aContainers as $sContainerName) {
			$aResult[$sContainerName] = new StdClass();
			$aResult[$sContainerName]->contents = array();
		}

		// Add all objects to their respective containers
		$aObjects = ContentObjectQuery::create()->filterByPage($this->oPage)->orderByContainerName()->orderBySort()->find();
		foreach($aObjects as $oObject) {
			$sContainerName = $oObject->getContainerName();
			if(!isset($aResult[$sContainerName])) {
				$sContainerName = ContentObject::UNUSED_OBJECTS_KEY;
			}
			$aResult[$sContainerName]->contents[] = $this->paramsForObject($oObject);
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
				if(class_exists($sFrontendModuleClass, true)) {
					$mContentInfo = $sFrontendModuleClass::getContentInfo($oLanguageObject);
				} else {
					$mContentInfo = null;
				}
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
		$oContentObject = new ContentObject();
		$oContentObject->setPageId($this->oPage->getId());
		$oContentObject->sortIntoNew($sContainerName, $iSort);
		$oContentObject->setObjectType($sObjectType);
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
		$oResult = new stdClass();
		$oResult->control_session_key = $oWidget->getSessionKey();
		$oResult->type = $oCurrentContentObject->getObjectType();
		return $oResult;
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
		$aResult = array('preview_contents' => PageObjectFillHelper::getModuleContents($oModuleInstance, false, true));
		PreviewManager::revertTemporaryManager();
		return $aResult;
	}

	public function adminMoveObject($iObjectId, $iSort, $sNewContainerName=null) {
		$iSort = (int) $iSort;
		$oContentObject = ContentObjectQuery::create()->findPk((int) $iObjectId);
		// fix if content object is deleted in trash, it is moved at the same time but not found anymore!
		if($oContentObject === null) {
			return;
		}
		if($sNewContainerName) {
			$oContentObject->sortIntoNew($sNewContainerName, $iSort);
		} else {
			$oContentObject->sortInsideExisting($iSort);
		}
		$oContentObject->save();
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
			$oCurrentContentObject->sortIntoNew();
			$oCurrentContentObject->delete();
			return true;
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
			$oInheritedFrom = null;
			$sContainerName = $oIdentifier->getValue();
			if(BooleanParser::booleanForString($oIdentifier->getParameter('inherit'))) {
				$oInheritedFrom = $this->oPage;
				$iInheritedObjectCount = 0;
				while ($iInheritedObjectCount === 0 && ($oInheritedFrom = $oInheritedFrom->getParent()) !== null) {
					$iInheritedObjectCount = $oInheritedFrom->countObjectsForContainer($sContainerName);
				}
			}
			$sInheritedFrom = $oInheritedFrom ? $oInheritedFrom->getName() : '';

			$aTagParams = array('class' => 'template-container template-container-'.$sContainerName, 'data-container-name' => $sContainerName, 'data-container-string' => TranslationPeer::getString('container_name.'.$sContainerName, null, $sContainerName), 'data-inherited-from' => $sInheritedFrom);
			$oContainerTag = TagWriter::quickTag('ol', $aTagParams);

			$mInnerTemplate = new Template(TemplateIdentifier::constructIdentifier('content'), null, true);

			//Replace container info
			//…name
			$mInnerTemplate->replaceIdentifierMultiple('content', TagWriter::quickTag('div', array('class' => 'template-container-description'), TranslationPeer::getString('wns.page.template_container', null, null, array('container' => TranslationPeer::getString('template_container.'.$sContainerName, null, $sContainerName)), true)));
			//…additional info
			$mInnerTemplate->replaceIdentifierMultiple('content', TagWriter::quickTag('div', array('class' => 'template-container-info')));
			//…tag
			$mInnerTemplate->replaceIdentifierMultiple('content', $oContainerTag);

			//Replace actual container
			$oTemplate->replaceIdentifier($oIdentifier, $mInnerTemplate);
		}

		$bUseParsedCss = Settings::getSetting('admin', 'use_parsed_css_in_config', true);
		$oStyle = null;

		if($bUseParsedCss) {
			$sTemplateName = $this->oPage->getTemplateNameUsed().Template::$SUFFIX;
			$sCacheKey = 'parsed-css-'.$sTemplateName;
			$oCssCache = new Cache($sCacheKey, DIRNAME_PRELOAD);

			$sCssContents = "";
			if(!$oCssCache->entryExists() || $oCssCache->isOutdated(ResourceFinder::create(array(DIRNAME_TEMPLATES, $sTemplateName)))) {
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

				$oParser = new Sabberworm\CSS\Parser($sCssContents, Sabberworm\CSS\Settings::create()->withDefaultCharset(Settings::getSetting("encoding", "browser", "utf-8")));
				$oCss = $oParser->parse();
				$this->cleanupCSS($oCss);
				$sCssContents = Template::htmlEncode($oCss->render(Sabberworm\CSS\OutputFormat::createCompact()));
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
			if(!$oParent->hasParameter('data-container-name') && !StringUtil::startsWith($oParent->getParameter('class'), 'template-container-')) {
				$oParent->removeChild($mTag);
			}
			return;
		}
		foreach($mTag->getChildren() as $mChild) {
			$this->cleanupContainerStructure($mChild, $mTag);
		}
		if(count($mTag->getChildren()) === 0 && !$mTag->hasParameter('data-container-name') && ($oParent === null || !StringUtil::startsWith($oParent->getParameter('class'), 'template-container-')) && !StringUtil::startsWith($mTag->getParameter('class'), 'template-container-')) {
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
		$aMatches = null;
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
			$oRuleSet->removeRule('z-index');
		}
	}
}
