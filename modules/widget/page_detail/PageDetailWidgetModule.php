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

	public function getPageTypes() {
		$aResult = array();
		foreach(Module::listModulesByType(PageTypeModule::getType()) as $sKey => $aValues) {
			$aResult[$sKey]['value'] = $sKey;
			$aResult[$sKey]['name'] = StringUtil::makeReadableName(isset($aValues['display_name']) ? $aValues['display_name'] : $aValues['name']);
		}
		return $aResult;
	}
	
	public function saveData($aPageData) {
		if($this->iPageId === null) {
			$oPage = new Page();
		} else {
			$oPage = PagePeer::retrieveByPK($this->iPageId);
		}
		// validate post values / fetch most with js
		$oPage->setName(StringUtil::normalize($_POST['name']));
		$oPage->setIsInactive(!isset($aPageData['is_inactive']));
		$oPage->setIsHidden(isset($aPageData['is_hidden']));
		$oPage->setIsFolder(isset($aPageData['is_folder']));
		$oPage->setIsProtected(isset($aPageData['is_protected']));
		if($_POST['template_name'] === "") {
			$oPage->setTemplateName(null);
		} else {
			$oPage->setTemplateName($_POST['template_name']);
		}		
		$oPage->setPageType($_POST['page_type']);
		// getLanguageObjects if exists, if new
// $oPage->setIsProtected(isset($aPageData['is_protected']));		
		return $oPage->save();
	}
}