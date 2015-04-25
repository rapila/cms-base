<?php
/**
 * @package modules.widget
 */
class LanguageListWidgetModule extends SpecializedListWidgetModule {
	private $oDelegateProxy;

	protected function createListWidget() {
		$oListWidget = new ListWidgetModule();
		$this->oDelegateProxy = new CriteriaListWidgetDelegate($this, "Language", 'language_id', 'asc');
		$oListWidget->setDelegate($this->oDelegateProxy);
		return $oListWidget;
	}

	public function toggleIsActive($aRowData) {
		$oLanguage = LanguageQuery::create()->findPk($aRowData['id']);
		if($oLanguage) {
			$oLanguage->setIsActive(!$oLanguage->getIsActive());
			$oLanguage->save();
		}
	}

	public function allowSort($sSortColumn) {
		return true;
	}

	public function doSort($sColumnIdentifier, $oLanguageToSort, $oRelatedLanguage, $sPosition = 'before') {
		$iNewPosition = $oRelatedLanguage->getSort() + ($sPosition === 'before' ? 0 : 1);
		if($oLanguageToSort->getSort() < $oRelatedLanguage->getSort()) {
			$iNewPosition--;
		}
		$oLanguageToSort->setSort($iNewPosition);
		$oLanguageToSort->save();
		$oQuery = $this->oDelegateProxy->getCriteria();
		$oQuery->filterById($oLanguageToSort->getId(), Criteria::NOT_EQUAL);
		$oQuery->orderBySort();
		$i = 1;
		foreach($oQuery->find() as $oLanguage) {
			if($i == $iNewPosition) {
				$i++;
			}
			$oLanguage->setSort($i);
			$oLanguage->save();
			$i++;
		}
	}
	public function deleteRow($aRowData, $oCriteria) {
		$oLanguage = LanguagePeer::doSelectOne($oCriteria);
		if($oLanguage->getIsDefault()) {
			throw new LocalizedException('wns.language.delete_default.denied');
		}
		if($oLanguage->getIsDefaultEdit()) {
			throw new LocalizedException('wns.language.delete_default.denied');
		}
		if(LanguagePeer::doCount(new Criteria()) < 2) {
			throw new LocalizedException('wns.language.delete_last.denied');
		}
		$sLanguageId = $oLanguage->getId();
		foreach(LanguageObjectQuery::create()->filterByLanguageId($sLanguageId)->find() as $oLanguageObject) {
			$oHistory = $oLanguageObject->newHistory();
			$oHistory->save();
			$oLanguageObject->delete();
		}
		$iResult = $oLanguage->delete();
		$oReplacementLanguage = LanguageQuery::create()->findOne();
		if(AdminManager::getContentLanguage() === $sLanguageId) {
			AdminManager::setContentLanguage(Settings::getSetting("session_default", AdminManager::CONTENT_LANGUAGE_SESSION_KEY, $oReplacementLanguage->getId()));
		}
		if(Session::language() === $sLanguageId) {
			Session::getSession()->setLanguage(Settings::getSetting("session_default", Session::SESSION_LANGUAGE_KEY, $oReplacementLanguage->getId()));
		}
	}

	public function getColumnIdentifiers() {
		return array('id', 'language_id', 'name', 'path_prefix', 'is_default', 'is_default_edit', 'is_active', 'sort', 'delete');
	}

	public function getMetadataForColumn($sColumnIdentifier) {
		$aResult = array();
		switch($sColumnIdentifier) {
			case 'id':
				$aResult['display_type'] = ListWidgetModule::DISPLAY_TYPE_DATA;
				break;
			case 'language_id':
				$aResult['heading'] = StringPeer::getString('wns.language_id');
				$aResult['field_name'] = 'id';
				$aResult['is_sortable'] = true;
				break;
			case 'name':
				$aResult['heading'] = StringPeer::getString('wns.name');
				$aResult['field_name'] = 'language_name';
				break;
			case 'path_prefix':
				$aResult['heading'] = StringPeer::getString('wns.language.path_prefix');
				break;
			case 'is_default':
				$aResult['heading'] = StringPeer::getString('wns.language.is_default');
				break;
			case 'is_default_edit':
				$aResult['heading'] = StringPeer::getString('wns.language.is_default_edit');
				break;
			case 'sort':
				$aResult['heading'] = StringPeer::getString('wns.sort');
				$aResult['display_type'] = ListWidgetModule::DISPLAY_TYPE_REORDERABLE;
				break;
			case 'is_active':
				$aResult['heading'] = StringPeer::getString('wns.is_active');
				$aResult['is_sortable'] = true;
				break;
			case 'delete':
				$aResult['heading'] = ' ';
				$aResult['display_type'] = ListWidgetModule::DISPLAY_TYPE_ICON;
				$aResult['field_name'] = 'trash';
				break;
		}
		return $aResult;
	}

	public function getCriteria() {
		return LanguageQuery::create();
	}
}
