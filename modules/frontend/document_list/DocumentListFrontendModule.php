<?php
/**
 * @package modules.frontend
 */

class DocumentListFrontendModule extends DynamicFrontendModule implements WidgetBasedFrontendModule {
	
	const LIST_ITEM_POSTFIX = '_item';
	const SORT_BY_NAME = 'by_name';
	const SORT_BY_SORT = 'by_sort';
	
	public function renderFrontend() {
		$aOptions = @unserialize($this->getData());
		$oCriteria = DocumentQuery::create();
		if(!Session::getSession()->isAuthenticated()) {
			$oCriteria->filterByIsProtected(false);
		}
		if(isset($aOptions['document_categories']) && is_array($aOptions['document_categories']) && (count($aOptions['document_categories']) > 0)) {
			$oCriteria->add(DocumentPeer::DOCUMENT_CATEGORY_ID, $aOptions['document_categories'], Criteria::IN);
		} else if(isset($aOptions['document_categories'])) {
			$oCriteria->add(DocumentPeer::DOCUMENT_CATEGORY_ID, $aOptions['document_categories']);
		}
		if(isset($aOptions['sort_by']) && $aOptions['sort_by'] === self::SORT_BY_SORT) {
			$oCriteria->addAscendingOrderByColumn(DocumentPeer::SORT);
		}
		$oCriteria->addAscendingOrderByColumn(DocumentPeer::NAME);
		$aDocuments = $oCriteria->find();
		
		try {
			$oListTemplate = new Template($aOptions['list_template']);
			foreach($aDocuments as $i => $oDocument) {
				$oItemTemplate = new Template($aOptions['list_template'].self::LIST_ITEM_POSTFIX);
				$oItemTemplate->replaceIdentifier('model', 'Document');
				$oDocument->renderListItem($oItemTemplate);
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
			ReferencePeer::removeReferences($this->oLanguageObject);
			if(isset($mData['document_categories'])) {
				foreach($mData['document_categories'] as $iCategoryId) {
					ReferencePeer::addReference($this->oLanguageObject, array($iCategoryId, 'DocumentCategory'));
				}
			}
		}
		return $bResult;
	}
	
	public function getWidget() {
		$aOptions = @unserialize($this->getData()); 
		$oWidget = new DocumentEditWidgetModule(null, $this);
		$oWidget->setDisplayMode($aOptions);
		return $oWidget;
	}
	
	public static function getTemplateOptions() {
		return AdminManager::getSiteTemplatesForListOutput(self::LIST_ITEM_POSTFIX);	
	}
	
	public static function getSortOptions() {
		$aResult[self::SORT_BY_NAME] = StringPeer::getString('widget.order.by_name');
		$aResult[self::SORT_BY_SORT] = StringPeer::getString('widget.order.by_sort');
		return $aResult;
	} 
	
	public static function getContentInfo($oLanguageObject) {
		if(!$oLanguageObject) {
			return null;
		}
		$aData = @unserialize(stream_get_contents($oLanguageObject->getData()));
		if(isset($aData['document_categories']) && is_array($aData['document_categories'])) {
			$aResult = array();
			foreach(self::getCategoryOptions() as $iCategory => $sName) {
				if(in_array($iCategory, $aData['document_categories'])) {
					$aResult[] = $sName;
				}
			}
			if(count($aResult) > 0) {
				return StringPeer::getString('widget.document_category').': '.implode(', ', $aResult);
			}
		}
	}

	public static function getCategoryOptions() {
		$oCriteria = DocumentCategoryQuery::create();
		$oCriteria->orderByName();
		$oCriteria->clearSelectColumns()->addSelectColumn(DocumentCategoryPeer::ID)->addSelectColumn(DocumentCategoryPeer::NAME);
		$aResult = array();
		foreach(DocumentCategoryPeer::doSelectStmt($oCriteria)->fetchAll(PDO::FETCH_ASSOC) as $aCategory) {
			$aResult[$aCategory['ID']] = $aCategory['NAME'];
		}
		return $aResult;
	}
}
