<?php
/**
 * @package modules.frontend
 */

class DocumentListFrontendModule extends DynamicFrontendModule implements WidgetBasedFrontendModule {
	
	const LIST_ITEM_POSTFIX = '_item';
	const SORT_OPTION_BY_NAME = 'by_name';
	const SORT_OPTION_BY_SORT = 'by_sort';
	
	public function renderFrontend() {
		$aOptions = @unserialize($this->getData());
		$oCriteria = DocumentQuery::create();
		if(!Session::getSession()->isAuthenticated()) {
			$oCriteria->filterByIsProtected(false);
		}
		if(isset($aOptions['document_category_option']) && is_array($aOptions['document_category_option']) && (count($aOptions['document_category_option']) > 0)) {
			$oCriteria->add(DocumentPeer::DOCUMENT_CATEGORY_ID, $aOptions['document_category_option'], Criteria::IN);
		}
		if(isset($aOptions['sort_option']) && $aOptions['sort_option'] === self::SORT_OPTION_BY_SORT) {
			$oCriteria->addAscendingOrderByColumn(DocumentPeer::SORT);
		}
		$oCriteria->addAscendingOrderByColumn(DocumentPeer::NAME);
		$aDocuments = $oCriteria->find();
		
		try {
			$oListTemplate = new Template($aOptions['template_option']);
			foreach($aDocuments as $i => $oDocument) {
				$oItemTemplate = new Template($aOptions['template_option'].self::LIST_ITEM_POSTFIX);
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
		return $this->oLanguageObject->save();
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
		$aResult[self::SORT_OPTION_BY_NAME] = StringPeer::getString('widget.order.by_name');
		$aResult[self::SORT_OPTION_BY_SORT] = StringPeer::getString('widget.order.by_sort');
		return $aResult;
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
