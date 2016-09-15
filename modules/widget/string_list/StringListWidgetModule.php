<?php
/**
 * @package modules.widget
 */
class StringListWidgetModule extends SpecializedListWidgetModule {

	public $oDelegateProxy;

	protected function createListWidget() {
		$oListWidget = new ListWidgetModule();
		$this->oDelegateProxy = new CriteriaListWidgetDelegate($this, "String", 'string_key');
		$oListWidget->setDelegate($this->oDelegateProxy);
		return $oListWidget;
	}

	public function getColumnIdentifiers() {
		return array('id', 'string_key', 'text_truncated_current', 'languages_available', 'delete');
	}

	public function getMetadataForColumn($sColumnIdentifier) {
		$aResult = array('is_sortable' => true);
		switch($sColumnIdentifier) {
			case 'id':
				$aResult['heading'] = false;
				$aResult['field_name'] = 'string_key';
				$aResult['display_type'] = ListWidgetModule::DISPLAY_TYPE_DATA;
				break;
			case 'string_key':
				$aResult['heading'] = TranslationPeer::getString('wns.string.string_key');
				break;
			case 'text_truncated_current':
				$aResult['heading'] = TranslationPeer::getString('wns.string.string_text.heading', null, 'Text', array('language_id' => AdminManager::getContentLanguage()));
				break;
			case 'languages_available':
				$aResult['heading'] = TranslationPeer::getString('wns.languages_filled');
				$aResult['is_sortable'] = false;
				break;
			case 'delete':
				$aResult['heading'] = ' ';
				$aResult['display_type'] = ListWidgetModule::DISPLAY_TYPE_ICON;
				$aResult['field_name'] = 'trash';
				$aResult['is_sortable'] = false;
				break;
		}
		return $aResult;
	}

	public function deleteRow($aRowData, $oCriteria) {
		$bResult = false;
		$sNameSpace = TranslationPeer::getNameSpaceFromStringKey($aRowData['id']);
		if(TranslationPeer::doDelete($oCriteria) && $sNameSpace !== null) {
			$bResult = !TranslationPeer::nameSpaceExists($sNameSpace);
		}
		return array(StringDetailWidgetModule::SIDEBAR_CHANGED => $bResult);
	}

	public function getDatabaseColumnForColumn($sColumnIdentifier) {
		if($sColumnIdentifier === 'name_space') {
			return TranslationPeer::STRING_KEY;
		}
		if($sColumnIdentifier === 'text_truncated_current') {
			return TranslationPeer::TEXT;
		}
		return null;
	}

	public function getFilterTypeForColumn($sColumnIdentifier) {
		if($sColumnIdentifier === 'name_space') {
			return CriteriaListWidgetDelegate::FILTER_TYPE_MANUAL;
		}
		return null;
	}

	public function getCriteria() {
		$oQuery = TranslationQuery::create();
		if($this->oDelegateProxy->getNameSpace() === CriteriaListWidgetDelegate::SELECT_WITHOUT) {
			return $oQuery->filterByKeysWithoutNamespace();
		} elseif($this->oDelegateProxy->getNameSpace() !== CriteriaListWidgetDelegate::SELECT_ALL) {
			$oQuery->filterByNamespace($this->oDelegateProxy->getNameSpace());
		}
		return $oQuery->groupByStringKey();
	}
}