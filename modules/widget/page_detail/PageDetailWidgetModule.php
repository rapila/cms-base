<?php
/**
 * @package modules.widget
 */
class PageDetailWidgetModule extends PersistentWidgetModule {
	
	private $iPageId = null;
	private $oPage;
	const PAGE_PROPERTY_NS = 'page_property.';
		
	public function doWidget() {
		return $this->constructTemplate('edit');
	}
	
	public function setPageId($iPageId) {
		$this->iPageId = (int) $iPageId;
		Session::getSession()->setAttribute('persistent_page_id', $this->iPageId);
	}
	
	public function getPageData() {
		$oPage = PagePeer::retrieveByPK($this->iPageId);
		$aResult = $oPage->toArray(BasePeer::TYPE_PHPNAME, false);
		
		// addition related page fields
		$aResult['PageHref'] = LinkUtil::absoluteLink(LinkUtil::link($oPage->getFullPathArray(), 'FrontendManager')); 
			
		// page properties are displayed if added to template
		try {
			$mAvailableProperties = $this->getAvailablePageProperties($oPage);
			if(count($mAvailableProperties) > 0) {
				$aResult['page_properties'] = $mAvailableProperties;
				$aResult['PagePropertyNameSpace'] = self::PAGE_PROPERTY_NS;
			}
		} catch(Exception $e) {
			ErrorHandler::handleException($e);
		}
		
		// page references are displayed if exist
		$mReferences = AdminModule::getReferences(ReferencePeer::getReferences($oPage));
		$aResult['CountReferences'] = count($mReferences);
		if($mReferences !== null) {
			$aResult['page_references'] = $mReferences;
		}
		return $aResult;
	}
	
	public function getActiveLanguages() {
		$oPage = PagePeer::retrieveByPK($this->iPageId);
		$aActiveStrings = array();
		foreach($oPage->getPageStrings() as $oPageString) {
			if($oPageString->getIsInactive() === false) {
				$aActiveStrings[] = $oPageString->getLanguageId();
			}
		}
		return $aActiveStrings;
	}
	
	public function getLanguageData($sLanguageId) {
		$oPage = PagePeer::retrieveByPK($this->iPageId);
		$oPageString = $oPage->getPageStringByLanguage($sLanguageId);
		if($oPageString === null) {
			$oPageString = new PageString();
			$oPageString->setLanguageId($sLanguageId);
			$oPageString->setIsInactive(true);
			$oPage->addPageString($oPageString);
		}
		$aResult = $oPageString->toArray(BasePeer::TYPE_PHPNAME, false);
		$aResult['LinkTextOnly'] = $oPageString->getLinkTextOnly();
		$aResult['HasLanguageObjectsFilled'] = $oPageString->hasLanguageObjectsFilled($sLanguageId);
		$aResult['PageHref'] = LinkUtil::absoluteLink(LinkUtil::link($oPage->getFullPathArray(), 'FrontendManager', array(), $sLanguageId));

		return $aResult;
	}
	
 /** 
	* getFrontendTemplates()
	* 
	* @param boolean $bExcludeDefault, @see config.yml frontend: main_template
	* description: 
	* called once at page_detail widget prepare
	* @return array of template name options
	*/	
	public static function getFrontendTemplates($bExcludeDefault = true) {
		$aResult = array();
		$bHasDefault = false;
		foreach(Template::listTemplates(DIRNAME_TEMPLATES) as $i => $sTemplateName) {
			if (Settings::getSetting('frontend', 'main_template', 'general') === $sTemplateName && $bExcludeDefault) {
				continue;
			} 
			$aResult[$i]['value'] = $sTemplateName;
			$aResult[$i]['name'] = StringUtil::makeReadableName($sTemplateName);
		}
		$aResult[$i+1]['value'] = "";
		$aResult[$i+1]['is_default'] = true;
		$aResult[$i+1]['name'] = StringPeer::getString('widget.default');
		krsort($aResult);
		return $aResult;
	}

 /** 
	* getPageTypes()
	* description: 
	* called once in page_detail widget prepare
	* @return hash of page_types options
	*/
	public function getPageTypes() {
		$aResult = array();
		foreach(Module::listModulesByType(PageTypeModule::getType()) as $sKey => $aValues) {
			$aResult[$sKey]['value'] = $sKey;
			$aResult[$sKey]['name'] = StringUtil::makeReadableName(isset($aValues['display_name']) ? $aValues['display_name'] : $aValues['name']);
		}
		return $aResult;
	} 

 /** 
	* getAvailablePageProperties()
	* 
	* description: 
	* - gets instances of 'pageProperty' with default values in template and fills the stored page related properties if exist
	* - use self::PAGE_PROPERTY_NS to prevent post key problems
	* - called at page_detail.load_page @see getPageData()
	* @return mixed null/hash of page_properties
	*/	
	private function getAvailablePageProperties($oPage) {
		$aAvailablePageProperties = $oPage->getTemplate()->identifiersMatching('pageProperty', Template::$ANY_VALUE);
		if(count($aAvailablePageProperties) === 0) {
			return array();
		}
		$aResult = array();
		$aSetProperties=array();
		foreach($oPage->getPageProperties() as $oPageProperty) {
			$aSetProperties[$oPageProperty->getName()] = $oPageProperty->getValue();
		}
		foreach($aAvailablePageProperties as $i => $oProperty) {
			$sValue = isset($aSetProperties[$oProperty->getValue()]) ? $aSetProperties[$oProperty->getValue()] : '';
			$aResult[self::PAGE_PROPERTY_NS.$oProperty->getValue()]['value'] = $sValue;
			$aResult[self::PAGE_PROPERTY_NS.$oProperty->getValue()]['default'] = $oProperty->getParameter('defaultValue');
			$aResult[self::PAGE_PROPERTY_NS.$oProperty->getValue()]['type'] = $oProperty->getParameter('propertyType');
		}
		return $aResult;
	}
	
