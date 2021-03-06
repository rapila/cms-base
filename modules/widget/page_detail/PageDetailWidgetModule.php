<?php
/**
 * @package modules.widget
 */
class PageDetailWidgetModule extends PersistentWidgetModule {

	private $iPageId = null;
	private $oPage;

	public function __construct($sSessionId) {
		parent::__construct($sSessionId);
		$this->setSetting('active_accordion', $this->getActiveAccordion());
	}

	public function activeAccordion($iAccordion) {
		Session::getSession()->setAttribute('active_accordion', $iAccordion);
	}

	public function getActiveAccordion() {
		$iAccordion = Session::getSession()->getAttribute('active_accordion');
		if($iAccordion) {
			return $iAccordion;
		}
	  return 0;
	}

	public function doWidget() {
		return $this->constructTemplate('edit');
	}

	public function setPageId($iPageId) {
		$this->iPageId = (int) $iPageId;
		Session::getSession()->setAttribute('persistent_page_id', $this->iPageId);
	}

	public function getPageData() {
		$oPage = PageQuery::create()->findPk($this->iPageId);
		$aResult = $oPage->toArray(BasePeer::TYPE_PHPNAME, false);

		// addition related page fields
		$aResult['PageLink'] = LinkUtil::absoluteLink(LinkUtil::link($oPage->getFullPathArray(), 'FrontendManager', array(), AdminManager::getContentLanguage()), null, 'auto');
		$aResult['PageHref'] = LinkUtil::absoluteLink(LinkUtil::link($oPage->getFullPathArray(), 'FrontendManager', array(), AdminManager::getContentLanguage()), null, 'default', true);

		// page properties are displayed if added to template
		try {
			$mAvailableProperties = $this->getAvailablePageProperties($oPage);
			if(count($mAvailableProperties) > 0) {
				$aResult['page_properties'] = $mAvailableProperties;
			}
		} catch(Exception $e) {
			ErrorHandler::handleException($e, true);
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
		$oPage = PageQuery::create()->findPk($this->iPageId);
		$aActiveStrings = array();
		foreach($oPage->getPageStrings() as $oPageString) {
			if($oPageString->getIsInactive() === false) {
				$aActiveStrings[] = $oPageString->getLanguageId();
			}
		}
		return $aActiveStrings;
	}

	public function getLanguageData($sLanguageId) {
		$oPage = PageQuery::create()->findPk($this->iPageId);
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
		$sDefaultTemplate = Settings::getSetting('frontend', 'main_template', 'general');
		foreach(Template::listTemplates(DIRNAME_TEMPLATES) as $i => $sTemplateName) {
			if (Settings::getSetting('frontend', 'main_template', 'general') === $sTemplateName && $bExcludeDefault) {
				continue;
			}
			$aResult[$i]['is_default'] = false;
			$aResult[$i]['value'] = $sTemplateName;
			$aResult[$i]['name'] = StringUtil::makeReadableName($sTemplateName);
		}
		$aResult[$i+1]['value'] = "";
		$aResult[$i+1]['is_default'] = true;
		$aResult[$i+1]['name'] = TranslationPeer::getString('wns.default');

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
			$aResult[$sKey]['name'] = TranslationPeer::getString('page_type.'.$aValues['name'], null, StringUtil::makeReadableName($aValues['name']));
		}
		return $aResult;
	}

 /**
	* getAvailablePageProperties()
	*
	* description:
	* - gets instances of 'pageProperty' with default values in template and fills the stored page related properties if exist
	* - called at page_detail.load_page @see getPageData()
	* @return mixed null/hash of page_properties
	*/
	private function getAvailablePageProperties($oPage) {
		$aAvailablePageProperties = $oPage->getTemplate()->identifiersMatching('pageProperty', Template::$ANY_VALUE);
		$aResult = array();

		foreach($aAvailablePageProperties as $oProperty) {
			$sPropertyName = $oProperty->getValue();
			$aResult[$sPropertyName]['value'] = '';
			$aResult[$sPropertyName]['defaultValue'] = $oProperty->getParameter('defaultValue');
			$aResult[$sPropertyName]['type'] = $oProperty->getParameter('propertyType');
		}
		foreach($oPage->getPagePropertyQuery()->byNamespace(false)->find() as $oPageProperty) {
			if(isset($aResult[$oPageProperty->getName()])) {
				$aResult[$oPageProperty->getName()]['value'] = $oPageProperty->getValue();
			}	else {
				$aResult[$oPageProperty->getName()] = array('value' => $oPageProperty->getValue(), 'defaultValue' => null, 'type' => null);
			}
		}
		$aResult['page_identifier'] = array('value' => $oPage->getIdentifier(), 'defaultValue' => null, 'type' => null);
		foreach($aResult as $sName => &$aValues) {
			$aValues['display_name'] = TranslationPeer::getString("page_property.$sName", null, StringUtil::makeReadableName($sName));
		}
		return $aResult;
	}

