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
		try {
			$oListTemplate = new Template($aOptions['template']);
			$oItemPrototype = new Template($aOptions['template'].self::LIST_ITEM_POSTFIX);
			foreach(self::listQuery($aOptions)->find() as $i => $oLink) {
				$oItemTemplate = clone $oItemPrototype;
				$oItemTemplate->replaceIdentifier('model', 'Link');
				$oLink->renderListItem($oItemTemplate);
				$oListTemplate->replaceIdentifierMultiple('items', $oItemTemplate);
			}
		} catch(Exception $e) {
			$oListTemplate = new Template("", null, true);
		}
		return $oListTemplate;
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

	public static function listQuery($aOptions) {
		$oQuery = LinkQuery::create()->filterByDisplayLanguage();

		// Link categories
		$aCategories = isset($aOptions['link_categories']) ? (is_array($aOptions['link_categories']) ? $aOptions['link_categories'] : array($aOptions['link_categories'])) : array();
		$iCountCategories = count($aCategories);
		if($iCountCategories > 0) {
			$oQuery->filterByLinkCategoryId($aCategories);
		}

		// Tags
		$aTags = isset($aOptions['tags']) ? (is_array($aOptions['tags']) ? $aOptions['tags'] : array($aOptions['tags'])) : array();
		$bHasTags = count($aTags) > 0 && $aTags[0] !== null;
		if($bHasTags) {
			$oQuery->filterByTagId($aTags);
		}

		// Sort order only in case of one category and no tags
		if($iCountCategories === 1 && $bHasTags === false && $aOptions['sort_by'] === self::SORT_BY_SORT) {
			$oQuery->orderBySort();
		}
		return $oQuery->orderByName();
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
		$oQuery = LinkCategoryQuery::create()->orderByName();
		if(!Session::getSession()->getUser()->getIsAdmin() || Settings::getSetting('admin', 'hide_externally_managed_link_categories', true)) {
			$oQuery->filterByIsExternallyManaged(false);
		}
		$aResult = $oQuery->select(array('Id', 'Name'))->find()->toKeyValue('Id', 'Name');
		if(count($aResult) > 0 && !Settings::getSetting('admin', 'list_allows_multiple_categories', true)) {
			$aResult = array('' => ' ---- ')+$aResult;
		}
		return $aResult;
	}

	public static function getTagOptions() {
		$aResult = TagQuery::create()->filterByTagged('Link')->select(array('Id', 'Name'))->find()->toKeyValue('Id', 'Name');
		if(count($aResult) > 0 && !Settings::getSetting('admin', 'list_allows_multiple_categories', true)) {
			$aResult = array('' => ' ---- ')+$aResult;
		}
		if(count($aResult) === 0) {
			$aResult = array('' => StringPeer::getString('wns.link_list.no_tags_available'));
		}
		return $aResult;
	}

	public static function getContentInfo($oLanguageObject) {
		if(!$oLanguageObject) {
			return null;
		}
		$aData = @unserialize(stream_get_contents($oLanguageObject->getData()));
		$aOutput = array();
		if(isset($aData['link_categories']) && is_array($aData['link_categories'])) {
			$aResult = array();
			foreach(self::getCategoryOptions() as $iCategory => $sName) {
				if(in_array($iCategory, $aData['link_categories'])) {
					$aResult[] = $sName;
				}
			}
			if(count($aResult) > 0) {
				$aOutput[] = StringPeer::getString('wns.link_category').': '.implode(', ', $aResult);
			}
		}
		if(isset($aData['tags']) && is_array($aData['tags'])) {
			$aResult = array();
			foreach(self::getTagOptions() as $iTagId => $sName) {
				if(in_array($iTagId, $aData['tags'])) {
					$aResult[] = $sName;
				}
			}
			if(count($aResult) > 0) {
				$aOutput[] = StringPeer::getString('wns.tags').': '.implode(', ', $aResult);
			}
		}
		return implode("\n", $aOutput);
	}

}
