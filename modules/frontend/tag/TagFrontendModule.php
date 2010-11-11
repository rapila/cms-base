<?php
class TagFrontendModule extends DynamicFrontendModule implements WidgetBasedFrontendModule {
	
	private static $DISPLAY_OPTIONS = array('documents', 'links', 'pages');
	
	public function __construct($oLanguageObject, $aRequestPath = null) {
		parent::__construct($oLanguageObject, $aRequestPath);
	}
	
	public function renderFrontend() {
		$aData = $this->getData();
		$oTemplate = new Template($aData['template']);
		$oItemTemplatePrototype = new Template($aData['template'].'_item');
		$sTags = $aData['tags'];
		$bDocumentFound = false;
		
		$aTags = explode(",", $sTags);
		foreach($aTags as $sTag) {
			$oTag = TagPeer::retrieveByName($sTag);
			
			if($oTag === null) {
				continue;
			}
			$oTemplate->replaceIdentifier('tag_name', StringPeer::getString('tagname.'.$sTag, null, $sTag));	 
			// tagged documents
			if(in_array('documents', $aData['types'])) {
				$aCorrespondingDocuments = $oTag->getAllCorrespondingDataEntries("Document");
				foreach($aCorrespondingDocuments as $oCorrespondingDocument) {
					if($oCorrespondingDocument->getLanguageId() !== null && $oCorrespondingDocument->getLanguageId() !== Session::language()) {
						continue;
					}
					$bDocumentFound = true;
					$oItemTemplate = clone $oItemTemplatePrototype;
					$oItemTemplate->replaceIdentifier('model', 'Document');
					$oItemTemplate->replaceIdentifier("name", $oCorrespondingDocument->getName());
					$oItemTemplate->replaceIdentifier("link_text", $oCorrespondingDocument->getName());
					$oItemTemplate->replaceIdentifier("title", $oCorrespondingDocument->getName());
					$oItemTemplate->replaceIdentifier("description", $oCorrespondingDocument->getDescription());
					$oItemTemplate->replaceIdentifier("extension", $oCorrespondingDocument->getExtension());
					$oItemTemplate->replaceIdentifier("mimetype", $oCorrespondingDocument->getMimetype());
					$oItemTemplate->replaceIdentifier("url", $oCorrespondingDocument->getLink());
					$oItemTemplate->replaceIdentifier('category_id', $oCorrespondingDocument->getDocumentCategoryId());
					$oItemTemplate->replaceIdentifier("size", DocumentUtil::getDocumentSize($oCorrespondingDocument->getDataSize(), 'kb'));
					$oTemplate->replaceIdentifierMultiple("items", $oItemTemplate);
				}
			}
			// tagged links
			if(in_array('links', $aData['types'])) {
				$aCorrespondingLinks = $oTag->getAllCorrespondingDataEntries("Link");
				foreach($aCorrespondingLinks as $oCorrespondingLink) {
					if($oCorrespondingLink->getLanguageId() !== null && $oCorrespondingLink->getLanguageId() !== Session::language()) {
						continue;
					}
					$bDocumentFound = true;
					$oItemTemplate = new Template($aData['template'].'_item');
					$oItemTemplate->replaceIdentifier('model', 'Link');
					$oItemTemplate->replaceIdentifier("name", $oCorrespondingLink->getName());
					$oItemTemplate->replaceIdentifier("link_text", $oCorrespondingLink->getName());
					$oItemTemplate->replaceIdentifier("title", $oCorrespondingLink->getName());
					$oItemTemplate->replaceIdentifier("description", $oCorrespondingLink->getDescription());
					$oItemTemplate->replaceIdentifier("url", Template::htmlEncode($oCorrespondingLink->getUrl()));
					$oTemplate->replaceIdentifierMultiple("items", $oItemTemplate);
				}
			}
			// tagged pages
			if(in_array('pages', $aData['types'])) {
				$aCorrespondingPages = $oTag->getAllCorrespondingDataEntries("Page");
				foreach($aCorrespondingPages as $oCorrespondingPage) {
					if(FrontendManager::$CURRENT_PAGE !== null && $oCorrespondingPage->getId() === FrontendManager::$CURRENT_PAGE->getId()) {
						continue;
					}
					$bDocumentFound = true;
					$oItemTemplate = new Template($aData['template'].'_item');
					$oItemTemplate->replaceIdentifier('model', 'Page');
					$oItemTemplate->replaceIdentifier("name", $oCorrespondingPage->getName());
					$oItemTemplate->replaceIdentifier("link_text", $oCorrespondingPage->getLinkText());
					$oItemTemplate->replaceIdentifier("title", $oCorrespondingPage->getPageTitle());
					$oItemTemplate->replaceIdentifier("description", $oCorrespondingPage->getPageTitle());
					$oItemTemplate->replaceIdentifier("url", LinkUtil::link($oCorrespondingPage->getLink()));
					$oTemplate->replaceIdentifierMultiple("items", $oItemTemplate);
				}
			}
		}
		if(!$bDocumentFound) {
			return null;
		}
		return $oTemplate;
	}

	public function widgetData() {
		return @unserialize($this->getData());	
	}
	
	public function widgetSave($mData) {
		$this->oLanguageObject->setData(serialize($mData));
		return $this->oLanguageObject->save();
	}
	
	public function getWidget() {
		$aOptions = @unserialize($this->getData());	
		$oWidget = new TagEditWidgetModule(null, $this);
		$oWidget->setDisplayMode($aOptions[self::MODE_SELECT_KEY]);
		return $oWidget;
	}
}