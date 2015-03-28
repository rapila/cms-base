<?php
/**
 * @package modules.frontend
 */

class DocumentListFrontendModule extends DynamicFrontendModule {

	const LIST_ITEM_POSTFIX = '_item';
	const SORT_BY_NAME = 'by_name';
	const SORT_BY_SORT = 'by_sort';
	const SORT_BY_CREATEDAT = 'by_createdat';

	public function renderFrontend() {
		$aOptions = @unserialize($this->getData());
		try {
			$oListTemplate = new Template($aOptions['list_template']);
			$oItemPrototype = new Template($aOptions['list_template'].self::LIST_ITEM_POSTFIX);

			foreach(self::listQuery($aOptions)->find() as $i => $oDocument) {
				$oItemTemplate = clone $oItemPrototype;
				$oDocument->renderListItem($oItemTemplate);
				$oListTemplate->replaceIdentifierMultiple('items', $oItemTemplate);
			}
		} catch(Exception $e) {
			$oListTemplate = new Template("", null, true);
		}
		return $oListTemplate;
	}

	public static function listQuery($aOptions) {
		$oQuery = DocumentQuery::create()->filterByDisplayLanguage();
		if(!Session::getSession()->isAuthenticated()) {
			$oQuery->filterByIsProtected(false);
		}

		// Link categories
		$aCategories = isset($aOptions['document_categories']) ? (is_array($aOptions['document_categories']) ? $aOptions['document_categories'] : array($aOptions['document_categories'])) : array();
		$iCountCategories = count($aCategories);
		if($iCountCategories > 0) {
			$oQuery->filterByDocumentCategoryId($aCategories);
		}

		// Tags
		$aTags = isset($aOptions['tags']) ? (is_array($aOptions['tags']) ? $aOptions['tags'] : array($aOptions['tags'])) : array();
		$bHasTags = count($aTags) > 0 && $aTags[0] !== null;
		if($bHasTags) {
			$oQuery->filterByTagId($aTags);
		}

		// Check document kind
		if(isset($aOptions['document_kind']) && $aOptions['document_kind'] != null) {
			$oQuery->filterByDocumentKind($aOptions['document_kind']);
		}

		$sSortOrder = @$aOptions['sort_order'] === 'desc' ? 'desc' : 'asc';
		// Sort order only in case of one category and no tags
		if($iCountCategories === 1 && $bHasTags === false) {
			if($aOptions['sort_by'] === self::SORT_BY_SORT) {
				$oQuery->orderBySort($sSortOrder);
			}
		}
		if($aOptions['sort_by'] === self::SORT_BY_CREATEDAT) {
			$oQuery->orderByCreatedAt($sSortOrder);
		}
		// order all entries by name, asc after priority order, this is a fallback that probably never applies
		if($aOptions['sort_by'] !== self::SORT_BY_NAME) {
			$sSortOrder = 'asc';
		}
		return $oQuery->orderByName($sSortOrder);
	}

	public static function getCategoryOptions() {
		$oQuery = DocumentCategoryQuery::create()->orderByName();
		if(!Session::getSession()->getUser()->getIsAdmin() || Settings::getSetting('admin', 'hide_externally_managed_document_categories', true)) {
			$oQuery->filterByIsExternallyManaged(false);
		}
		$aResult = $oQuery->select(array('Id', 'Name'))->find()->toKeyValue('Id', 'Name');
		if(count($aResult) > 0 && !Settings::getSetting('admin', 'list_allows_multiple_categories', true)) {
			$aResult = array('' => ' ---- ')+$aResult;
		}
		return $aResult;
	}

	public static function getTagOptions() {
		$aResult = TagQuery::create()->filterByTagged('Document')->select(array('Id', 'Name'))->find()->toKeyValue('Id', 'Name');
		if(count($aResult) > 0 && !Settings::getSetting('admin', 'list_allows_multiple_categories', true)) {
			$aResult = array('' => ' ---- ')+$aResult;
		}
		if(count($aResult) === 0) {
			$aResult = array('' => StringPeer::getString('wns.document_list.no_tags_available'));
		}
		return $aResult;
	}

	public static function getTemplateOptions() {
		return AdminManager::getSiteTemplatesForListOutput(self::LIST_ITEM_POSTFIX);
	}

	public static function getSortOptions() {
		$aResult[self::SORT_BY_NAME] = StringPeer::getString('wns.order.by_name');
		$aResult[self::SORT_BY_SORT] = StringPeer::getString('wns.order.by_sort');
		$aResult[self::SORT_BY_CREATEDAT] = StringPeer::getString('wns.order.by_createdat');
		return $aResult;
	}

	public static function getSortOrders() {
		$aResult['asc'] = StringPeer::getString('wns.order.asc');
		$aResult['desc'] = StringPeer::getString('wns.order.desc');
		return $aResult;
	}

	public function getSaveData($mData) {
		if($this->oLanguageObject instanceof LanguageObject) {
			ReferencePeer::removeReferences($this->oLanguageObject);
			if(isset($mData['document_categories'])) {
				foreach($mData['document_categories'] as $iCategoryId) {
					ReferencePeer::addReference($this->oLanguageObject, array($iCategoryId, 'DocumentCategory'));
				}
			}
		}
		return parent::getSaveData($mData);
	}

	public static function getContentInfo($oLanguageObject) {
		if(!$oLanguageObject) {
			return null;
		}
		$aData = @unserialize(stream_get_contents($oLanguageObject->getData()));
		$aOutput = array();
		if(isset($aData['document_categories']) && is_array($aData['document_categories'])) {
			$aResult = array();
			foreach(self::getCategoryOptions() as $iCategory => $sName) {
				if(in_array($iCategory, $aData['document_categories'])) {
					$aResult[] = $sName;
				}
			}
			if(count($aResult) > 0) {
				$aOutput[] = StringPeer::getString('wns.document_category').': '.implode(', ', $aResult);
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
