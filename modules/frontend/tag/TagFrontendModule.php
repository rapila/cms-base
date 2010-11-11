<?php
class TagFrontendModule extends DynamicFrontendModule implements WidgetBasedFrontendModule {
	
	public function __construct($oLanguageObject, $aRequestPath = null) {
		parent::__construct($oLanguageObject, $aRequestPath);
	}
	
	public function renderFrontend() {
		$aData = unserialize($this->getData());
		$oTemplate = new Template($aData['template']);
		$oItemTemplatePrototype = new Template($aData['template'].'_item');
		$aTagIDs = $aData['tags'];
		$bItemFound = false;
		
		$aTags = array();
		foreach($aTagIDs as $iTagID) {
			$oTag = TagPeer::retrieveByPK($iTagID);
			if($oTag !== null) {
				$aTags[] = $oTag;
			}
		}

		// tagged items
		foreach($aData['types'] as $sDocumentModel) {
			foreach($aTags as $oTag) {
				$aCorrespondingItems = $oTag->getAllCorrespondingDataEntries($sDocumentModel);
				foreach($aCorrespondingItems as $oCorrespondingItem) {
					if(!$oCorrespondingItem->shouldBeIncludedInList(Session::language(), FrontendManager::$CURRENT_PAGE)) {
						continue;
					}
					$bItemFound = true;
					$oItemTemplate = clone $oItemTemplatePrototype;
					$oItemTemplate->replaceIdentifier('model', $sDocumentModel);
					$oCorrespondingItem->renderListItem($oItemTemplate);
					$oTemplate->replaceIdentifierMultiple("items", $oItemTemplate);
				}
			}
		}
		if(!$bItemFound) {
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
		$oWidget = new TagEditWidgetModule(null, $this);
		return $oWidget;
	}
}