	public function deletePage() {
		$oPage = PageQuery::create()->findPk($this->iPageId);
		if($oPage->isRoot()) {
			throw new LocalizedException('wns.page.delete_root_restriction_message', array('page_name' => $oPage->getName()));
		}
		$oPage->delete();
		return $this->iPageId;
	}

	public function createPage($iParentId, $sPageName) {
		$oParentPage = PageQuery::create()->findPk($iParentId);
		if($oParentPage == null) {
			$oParentPage = PagePeer::getRootPage();
		}
		$sPageTitle = $sPageName;
		$sPageName = StringUtil::normalizeToASCII($sPageName);
		if(!$sPageName) {
			// If all we have are special chars, leave the page name as is and only normalize minimally
			$sPageName = $sPageTitle;
		}
		$sPageName = StringUtil::normalizePath($sPageName);
		if(PagePeer::pageIsNotUnique($sPageName, $oParentPage)) {
			$oFlash = Flash::getFlash();
			$oFlash->addMessage('page.name_unique_required');
			$oFlash->finishReporting();
			throw new ValidationException($oFlash);
		}
		$oPage = new Page();
		$oPage->setName($sPageName);
		$oPageString = new PageString();
		$oPageString->setLanguageId(AdminManager::getContentLanguage());
		$oPageString->setIsInactive(false);
		$oPageString->setLinkText(null);
		$oPageString->setPageTitle($sPageTitle);
		$oPage->addPageString($oPageString);
		$oPage->setPageType('default');
		$oPage->setTemplateName($oParentPage->getTemplateName());
		$oPage->setIsInactive(true);
		$oPage->insertAsLastChildOf($oParentPage);
		return $oPage->save();
	}

	private function validate($aPageData) {
		$oFlash = Flash::getFlash();
		$oFlash->setArrayToCheck($aPageData);
		$oFlash->checkForValue('name', 'page.name_required');
		if($aPageData['name'] != null && $aPageData['name'] != $this->oPage->getName()) {
			if(PagePeer::pageIsNotUnique($aPageData['name'], $this->oPage->getParent(), $this->oPage->getId())) {
				$oFlash->addMessage('page.name_unique_required');
			}
		}
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

	public function saveTemplateAndPageType($sTemplate, $sPageType) {
		$this->oPage = PageQuery::create()->findPk($this->iPageId);
		if(!Session::getSession()->getUser()->mayEditPageDetails($this->oPage)) {
			throw new NotPermittedException('may_edit_page_details');
		}
		if($sTemplate === "") {
			$this->oPage->setTemplateName(null);
		} else {
			$this->oPage->setTemplateName($sTemplate);
		}
		$this->oPage->setPageType($sPageType);
		return $this->oPage->save();
	}

	public function saveData($aPageData) {
		$this->oPage = PageQuery::create()->findPk($this->iPageId);
		if(!Session::getSession()->getUser()->mayEditPageDetails($this->oPage)) {
			throw new NotPermittedException('may_edit_page_details');
		}
		// validate post values / fetch most with js
		$this->validate($aPageData);
		if(!Flash::noErrors()) {
			throw new ValidationException();
		}

		$this->oPage->setName($aPageData['name']);
		$this->oPage->setIsInactive(!$aPageData['global_is_active']);
		$this->oPage->setIsHidden($aPageData['is_hidden']);
		$this->oPage->setIsFolder($aPageData['is_folder']);
		$this->oPage->setIsProtected($aPageData['is_protected']);
		$mCanonicalId = null;
		if($aPageData['canonical_id'] !== '') {
			$mCanonicalId = $this->validateCanonicalId($aPageData['canonical_id']);
		}
		$this->oPage->setCanonicalId($mCanonicalId);
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

	private function validateCanonicalId($mCanonicalId) {
		$oCanonicalPage = PageQuery::create()->findPk($mCanonicalId);
		if($oCanonicalPage === null) {
			// this should not happen, something would be wrong about our data handling?
			return null;
		}
		if(Util::equals($oCanonicalPage, $this->oPage)) {
			return null;
		}
		// @todo should we exclude pages from being canonical, i.e.
		// • descendants of a duplicate $oCanonicalPage->isDescendantOf($this->oPage)
		// • root
		return $mCanonicalId;
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
				$oPageString->setPageTitle($aPageData['page_title'][$iCounter] ? $aPageData['page_title'][$iCounter] : "");
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
		foreach($this->oPage->getPagePropertyQuery()->byNamespace(false)->find() as $oProperty) {
			$oProperty->delete();
		}
		// set valid posted page properties
		if(!isset($aPageData['page_properties']['page_identifier'])) {
			$this->oPage->setIdentifier(null);
		}
		foreach($aPageData['page_properties'] as $sName => $sValue) {
			if($sName === 'page_identifier') {
				$this->oPage->setIdentifier($sValue ? $sValue : null);
			} else {
				if(trim($sValue) !== '') {
					$oPageProperty = new PageProperty();
					$oPageProperty->setName($sName);
					$oPageProperty->setValue($sValue);
					$this->oPage->addPageProperty($oPageProperty);
				}
			}
		}
	}
}
