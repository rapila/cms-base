<?php
/**
	* @package modules.page_type
	*/
class SearchResultPageTypeModule extends PageTypeModule {
			
	public function __construct(Page $oPage = null, NavigationItem $oNavigationItem = null) {
		parent::__construct($oPage, $oNavigationItem);
	}
	
	public function display(Template $oTemplate) {
		$sTemplateName = $this->oPage->getTemplateNameUsed();
		
		$oSearchTemplate = new Template("search/{$sTemplateName}_list");
		$sResultTemplateName = "search/{$sTemplateName}_result";
		
		$oSearch = SearchIndex::getSearchIndex();
		
		$sSearchString = '';
		
		if(isset($_REQUEST['search'])) {
			$sSearchString = trim($_REQUEST['search']);
		} else if(Manager::hasNextPathItem()) {
			$sSearchString = trim(Manager::usePath());
		}
		
		if(isset($_REQUEST['quicksearch'])) {
			$oPage = $oSearch->findPage($sSearch);
			if($oPage !== null) {
				LinkUtil::redirectToManager($oPage->getId(), 'GotoManager');
			}
		}
		
		$aResult = $oSearch->find($sSearchString);
		
		$iResultCount = 0;
		foreach($aResult as $iPageid => $iCount) {
			$oPage = PagePeer::retrieveByPK($iPageid);
			if($oPage === null || $oPage->getIsInactive()) {
				continue;
			}
			$iResultCount++;
			$oResultTemplate = new Template($sResultTemplateName);
			$oResultTemplate->replaceIdentifier('link', LinkUtil::link($oPage->getFullPathArray(), 'FrontendManager'));
			$oResultTemplate->replaceIdentifier('page_title', $oPage->getPageTitle());
			$oResultTemplate->replaceIdentifier('link_text', $oPage->getLinkText());
			$oResultTemplate->replaceIdentifier('id', $oPage->getId());
			$oResultTemplate->replaceIdentifier('name', $oPage->getName());
			$oResultTemplate->replaceIdentifier('count', $iCount);
			$oSearchTemplate->replaceIdentifierMultiple('result', $oResultTemplate);
		}
		$oSearchTemplate->replaceIdentifier('search_string', $sSearchString);
		$oSearchTemplate->replaceIdentifier('count', $iResultCount);
		if($iResultCount === 0) {
			$oSearchTemplate->replaceIdentifier('no_results', StringPeer::getString('search_no_results', null, null, array('search_string' => $sSearchString)));
		}
		
		//Replace the identifier in the given template with the search results
		$oTemplate->replaceIdentifier('search_results', $oSearchTemplate);
	}
			 
	public function setIsDynamicAndAllowedParameterPointers(&$bIsDynamic, &$aAllowedParams) {
		$bIsDynamic = true;
		$aAllowedParams = array('search');
	}
	
}
