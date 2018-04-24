<?php
/**
 * @package modules.widget
 */
class TagListWidgetModule extends SpecializedListWidgetModule {

	public $oDelegateProxy;

	protected function createListWidget() {
		$oListWidget = new ListWidgetModule();
		$this->oDelegateProxy = new CriteriaListWidgetDelegate($this, "Tag", 'name');
		$oListWidget->setDelegate($this->oDelegateProxy);
		return $oListWidget;
	}

	public function getColumnIdentifiers() {
		return array('id', 'name', 'tag_instance_count', 'language_ids_of_strings', 'delete');
	}

	public function getMetadataForColumn($sColumnIdentifier) {
		$aResult = array('is_sortable' => false);
		switch($sColumnIdentifier) {
			case 'id':
				$aResult['heading'] = false;
				$aResult['display_type'] = ListWidgetModule::DISPLAY_TYPE_DATA;
				break;
			case 'name':
				$aResult['heading'] = TranslationPeer::getString('wns.tag.name');
				$aResult['is_sortable'] = true;
				break;
			case 'tag_instance_count':
				$aResult['heading'] = TranslationPeer::getString('wns.tag.instance_count');
				$aResult['display_type'] = ListWidgetModule::DISPLAY_TYPE_NUMERIC;
				$aResult['args'] = function() {
					$sTagModelName = $this->oDelegateProxy->getTagModelName();
					if($sTagModelName === CriteriaListWidgetDelegate::SELECT_ALL) {
						$sTagModelName = null;
					}
					return [$sTagModelName];
				};
				break;
			case 'language_ids_of_strings':
				$aResult['heading'] = TranslationPeer::getString('wns.tag.available_strings');
				break;
			case 'delete':
				$aResult['heading'] = ' ';
				$aResult['display_type'] = ListWidgetModule::DISPLAY_TYPE_ICON;
				$aResult['field_name'] = 'trash';
				break;
		}
		return $aResult;
	}

	public function getFilterTypeForColumn($sFilterColumn) {
		if($sFilterColumn === 'tag_model_name') {
			return CriteriaListWidgetDelegate::FILTER_TYPE_MANUAL;
		}
	}

	public function deleteRow($aRowData, $oCriteria) {
		$iTagId = $aRowData['id'];
		$sTagModelName = $this->oDelegateProxy->getTagModelName();
		$bSidebarChanged = true;
		if($sTagModelName && $sTagModelName !== CriteriaListWidgetDelegate::SELECT_ALL) {
			// Delete all matching tags
			TagInstanceQuery::create()->filterByTagId($iTagId)->filterByModelName($sTagModelName)->delete();
			// Check if other tags are still available
			if(TagInstanceQuery::create()->filterByModelName($sTagModelName)->count() > 0) {
				$bSidebarChanged = false;
			}
			// Clean up
			if(TagInstanceQuery::create()->filterByTagId($iTagId)->count() === 0) {
				TagQuery::create()->findPk($iTagId)->delete();
			}
		} else {
			TagQuery::create()->findPk($iTagId)->delete();
		}
		return array(TagDetailWidgetModule::SIDEBAR_CHANGED => $bSidebarChanged);
	}

	public function getCriteria() {
		$oQuery = TagQuery::create();
		$aExcludes = array(CriteriaListWidgetDelegate::SELECT_ALL, 'Tag');
		if($this->oDelegateProxy->getTagModelName() !== CriteriaListWidgetDelegate::SELECT_ALL) {
			$oQuery->distinct()->joinTagInstance()->useQuery('TagInstance')->filterByModelName($this->oDelegateProxy->getTagModelName())->endUse();
		}
		return $oQuery;
	}

}