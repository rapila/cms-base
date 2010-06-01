<?php
/**
 * @package modules.widget
 */
class PageDetailWidgetModule extends PersistentWidgetModule {
	private $iPageId = null;
	private $oPage;
	
	public function doWidget() {
		return $this->constructTemplate('edit');
	}
	
	public function setPageId($iPageId) {
		$this->iPageId = $iPageId;
	}
	
	public function getPageData() {
		$this->oPage = PagePeer::retrieveByPK($this->iPageId);
		if($this->oPage === null) {
			// not found message
		}
		$aResult = $this->oPage->toArray(BasePeer::TYPE_PHPNAME, false);
		$oPageString = $this->oPage->getActivePageString();
		$aResult['active_page_string'] = $oPageString->toArray(BasePeer::TYPE_PHPNAME, false);
		$aResult['active_page_string']['LinkTextOnly'] = $oPageString->getLinkTextOnly();
		$aResult['PageHref'] = LinkUtil::absoluteLink(LinkUtil::link($this->oPage->getFullPathArray(), 'FrontendManager'));
		$aResult['CountReferences'] = ReferencePeer::countReferences($this->oPage);
		$aResult['page_property_options'] = $this->getPageProperties();
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
	
	public function getPageProperties() {
		$aResult = array();
		foreach($this->oPage->getTemplate()->identifiersMatching('pageProperty', Template::$ANY_VALUE) as $oProperty) {
			$aResult[$oProperty->getValue()] = $oProperty->getParameter('defaultValue');
		}
		return $aResult;
	}
	
	public function saveData($aPageData) {
		if($this->iPageId === null) {
			$oPage = new Page();
		} else {
			$oPage = PagePeer::retrieveByPK($this->iPageId);
		}
		$oPage->setName($aPageData['name']);
		$oPage->setIsInactive(!isset($aPageData['is_inactive']));
		return $oPage->save();
	}
}