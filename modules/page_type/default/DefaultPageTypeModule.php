<?php
/**
	* @package modules.page_type
	*/
class DefaultPageTypeModule extends PageTypeModule {
	
	private $oFrontendTemplate;
	private $iModuleId;
	private $sContainerName;
	
	private static $COMPARISONS = array("eq" => "==",
																			"ne" => "!==",
																			"gt" => ">",
																			"gte" => ">=",
																			"lt" => "<",
																			"lte" => "<=",
																			"~" => "~",
																			"contains" => "contains",
																			"file_exists" => "file_exists");
	
	public function __construct(Page $oPage) {
		parent::__construct($oPage);
	}
	
	//Frontend stuff
	public function display(Template $oTemplate) {
		$this->oFrontendTemplate = $oTemplate;
		$this->iModuleId = 1;
		$this->oFrontendTemplate->replaceIdentifierCallback("container", $this, "fillContainer", Template::NO_HTML_ESCAPE);
	}
	
	public function fillContainer($oTemplateIdentifier, $iFlags) {
		if($oTemplateIdentifier->hasParameter('autofill')) {
			$oTemplate = new Template(TemplateIdentifier::constructIdentifier('container'), null, true);
			$oModule = FrontendModule::getModuleInstance($oTemplateIdentifier->getParameter('autofill'), $oTemplateIdentifier->getParameter('data'));
			$oTemplate->replaceIdentifierMultiple("container", $oModule->renderFrontend(), null, Template::NO_HTML_ESCAPE);
			$oTemplate->replaceIdentifierMultiple("custom_css", $oModule->getCssForFrontend());
			$oTemplate->replaceIdentifierMultiple("custom_js", $oModule->getJsForFrontend());
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
		$oPageContents = $oContentObject->getActiveLanguageObject();
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
		$oTemplate->replaceIdentifierMultiple("container", $sFrontentContents, null, Template::NO_HTML_ESCAPE);
		$this->oFrontendTemplate->replaceIdentifierMultiple("custom_css", $oModule->getCssForFrontend());
		$this->oFrontendTemplate->replaceIdentifierMultiple("custom_js", $oModule->getJsForFrontend());
		
		if(Session::getSession()->isAuthenticated() && Session::getSession()->getUser()->mayEditPageContents($oContentObject->getPage())) {
			//Print Edit link
			$sEditImage = TagWriter::quickTag("img", array('class' => 'mini_cms_fe_edit_button', 'src' => INT_IMAGES_DIR_FE.'/admin/edit_fe.gif', 'alt'=> StringPeer::getString("edit")));
			
			$oTag = TagWriter::quickTag("a", array("href" => LinkUtil::link(array('content', $oContentObject->getPage()->getId(), 'edit', $oContentObject->getId()), "BackendManager", array("content_language" => Session::language())), 'style' => 'z-index:1000;padding:0;margin:-6px 0 0 0;display:block;text-decoration:none;line-height:0;font-size:1px;clear:both;border:none;position:relative;', "title" => StringPeer::getString("content_edit"), 'class' => 'content_edit_link'), $sEditImage);
			$oTemplate->replaceIdentifierMultiple("container", $oTag);
		}
		return true;
	} // fillContainerWithModule()
	
	protected function getModuleContents($oModule) {
		return $oModule->renderFrontend();
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
	
	//Backend stuff
	private $oCurrentContentObject = null;
	private $oCurrentLanguageObject = null;
	protected $sMethod = "show";
	private $aAllPages = array();
	
	private $bBackupOverride = false;
	
	private $oModuleInstance = null;
	
	public function backendInit() {
		if(Manager::hasNextPathItem()) {
			$this->sMethod = Manager::usePath();
		}
		if(Manager::hasNextPathItem()) {
			$this->oCurrentContentObject = ContentObjectPeer::retrieveByPK(Manager::usePath());
		}
	}
	
	public function backendDisplay() {
		if($this->sMethod !== null) {
			switch($this->sMethod) {
				case "show":
					return $this->executeShow();
				case "edit":
					return $this->executeEdit();
			}
		}
	}

	private function executeShow() {
		$bMayEditContents = Session::getSession()->getUser()->mayEditPageContents($this->oPage);
		$oTemplate = $this->constructTemplate("content_show".($bMayEditContents ? "" : "_forbidden"));
		$oTemplate->replaceIdentifier('id', $this->oPage->getId());
		$oTemplate->replaceIdentifier('module_info_link', TagWriter::quickTag('a', array('title' => StringPeer::getString('module_info'), 'class' => 'info', 'href' => LinkUtil::link('content', null, array('get_module_info' => 'true')))));
		
		$oTemplate->replaceIdentifier("page_edit_link", LinkUtil::link(array('pages', $this->oPage->getId())));
		$oTemplate->replaceIdentifier("title", $this->oPage->getPageTitle(BackendManager::getContentEditLanguage()));
		$this->backendCustomJs = $this->constructTemplate("show.js");

		if($bMayEditContents) {
			$oPageTemplate = $this->oPage->getTemplate();
			$oTemplate->replaceIdentifier("template_name_used", $this->oPage->getTemplateNameUsed());
			$aContainers = $oPageTemplate->identifiersMatching("container", Template::$ANY_VALUE);
			asort($aContainers);
				
			foreach($aContainers as $oContainer) {
				if($oContainer->hasParameter('autofill')) {
					continue;
				}
				$sContainerName = $oContainer->getValue();
				$oContainerTemplate = $this->constructTemplate("content_container");
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
				$oContainerTemplate->replaceIdentifier("inherit_info", $oInheritedFrom !== null ? StringPeer::getString('container.inherit_message', null, null, array('pathname' => $oInheritedFrom->getName()), true) : null);
				$oContainerTemplate->replaceIdentifier("container_name", $sContainerName);
				$oContainerTemplate->replaceIdentifier("new_link", $this->backendLink(array($this->oPage->getId(), "edit", $sContainerName)));
				$aContentModuleNames = FrontendModule::listContentModules();
				$aAllowedItems = array();
				if($oContainer->hasParameter("allowed_modules")) {
					foreach(@ArrayUtil::trimStringsInArray(explode(",", $oContainer->getParameter("allowed_modules"))) as $sAllowedModuleName) {
						if(isset($aContentModuleNames[$sAllowedModuleName])) {
							$aAllowedItems[$sAllowedModuleName] = $aContentModuleNames[$sAllowedModuleName];
						}
					}
				} else {
					$aAllowedItems = $aContentModuleNames;
				}
				if($oContainer->hasParameter("disabled_modules")) {
					foreach(@ArrayUtil::trimStringsInArray(explode(",", $oContainer->getParameter("disabled_modules"))) as $sDisabledModuleName) {
						if(isset($aAllowedItems[$sDisabledModuleName])) {
							unset($aAllowedItems[$sDisabledModuleName]);
						}
					}
				}
				
				// order by displayName and add choose
				asort($aAllowedItems);
				$oContainerTemplate->replaceIdentifier("module_name_options", TagWriter::optionsFromArray($aAllowedItems, null, null));
				$oContainerTemplate->replaceIdentifier("container_name", $sContainerName);
				
				foreach($aObjects as $iCount => $oObject) {
					$oObjectTemplate = $this->constructTemplate("content_object");
					if($iCount === 0) {
						$oContainerTemplate->replaceIdentifierMultiple("arrow_up", TagWriter::quickTag('div', array('class' => 'up_arrow placeholder'), new Template("&nbsp;", null, true)));
					} else {
						$oContainerTemplate->replaceIdentifierMultiple("arrow_up", TagWriter::quickTag('div', array('class' => 'up_arrow', 'container' => $sContainerName, 'page_id' => $this->oPage->getId()), TagWriter::quickTag('img', array('src' => INT_IMAGES_DIR_FE.'/admin/arrow_up.png'))));
					}
					$oLanguageObject = $oObject->getActiveLanguageObjectBe();
					$oObjectTemplate->replaceIdentifier("title", $oObject->getContainerName());
					$oObjectTemplate->replaceIdentifier("object_type_name", $oObject->getObjectTypeName());
					$oObjectTemplate->replaceIdentifier("object_type", $oObject->getObjectType() === 'text' ? 'text' : 'external');
					$oObjectTemplate->replaceIdentifier("edit_link", $this->backendLink(array($this->oPage->getId(), "edit", $oObject->getId())));
					$oObjectTemplate->replaceIdentifier("action", $this->backendLink(array($this->oPage->getId(), "show", $oObject->getId())));
					if($oLanguageObject === null) {
						$oObjectTemplate->replaceIdentifier("content_info", TagWriter::quickTag('em', array(), StringPeer::getString('empty')));
					} else {
						$sFrontendModuleClass = FrontendModule::getClassNameByName($oObject->getObjectType());
						$mContentInfo = call_user_func(array($sFrontendModuleClass, 'getContentInfo'), $oLanguageObject);
						if($mContentInfo) {
							$oObjectTemplate->replaceIdentifier("content_info", $mContentInfo);
						}
					}
					$oContainerTemplate->replaceIdentifierMultiple("objects", $oObjectTemplate);
					$iCount++;
				}
				if($bHasNoObjects) {
					$oContainerTemplate->replaceIdentifierMultiple("objects", StringPeer::getString('objects.no_entries_message'));
				}
				$oTemplate->replaceIdentifierMultiple("containers", $oContainerTemplate);
			}
		}
		return $oTemplate;
	}

	private function newContentObject() {
		$this->oCurrentContentObject = new ContentObject();
		$this->oCurrentContentObject->setPage($this->oPage);
		$this->oCurrentContentObject->setContainerName(Manager::unusePath());
		$this->oCurrentContentObject->setObjectType(isset($_REQUEST['module_name']) ? $_REQUEST['module_name'] : '');
		$this->oCurrentContentObject->setSort(99); //High value so that the new object will appear at the bottom – until re-sorted, that is. If a new object is created before that, it will have a higher ID and thus appear even later in sort order
	}

	private function getLanguageObject() {
		if($this->oCurrentContentObject === null) {
			$this->newContentObject();
		}
		if($this->oCurrentLanguageObject !== null) {
			return $this->oCurrentLanguageObject;
		}
		$this->oCurrentLanguageObject = $this->oCurrentContentObject->getActiveLanguageObjectBe();
		if($this->oCurrentLanguageObject === null) {
			$this->oCurrentLanguageObject = new LanguageObject();
			$this->oCurrentLanguageObject->setLanguageId(BackendManager::getContentEditLanguage());
			$this->oCurrentLanguageObject->setContentObject($this->oCurrentContentObject);
			$this->oCurrentLanguageObject->setData(null);
		}
		return $this->oCurrentLanguageObject;
	}
	
	private function getFrontendModuleInstance() {
		if($this->oModuleInstance === null) {
			$this->oModuleInstance = FrontendModule::getModuleInstance($this->oCurrentContentObject->getObjectType(), $this->getLanguageObject());
		}
		return $this->oModuleInstance;
	}

	private function executeEdit() {
		$oLanguageObject = $this->getLanguageObject();
		$aLanguageObjectRevisions = LanguageObjectHistoryPeer::getHistoryByLanguageObject($oLanguageObject);
		$oLanguageObject->revertToHistory(@$_REQUEST['language_object_revision_id']);
		
		$oModule = $this->getFrontendModuleInstance();
		$this->backendCustomJs = $oModule->getJsForBackend();
		
		$oTemplate = $this->constructTemplate('content_edit');
		$oTemplate->replaceIdentifier('module_info_link', TagWriter::quickTag('a', array('title' => StringPeer::getString('module_info'), 'class' => 'info', 'href' => LinkUtil::link('content', null, array('get_module_info' => 'true')))));
		$oTemplate->replaceIdentifier('id', $this->oPage->getId());
		$oTemplate->replaceIdentifier('page_edit_link', LinkUtil::link(array('pages', $this->oPage->getId())));
		$oTemplate->replaceIdentifier('content_edit_link', LinkUtil::link(array('content', $this->oPage->getId())));
		$oTemplate->replaceIdentifier('is_new', $this->oCurrentContentObject->isNew());
		if($this->oCurrentContentObject->isNew()) {
			$oTemplate->replaceIdentifier("action", $this->backendLink(array($this->oPage->getId(), "edit", $this->oCurrentContentObject->getContainerName())));
		} else {
			$oTemplate->replaceIdentifier("action", $this->backendLink(array($this->oPage->getId(), "edit", $this->oCurrentContentObject->getId())));
			$oTemplate->replaceIdentifier('timestamp', $oLanguageObject->getUpdatedAtTimestamp());
			if($oModule->getModuleName() === 'text') {
				$oHistoryTempl = $this->constructTemplate('language_revision');
				if($this->bBackupOverride) {
					$oHistoryTempl->replaceIdentifier("readonly_history_override", true);
				}
				$oTemplate->replaceIdentifier("language_revision", $oHistoryTempl);
			}
		}
		if($oLanguageObject->getContentObject()->getObjectType() === 'text') {
			$oTemplate->replaceIdentifier("document_upload_link", LinkUtil::link('documents', 'BackendManager', array('action' => 'create')));
		}
		$oTemplate->replaceIdentifier("show_url", $this->backendLink(array($this->oPage->getId(), "show")));
		$oTemplate->replaceIdentifier("content", $oModule->renderBackend(), null, Template::NO_HTML_ESCAPE);
		
		//Condition-management
		$sComparatorValue = null;
		if($this->oCurrentContentObject->getConditionSerialized() !== null) {
			$oConditionTemplate = unserialize(stream_get_contents($this->oCurrentContentObject->getConditionSerialized()));
			$oIfIdentifier = $oConditionTemplate->identifiersMatching('if', Template::$ANY_VALUE);
			$oIfIdentifier = $oIfIdentifier[0];
			$oTemplate->replaceIdentifier("comparison_1", $oIfIdentifier->getParameter('1'));
			$oTemplate->replaceIdentifier("comparison_2", $oIfIdentifier->getParameter('2'));
			$oTemplate->replaceIdentifier("toggler_style", $oIfIdentifier->getParameter('1') == '' ? '' : ' open');
			$sComparatorValue = $oIfIdentifier->getValue();
		}
		$oTemplate->replaceIdentifier("comparator_options", TagWriter::optionsFromArray(self::$COMPARISONS, $sComparatorValue, null, null));
		
		// handle revisions select
		if(!$oLanguageObject->isNew() && count($aLanguageObjectRevisions) > 0) {
			$sSelected = null;
			$sDefaultOptionString = 'choose';
			if(isset($_REQUEST['language_object_revision_id']) && $_REQUEST['language_object_revision_id'] !== '') {
				$sSelected = (int)$_REQUEST['language_object_revision_id'];
				$sDefaultOptionString = 'revert_to_current';
			} 
			$oTemplate->replaceIdentifier("language_object_revisions", TagWriter::optionsFromObjects($aLanguageObjectRevisions, 'getRevision', 'getName', $sSelected, array( '' => StringPeer::getString($sDefaultOptionString))));
		}
		
		$oTemplate->replaceIdentifier("page_title", $this->oPage->getLinkText());		
		$oTemplate->replaceIdentifier("module_name", $this->oCurrentContentObject->getObjectType());	 
		$oTemplate->replaceIdentifier("container_name", $this->oCurrentContentObject->getContainerName());	 
		return $oTemplate;
	}
	
	public function delete() {
		if(!Session::getSession()->getUser()->mayEditPageContents($this->oPage)) {
			return;
		}
		if($this->oCurrentContentObject !== null && $this->oCurrentContentObject->getActiveLanguageObjectBe() !== null) {
			$this->oCurrentContentObject->getActiveLanguageObjectBe()->delete();
			foreach(ReferencePeer::getReferencesFromObject($this->oCurrentContentObject->getActiveLanguageObjectBe()) as $oReference) {
				$oReference->delete();
			}
		}
		$oLanguageObjects = $this->oCurrentContentObject->getLanguageObjects();
		// should LanguageObjectHistory be deleted too?
		if(count($oLanguageObjects) === 0) {
			$this->oCurrentContentObject->delete();
		}
	}
	
	public function backendSave($sRedirectUrl=null) {
		if(Manager::isAjaxRequest()) return;

		$oLanguageObjectHistory = null;
		if(!Session::getSession()->getUser()->mayEditPageContents($this->oPage)) {
			return;
		}
		
		$iTimestamp = (int)$_POST['timestamp'];
		
		$oLanguageObject = $this->getLanguageObject();
		//Condition-management
		if(!$_POST['comparison_1']) {
			$this->oCurrentContentObject->setConditionSerialized(null);
		} else {
			$oTemplate = new Template("", null, true);
			$aTemplateContents = array();
			$oIf = new TemplateIdentifier("if", $_POST['comparator'], array(), $oTemplate);
			$oIf->setParameter('1', $_POST['comparison_1']);
			$oIf->setParameter('2', $_POST['comparison_2']);
			$aTemplateContents[] = $oIf;
			$aTemplateContents[] = "visible";
			$aTemplateContents[] = new TemplateIdentifier("endIf", null, array(), $oTemplate);
			$oTemplate = new Template($aTemplateContents, null, true);
			$this->oCurrentContentObject->setConditionSerialized(serialize($oTemplate));
		}
		unset($_POST['comparison_1']);
		unset($_POST['comparison_2']);
		unset($_POST['comparator']);
		unset($_POST['timestamp']);
		
		//Look at the timestamp
		if(!$oLanguageObject->isNew() && $iTimestamp !== $oLanguageObject->getUpdatedAtTimestamp()) {
			$oFlash = Flash::getFlash();
			$oFlash->unfinishReporting();
			$oFlash->addMessage('page_content_changed_since');
			$oFlash->finishReporting();
			
			//Set all the properties correctly
			$this->bBackupOverride = true;
		}
		
		//Save history
		if(isset($_POST['create_history']) && !$oLanguageObject->isNew()) {
			$oLanguageObjectHistory = new LanguageObjectHistory();
			$oLanguageObjectHistory->setData(clone $oLanguageObject->getData());
		}
		
		//Save data
		$oModule = $this->getFrontendModuleInstance();
		$oLanguageObject->setData($oModule->getSaveData());
		
		//Write object to db
		if(!Flash::noErrors()) {
			return;
		}
		$this->oCurrentContentObject->save();
		$oLanguageObject->save();
		ReferencePeer::saveUnsavedReferences();
		if($oLanguageObjectHistory !== null) {
			$oLanguageObjectHistory->setObjectId($oLanguageObject->getObjectId());
			$oLanguageObjectHistory->setLanguageId($oLanguageObject->getLanguageId());
			$oLanguageObjectHistory->save();
		}
		if($sRedirectUrl === null) {
			$sRedirectUrl = $this->backendLink(array($this->oPage->getId(), "edit", $this->oCurrentContentObject->getId()));
		}
		LinkUtil::redirect($sRedirectUrl);
	}
	
	//Admin stuff
	public function adminListPossibleFrontendModules() {
		return FrontendModule::listContentModules();
	}
	
	public function adminListFilledFrontendModules() {
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
				$oLanguageObject = $oObject->getActiveLanguageObjectBe();
				if($oLanguageObject === null) {
					$aResult[$sContainerName]['contents'][$oObject->getId()]['content_info'] = StringPeer::getString('empty');
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
	
	public function adminAddObjectToContainer($sContainerName, $sObjectType, $iSort) {
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
		$sLanguageId = AdminManager::getContentLanguage();
		$this->oCurrentContentObject = ContentObjectPeer::retrieveByPK($iObjectId);
		$this->oCurrentLanguageObject = $this->oCurrentContentObject->getLanguageObject($sLanguageId);
		if($this->oCurrentLanguageObject === null) {
			$this->oCurrentLanguageObject = new LanguageObject();
			$this->oCurrentLanguageObject->setLanguageId($sLanguageId);
			$this->oCurrentLanguageObject->setContentObject($this->oCurrentContentObject);
			$this->oCurrentLanguageObject->setData(null);
		}
		$this->oModuleInstance = FrontendModule::getModuleInstance($this->oCurrentContentObject->getObjectType(), $this->oCurrentLanguageObject);
		$oWidget = null;
		if($this->oModuleInstance instanceof WidgetBasedFrontendModule) {
			$oWidget = $this->oModuleInstance->getWidget();
		} else {
			$oWidget = WidgetModule::getWidget('legacy_frontend_module', null, $this->oModuleInstance);
		}
		return array($oWidget->getModuleName(), $oWidget->getSessionKey());
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
		$this->sortObjects($oContentObject, $bSortAsc);
		return $oContentObject->getId();
	}
		
	public function sortObjects($oContentObject, $bSortAsc) {
		foreach($this->oPage->getObjectsForContainer($oContentObject->getContainerName(), null, $bSortAsc) as $i => $oObject) {
			$oObject->setSort($i);
			$oObject->save();
		}
	}
	
	public function removeObject($iObjectId) {
		return ContentObjectPeer::doDelete($iObjectId);
	}

	public function adminGetContainers() {
		$oIncluder = ResourceIncluder::namedIncluder(get_class($this));
		
		$oTemplate = $this->oPage->getTemplate();
		foreach($oTemplate->identifiersMatching('container', Template::$ANY_VALUE) as $oIdentifier) {
			$oTemplate->replaceIdentifierMultiple($oIdentifier, TagWriter::quickTag('span', array('class' => 'template-container-description'), StringPeer::getString('widget.page.template_container', null, null, array('container' => $oIdentifier->getValue()), true)), null);
			$oTemplate->replaceIdentifier($oIdentifier, TagWriter::quickTag('ol', array('class' => 'template-container template-container-'.$oIdentifier->getValue(), 'data-container-name' => $oIdentifier->getValue())));
		}
		
		foreach($oTemplate->identifiersMatching('addResourceInclude', Template::$ANY_VALUE) as $oIdentifier) {
			$oIncluder->addResourceFromTemplateIdentifier($oIdentifier);
		}
		
		$sCssContents = "";
		foreach($oIncluder->getAllIncludedResources() as $sIdentifier => $aResource) {
			if($aResource['resource_type'] === ResourceIncluder::RESOURCE_TYPE_CSS) {
				if(isset($aResource['file_resource'])) {
					$sCssContents .= file_get_contents($aResource['file_resource']->getFullPath());
				} else {
					// Absolute link, requires fopen wrappers
					$sCssContents .= file_get_contents($aResource['location']);
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
		if(count($mTag->getChildren()) === 0 && !$mTag->hasParameter('data-container-name') && $oParent->getParameter('class') != 'template-container-description') {
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