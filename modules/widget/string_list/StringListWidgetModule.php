<?php
/**
 * @package modules.widget
 */
class StringListWidgetModule extends WidgetModule {
	private $oListWidget;
	private $sNameSpace;
	public $oDelegateProxy;
	
	public function __construct() {
		$this->oListWidget = new ListWidgetModule();
		$this->oDelegateProxy = new CriteriaListWidgetDelegate($this, "String", 'string_key');
		$this->oListWidget->setDelegate($this->oDelegateProxy);
	}
	
	public function doWidget() {
		$aTagAttributes = array('class' => 'string_list');
		$oListTag = new TagWriter('table', $aTagAttributes);
		$this->oListWidget->setListTag($oListTag);
		return $this->oListWidget->doWidget();
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
				$aResult['heading'] = StringPeer::getString('wns.string.string_key');
				break;
			case 'text_truncated_current':
				$aResult['heading'] = StringPeer::getString('wns.string.string_text.heading', null, 'Text', array('language_id' => AdminManager::getContentLanguage()));
				break;
			case 'languages_available':
				$aResult['heading'] = StringPeer::getString('wns.languages_filled');
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
		$sNameSpace = StringPeer::getNameSpaceFromStringKey($aRowData['id']);
		if(StringPeer::doDelete($oCriteria) && $sNameSpace !== null) {
			$bResult = !StringPeer::nameSpaceExists($sNameSpace);
		}
		return array(StringDetailWidgetModule::SIDEBAR_CHANGED => $bResult);
	}
	
	public function getDatabaseColumnForColumn($sColumnIdentifier) {
		if($sColumnIdentifier === 'name_space') {
			return StringPeer::STRING_KEY;
		}
		if($sColumnIdentifier === 'text_truncated_current') {
			return StringPeer::TEXT;
		}
		return null;
	}
	
	public function getFilterTypeForColumn($sColumnIdentifier) {
		if($sColumnIdentifier === 'name_space') {
			return CriteriaListWidgetDelegate::FILTER_TYPE_BEGINS;
		}
		return null;
	}

	public function getCriteria() {
		// @todo order by content_edit or session_default language first in order to display text that makes sense
		return StringQuery::create()->groupByStringKey();
	}
}