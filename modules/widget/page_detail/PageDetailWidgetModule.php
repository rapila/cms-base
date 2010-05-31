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
		$aResult['PageHref'] = 'http://Weblink';
		$aResult['CountReferences'] = ReferencePeer::countReferences($this->oPage);
		$aResult['template_options'] = self::getFrontendTemplates();
		$aResult['page_property_options'] = $this->getPageProperties();
		return $aResult;
	}
	
	public static function getFrontendTemplates($bExcludeDefault=true) {
		$aResult = array();
		$bHasDefault = false;
		foreach(Template::listTemplates(DIRNAME_TEMPLATES, false, ResourceFinder::SEARCH_SITE_ONLY) as $i => $sTemplateName) {
			if (Settings::getSetting('frontend', 'main_template', 'general') == $sTemplateName) {
				$bHasDefault = true;
				continue;				
			} 
			$aResult[$i]['value'] = $sTemplateName;
			$aResult[$i]['name'] = StringUtil::makeReadableName($sTemplateName);
		}
		if($bHasDefault) {
			$aResult[$i+1]['value'] = "";
			$aResult[$i+1]['name'] = StringPeer::getString('widget.default');
		}
		krsort($aResult);
		return $aResult;
	}
	
	public function getPageProperties() {
		return array();
		// return $this->oPage->getTemplate()->getCustomPagePropertyIdentifiers();
	}
	
	public function saveData($aPageData) {
		if($this->iPageId === null) {
			$oPage = new Page();
		} else {
			$oPage = PagePeer::retrieveByPK($this->iPageId);
		}
		$oPage->setName($aPageData['name']);
		$oPage->setIsInactive(isset($aPageData['is_inactive']));
		return $oPage->save();
	}
}