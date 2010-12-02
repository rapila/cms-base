<?php
class DocumentEditWidgetModule extends PersistentWidgetModule {
	private $oFrontendModule;
	private $sDisplayMode;
	
	public function __construct($sSessionKey, $oFrontendModule) {
		parent::__construct($sSessionKey);
		$this->oFrontendModule = $oFrontendModule;
		$this->sDisplayMode = $this->oFrontendModule->widgetData();
	}
	
	public function setDisplayMode($sDisplayMode) {
		$this->sDisplayMode = $sDisplayMode;
	}

	public function getDisplayMode($sKey=null) {
		if($sKey === null) {
			return $this->sDisplayMode;
		}
		if(isset($this->sDisplayMode[$sKey])) {
			return $this->sDisplayMode[$sKey];
		}
		return null;
	}
	
	public function allDocuments() {
		$aOptions = $this->sDisplayMode;
		$oCriteria = DocumentQuery::create();

		if(isset($aOptions['categories']) && is_array($aOptions['categories']) && (count($aOptions['categories']) > 0)) {
			$oCriteria->add(DocumentPeer::DOCUMENT_CATEGORY_ID, $aOptions['categories'], Criteria::IN);
		} else if(isset($aOptions['categories'])) {
			$oCriteria->add(DocumentPeer::DOCUMENT_CATEGORY_ID, $aOptions['categories']);
		}
		if(isset($aOptions['sort_option']) && $aOptions['sort_option'] === DocumentListFrontendModule::SORT_BY_SORT) {
			$oCriteria->orderBySort();
		}
		$oCriteria->orderByName();
		$oCriteria->clearSelectColumns()->addSelectColumn(DocumentPeer::ID)->addSelectColumn(DocumentPeer::NAME);
		return DocumentPeer::doSelectStmt($oCriteria)->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function getConfigurationModes() {
		$aResult = array();
		$aDocumentCategories = DocumentListFrontendModule::getCategoryOptions();
		$aResult['categories'] = $aDocumentCategories;
		$aResult['list_template'] = DocumentListFrontendModule::getTemplateOptions();
		if(count($aDocumentCategories) > 0) {
		  $aResult['sort_by'] = DocumentListFrontendModule::getSortOptions();
		}
		return $aResult;
	}
	
	public function saveData($mData) {
		return $this->oFrontendModule->widgetSave($mData);
	}
	
	public function getElementType() {
		return 'form';
	}
}