	public function deletePage() {
		$oPage = PagePeer::retrieveByPK($this->iPageId);
		if(!Session::getSession()->getUser()->mayDelete($this->oPage)) {
			throw new NotPermittedException('may_delete_page');
		}
		if($oPage->hasChildren()) {
			throw new NotPermittedException('delete_pagetree_enable');
		}
		if($oPage->isRoot()) {
			throw new LocalizedException('exception.delete_root_page');
		}
		$oPage->delete();
		return $this->iPageId;
	}
	
	public function createPage($iParentId, $sPageName) {
		$oParentPage = PagePeer::retrieveByPK($iParentId);
		if($oParentPage == null) {
			$oParentPage = PagePeer::getRootPage();
		}
		if(!Session::getSession()->getUser()->mayCreateChildren($oParentPage)) {
			throw new NotPermittedException('may_create_children');
		}
		$oPage = new Page();
		$oPage->setName(StringUtil::normalize($sPageName));
		$oPageString = new PageString();
		$oPageString->setLanguageId(AdminManager::getContentLanguage());
		$oPageString->setLinkText(null);
		$oPageString->setPageTitle($sPageName);
		$oPage->addPageString($oPageString);
		$oPage->setPageType('default');
		$oPage->setIsInactive(false);
		$oPage->insertAsLastChildOf($oParentPage);
		return $oPage->save();
	}

	private function validate($aPageData) {
		$oFlash = Flash::getFlash();
		$oFlash->setArrayToCheck($aPageData);
		$oFlash->checkForValue('name', 'page.name_required');
		if(isset($aPageData['edited_languages'])) {
			foreach($aPageData['edited_languages'] as $iCounter => $sLanguageId) {
				if($aPageData['is_active'][$iCounter] && $aPageData['page_title'][$iCounter] == '') {
					$oFlash->addMessage('page_title_required');
					$oFlash->addAffectedIndex('page_title_required', $iCounter);
				}
			}
		}
		$oFlash->finishReporting();
	}

	public function saveData($aPageData) {
		$this->oPage = PagePeer::retrieveByPK($this->iPageId);
		if(!Session::getSession()->getUser()->mayEditPageDetails($this->oPage)) {
			throw new NotPermittedException('may_edit_page_details');
		}
		// validate post values / fetch most with js
		$this->validate($aPageData);
		if(!Flash::noErrors()) {
			throw new ValidationException();
		}

		$this->oPage->setName(StringUtil::normalize($aPageData['name']));
		$this->oPage->setIsInactive(!$aPageData['global_is_active']);
		$this->oPage->setIsHidden($aPageData['is_hidden']);
		$this->oPage->setIsFolder($aPageData['is_folder']);
		$this->oPage->setIsProtected($aPageData['is_protected']);
		if($aPageData['template_name'] === "") {
			$this->oPage->setTemplateName(null);
		} else {
			$this->oPage->setTemplateName($aPageData['template_name']);
		}		
		$this->oPage->setPageType($aPageData['page_type']);
		// handle related tables
		$this->handlePageStrings($aPageData);
		$this->handleLanguageObjects($aPageData);
		$this->handlePageProperties($aPageData);
		
		// save if no errors
		return $this->oPage->save();
	}
	
	private function handlePageStrings($aPageData) {
		if(isset($aPageData['edited_languages'])) {
			foreach($aPageData['edited_languages'] as $iCounter => $sLanguageId) {
				$oPageString = $this->oPage->getPageStringByLanguage($sLanguageId); 
				if($oPageString === null) {
					$oPageString = new PageString();
					$oPageString->setLanguageId($sLanguageId);
					$this->oPage->addPageString($oPageString); 
				}
				$oPageString->setPageTitle($aPageData['page_title'][$iCounter] ? $aPageData['page_title'][$iCounter] : null);
				$oPageString->setLinkText($aPageData['link_text'][$iCounter] ? $aPageData['link_text'][$iCounter] : null);
				$oPageString->setMetaDescription($aPageData['meta_description'][$iCounter] ? $aPageData['meta_description'][$iCounter] : null);
				$oPageString->setMetaKeywords($aPageData['meta_keywords'][$iCounter] ? $aPageData['meta_keywords'][$iCounter] : null);
				$bIsActive = $oPageString->getPageTitle() !== null ? $aPageData['is_active'][$iCounter] : false;
				$oPageString->setIsInactive(!$bIsActive);
				$oPageString->save();
			}
		}
	}
	
	private function handleLanguageObjects($aPageData) {
		foreach($this->oPage->getContentObjects() as $oContentObject) {
		}
	}
	
	private function handlePageProperties($aPageData) {
		foreach($this->oPage->getPageProperties() as $oProperty) {
			$oProperty->delete();
		}
		// set valid posted page properties
		foreach($this->getAvailablePageProperties($this->oPage) as $sName => $aProperties) {
			if(isset($aPageData[$sName]) && trim($aPageData[$sName]) != null) {
				$oPageProperty = new PageProperty();
				$oPageProperty->setName(substr($sName,strlen(self::PAGE_PROPERTY_NS)));
				$oPageProperty->setValue($aPageData[$sName]);
				$this->oPage->addPageProperty($oPageProperty);
			}
		}
	}
}