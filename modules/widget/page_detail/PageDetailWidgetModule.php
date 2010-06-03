<?php
/**
 * @package modules.widget
 */
class PageDetailWidgetModule extends PersistentWidgetModule {
	private $iPageId = null;
	private $oPage;
	const PAGE_PROPERTY_PREFIX = 'page_property.';
		
	public function doWidget() {
		return $this->constructTemplate('edit');
	}
	
	public function setPageId($iPageId) {
		$this->iPageId = $iPageId;
	}
	
	public function setPage() {
		if($this->oPage === null) {
			$this->oPage = PagePeer::retrieveByPK($this->iPageId);
		}
	}
	
	public function getPageData() {
		$this->setPage();
		if($this->oPage === null) {
			// redirect 404
		}
		$aResult = $this->oPage->toArray(BasePeer::TYPE_PHPNAME, false);
		$oPageString = $this->oPage->getActivePageString();
		
		// addition related params that do not relate to primary tables fields
		$aResult['active_page_string'] = $oPageString->toArray(BasePeer::TYPE_PHPNAME, false);
		$aResult['active_page_string']['LinkTextOnly'] = $oPageString->getLinkTextOnly();
		$aResult['PageHref'] = LinkUtil::absoluteLink(LinkUtil::link($this->oPage->getFullPathArray(), 'FrontendManager'));
		$aResult['CountReferences'] = ReferencePeer::countReferences($this->oPage);

		// page properties are displayed if added to template
		$mAvailableProperties = $this->getAvailablePageProperties();
		if($mAvailableProperties !== null) {
			$aResult['page_properties'] = $mAvailableProperties;
			$aResult['NameSpace'] = self::PAGE_PROPERTY_PREFIX;
		}
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
	* - gets instances of 'pageProperty' with default values in template and fills the stored page related values if exist
	* - called at page_detail.load_page @see getPageData()
	* @return mixed null/hash of page_properties
	*/	
	private function getAvailablePageProperties() {
		$aAvailablePageProperties = $this->oPage->getTemplate()->identifiersMatching('pageProperty', Template::$ANY_VALUE);
		if(count($aAvailablePageProperties) === null) {
			return null;
		}
		$aResult = array();
		$aSetProperties=array();
		foreach($this->oPage->getPageProperties() as $oPageProperty) {
			$aSetProperties[$oPageProperty->getName()] = $oPageProperty->getValue();
		}
		foreach($aAvailablePageProperties as $i => $oProperty) {
			$sValue = isset($aSetProperties[$oProperty->getValue()]) ? $aSetProperties[$oProperty->getValue()] : '';
			$aResult[self::PAGE_PROPERTY_PREFIX.$oProperty->getValue()]['value'] = $sValue;
			$aResult[self::PAGE_PROPERTY_PREFIX.$oProperty->getValue()]['default'] = $oProperty->getParameter('defaultValue');
		}
		return $aResult;
	}

	public function saveData($aPageData) {
		$this->setPage();
		// validate post values / fetch most with js
		$this->oPage->setName(StringUtil::normalize($aPageData['name']));
		$this->oPage->setIsInactive(!isset($aPageData['is_inactive']));
		$this->oPage->setIsHidden(isset($aPageData['is_hidden']));
		$this->oPage->setIsFolder(isset($aPageData['is_folder']));
		$this->oPage->setIsProtected(isset($aPageData['is_protected']));
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
		$oPageString = $this->oPage->getActivePageString();	
		if($oPageString === null) {
			$oPageString = new PageString();
			$this->oPage->addPageString(); 
		}
		$oPageString->setPageTitle($aPageData['page_title']);
		$oPageString->setLinkText($aPageData['link_text']);
	}
	
	private function handleLanguageObjects($aPageData) {
	}
	
	private function handlePageProperties($aPageData) {
		foreach($this->oPage->getPageProperties() as $oProperty) {
			$oProperty->delete();
		}
		
		ErrorHandler::log($aPageData, $this->getAvailablePageProperties());
		// set valid posted page properties
		foreach($this->getAvailablePageProperties() as $sName => $aProperties) {
			if(isset($aPageData[$sName]) && trim($aPageData[$sName]) != null) {
				$oPageProperty = new PageProperty();
				$oPageProperty->setName(substr($sName,strlen(self::PAGE_PROPERTY_PREFIX)));
				$oPageProperty->setValue($aPageData[$sName]);
				$this->oPage->addPageProperty($oPageProperty);
			}
		}
	}
}