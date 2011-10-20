<?php
/**
 * @package modules.frontend
 */

class LinkListFrontendModule extends DynamicFrontendModule {
	
	const LIST_ITEM_POSTFIX = '_item';
	const SORT_BY_NAME = 'by_name';
	const SORT_BY_SORT = 'by_sort';
	
	public function renderFrontend() {
		$aOptions = @unserialize($this->getData());
		$oCriteria = LinkQuery::create();
		$bOneTagnameOnly = false;
		$aCategories = null;
		if(isset($aOptions['tags']) && is_array($aOptions['tags']) && (count($aOptions['tags']) > 0)) {
			$aLinks = LinkPeer::getLinksByTagName($aOptions['tags']);
			$bOneTagnameOnly = count($aOptions['tags']) === 1;
		} else {
      $aCategories = isset($aOptions['link_categories']) ? (is_array($aOptions['link_categories']) ? $aOptions['link_categories'] : array($aOptions['link_categories'])) : array();

			$oCriteria->filterByDisplayLanguage();

		  if(count($aCategories) > 1) {
				$oCriteria->add(LinkPeer::LINK_CATEGORY_ID, $aCategories, Criteria::IN);
		  } else if(count($aCategories) === 1) {
				$oCriteria->add(LinkPeer::LINK_CATEGORY_ID, $aCategories[0]);
			}
			if(isset($aOptions['sort_by']) && $aOptions['sort_by'] === self::SORT_BY_SORT) {
				$oCriteria->addAscendingOrderByColumn(LinkPeer::SORT);
			}
      $oCriteria->addAscendingOrderByColumn(LinkPeer::NAME);
		}
		try {
			$oListTemplate = new Template($aOptions['template']);
			if($bOneTagnameOnly) {
        $oListTemplate->replaceIdentifier('tag_name', StringPeer::getString('tagname.'.$aOptions['tags'][0], null, $aOptions['tags'][0]));
			} else if(is_array($aCategories)) {
			  $oListTemplate->replaceIdentifier('category_ids', implode('|', $aCategories));
			}
			foreach($oCriteria->find() as $i => $oLink) {
				$oItemTemplate = new Template($aOptions['template'].self::LIST_ITEM_POSTFIX);
				$oItemTemplate->replaceIdentifier('model', 'Link');
				$oItemTemplate->replaceIdentifier('counter', $i+1);
				$oLink->renderListItem($oItemTemplate);
				$oListTemplate->replaceIdentifierMultiple('items', $oItemTemplate);
			}
		} catch(Exception $e) {
			$oListTemplate = new Template("", null, true);
		}
		return $oListTemplate;
	}

	public function widgetData() {
		return @unserialize($this->getData());	
	}
	
	public function widgetSave($mData) {
		$this->oLanguageObject->setData(serialize($mData));
		$bResult = $this->oLanguageObject->save();
		if($bResult) {
			if(isset($mData['link_categories'])) {
				ReferencePeer::removeReferences($this->oLanguageObject);
				foreach($mData['link_categories'] as $iCategoryId) {
					ReferencePeer::addReference($this->oLanguageObject, array($iCategoryId, 'LinkCategory'));
				}
			}
		}
		return $bResult;
	}
	
	public function getWidget() {
		$aOptions = @unserialize($this->getData());	
		$oWidget = new LinkListFrontendConfigWidgetModule(null, $this);
		$oWidget->setDisplayMode($aOptions);
		return $oWidget;
	}
	
	public static function getTemplateOptions() {
		return AdminManager::getSiteTemplatesForListOutput(self::LIST_ITEM_POSTFIX);	
	}
	
	public static function getSortOptions() {
		$aResult[self::SORT_BY_NAME] = StringPeer::getString('wns.order.by_name');
		$aResult[self::SORT_BY_SORT] = StringPeer::getString('wns.order.by_sort');
		return $aResult;
	}	
	
	public static function getCategoryOptions() {
		$oCriteria = LinkCategoryQuery::create()->orderByName();
		if(!Session::getSession()->getUser()->getIsAdmin() || Settings::getSetting('admin', 'hide_externally_managed_link_categories', true)) {
			$oCriteria->filterByIsExternallyManaged(false);
		}
		$oCriteria->clearSelectColumns()->addSelectColumn(LinkCategoryPeer::ID)->addSelectColumn(LinkCategoryPeer::NAME);
		$aResult = array();
		foreach(LinkCategoryPeer::doSelectStmt($oCriteria)->fetchAll(PDO::FETCH_ASSOC) as $aCategory) {
			$aResult[$aCategory['ID']] = $aCategory['NAME'];
		}
		return $aResult;
	}
	
	public static function getContentInfo($oLanguageObject) {
		if(!$oLanguageObject) {
			return null;
		}
		$aData = @unserialize(stream_get_contents($oLanguageObject->getData()));
		if(isset($aData['link_categories']) && is_array($aData['link_categories'])) {
			$aResult = array();
			foreach(self::getCategoryOptions() as $iCategory => $sName) {
				if(in_array($iCategory, $aData['link_categories'])) {
					$aResult[] = $sName;
				}
			}
			if(count($aResult) > 0) {
				return StringPeer::getString('wns.link_category').': '.implode(', ', $aResult);
			}
		}
	}

}
