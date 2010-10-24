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

		if(isset($aOptions['document_category_option']) && $aOptions['document_category_option'] != null) {
			$oCriteria->add(DocumentPeer::DOCUMENT_CATEGORY_ID, $aOptions['document_category_option']);
		}
		if(isset($aOptions['sort_option']) && $aOptions['sort_option'] === DocumentListFrontendModule::SORT_OPTION_BY_SORT) {
			$oCriteria->orderBySort();
		}
		$oCriteria->orderByName();
		$oCriteria->clearSelectColumns()->addSelectColumn(DocumentPeer::ID)->addSelectColumn(DocumentPeer::NAME);
		return DocumentPeer::doSelectStmt($oCriteria)->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function getConfigurationModes() {
		$aResult = array();
		$aResult['document_category_option'] = DocumentListFrontendModule::getCategoryOptions();
		$aResult['template_option'] = DocumentListFrontendModule::getTemplateOptions();
		$aResult['sort_option'] = DocumentListFrontendModule::getSortOptions();
		return $aResult;
	}
	
	public function saveData($mData) {
		return $this->oFrontendModule->widgetSave($mData);
	}
	
	public function getElementType() {
		return 'form';
	}
}