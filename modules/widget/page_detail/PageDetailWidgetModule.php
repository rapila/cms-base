<?php
/**
 * @package modules.widget
 */
class PageDetailWidgetModule extends PersistentWidgetModule {
	private $iPageId = null;
	private $oPage;
	const PAGE_PROPERTY_PREFIX = 'page_property_';
	
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
			// not found message
		}
		$aResult = $this->oPage->toArray(BasePeer::TYPE_PHPNAME, false);
		$oPageString = $this->oPage->getActivePageString();
		$aResult['active_page_string'] = $oPageString->toArray(BasePeer::TYPE_PHPNAME, false);
		$aResult['active_page_string']['LinkTextOnly'] = $oPageString->getLinkTextOnly();
		$aResult['PageHref'] = LinkUtil::absoluteLink(LinkUtil::link($this->oPage->getFullPathArray(), 'FrontendManager'));
		$aResult['CountReferences'] = ReferencePeer::countReferences($this->oPage);
		$aResult['page_properties'] = $this->getAvailablePageProperties();
		return $aResult;
	}
	
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

	public function getPageTypes() {
		$aResult = array();
		foreach(Module::listModulesByType(PageTypeModule::getType()) as $sKey => $aValues) {
			$aResult[$sKey]['value'] = $sKey;
			$aResult[$sKey]['name'] = StringUtil::makeReadableName(isset($aValues['display_name']) ? $aValues['display_name'] : $aValues['name']);
		}
		return $aResult;
	}	
	
	public function getAvailablePageProperties() {
		$aResult = array();
		$aSetProperties=array();
		foreach($this->oPage->getPageProperties() as $oPageProperty) {
			$aSetProperties[$oPageProperty->getName()] = $oPageProperty->getValue();
		}
		foreach($this->oPage->getTemplate()->identifiersMatching('pageProperty', Template::$ANY_VALUE) as $i => $oProperty) {
			$sValue = isset($aSetProperties[$oProperty->getValue()]) ? $aSetProperties[$oProperty->getValue()] : '';
			$aResult[$oProperty->getValue()]['value'] = $sValue;
			$aResult[$oProperty->getValue()]['default'] = $oProperty->getParameter('defaultValue');
		}
		return $aResult;
	}
	
	private function setPageProperties($aPageData) {
		foreach($this->oPage->getPageProperties() as $oProperty) {
			$oProperty->delete();
		}
		// ErrorHandler::log($this->getAvailablePageProperties(), $aPageData);
		foreach($this->getAvailablePageProperties() as $sName => $aProperties) {
			if(isset($aPageData[$sName])) {
				$oPageProperty = new PageProperty();
				$oPageProperty->setName($sName);
				$oPageProperty->setValue($aPageData[$sName]);
				$this->oPage->addPageProperty($oPageProperty);
			}
		}
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
		$this->setPageProperties($aPageData);
		// ErrorHandler::log($this->oPage);

		// page_strings
		// language_objects if exists, if new
		return $this->oPage->save();
	}
}