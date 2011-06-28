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
	
	public function allDocuments($aOptions = array()) {
		$oCriteria = DocumentQuery::create();
		$aCategories = array();
		if(count($aOptions) === 0) {
			$aOptions = $this->getDisplayMode();
		}
		if(isset($aOptions['document_categories'])) {
			if(is_array($aOptions['document_categories']) ) {
				$aCategories = $aOptions['document_categories'];
			} else {
				$aCategories = array($aOptions['document_categories']);
			}
		}
		if(count($aCategories) > 0) {
			if(count($aCategories > 1)) {
				$oCriteria->add(DocumentPeer::DOCUMENT_CATEGORY_ID, $aOptions['document_categories'], Criteria::IN);
			} else {
				$oCriteria->add(DocumentPeer::DOCUMENT_CATEGORY_ID, $aCategories[0]);
			}
		}
		if(isset($aOptions['sort_by']) && $aOptions['sort_by'] === DocumentListFrontendModule::SORT_BY_SORT) {
			$oCriteria->orderBySort();
		}
		$oCriteria->orderByName();
		$oCriteria->clearSelectColumns()->addSelectColumn(DocumentPeer::ID)->addSelectColumn(DocumentPeer::NAME);
		return DocumentPeer::doSelectStmt($oCriteria)->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function getConfigurationModes() {
		$aResult = array();
		$aDocumentCategories = DocumentListFrontendModule::getCategoryOptions();
		$aResult['document_categories'] = $aDocumentCategories;
		$aResult['template'] = DocumentListFrontendModule::getTemplateOptions();
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