<?php
/**
 * @package modules.widget
 */
class LinkListWidgetModule extends SpecializedListWidgetModule {

	protected $oLanguageFilter;
	protected $oTagFilter;
	public $oDelegateProxy;

	protected function createListWidget() {
		$oListWidget = new ListWidgetModule();
		$this->oDelegateProxy = new CriteriaListWidgetDelegate($this, "Link", "name_truncated", "asc");
		$oListWidget->setDelegate($this->oDelegateProxy);
		$oListWidget->setSetting('row_model_drag_and_drop_identifier', 'id');
		if(!LanguageInputWidgetModule::isMonolingual()) {
			$this->oLanguageFilter = WidgetModule::getWidget('language_input', null, true);
		}
		$this->oTagFilter = WidgetModule::getWidget('tag_input', null, true);
		$this->oTagFilter->setSetting('model_name', 'Link');
		return $oListWidget;
	}

	protected static function hasTags() {
		return TagInstanceQuery::create()->filterByModelName('Link')->count() > 0;
	}

	public function getColumnIdentifiers() {
		$aResult = array('id', 'name_truncated', 'sort', 'url');
		if(LinkCategoryQuery::create()->count() > 0) {
			$aResult[] = 'category_name';
		}
		if($this->oLanguageFilter !== null) {
			$aResult[] = 'language_id';
		}
		if(self::hasTags()) {
			$aResult[] = 'has_tags';
		} else {
			$this->oDelegateProxy->getListSettings()->setFilterColumnValue('has_tags', CriteriaListWidgetDelegate::SELECT_ALL);
		}
		return array_merge($aResult, array('updated_at_formatted', 'delete'));
	}

	public function getMetadataForColumn($sColumnIdentifier) {
		$aResult = array('is_sortable' => true);
		switch($sColumnIdentifier) {
			case 'sort':
				$aResult['heading'] = TranslationPeer::getString('wns.sort');
				$aResult['display_type'] = ListWidgetModule::DISPLAY_TYPE_REORDERABLE;
				break;
			case 'name_truncated':
				$aResult['heading'] = TranslationPeer::getString('wns.name');
				break;
			case 'url':
				$aResult['heading'] = TranslationPeer::getString('wns.url');
				$aResult['display_type'] = ListWidgetModule::DISPLAY_TYPE_URL;
				break;
			case 'has_tags':
				$aResult['heading'] = '';
				$aResult['heading_filter'] = array('tag_input', $this->oTagFilter->getSessionKey());
				$aResult['is_sortable'] = false;
				break;
			case 'category_name':
				$aResult['heading'] = TranslationPeer::getString('wns.link_category_list');
				break;
			case 'language_id':
				$aResult['heading'] = '';
				$aResult['heading_filter'] = array('language_input', $this->oLanguageFilter->getSessionKey());
				$aResult['is_sortable'] = false;
				$aResult['field_name'] = 'language_name';
				break;
			case 'updated_at_formatted':
				$aResult['heading'] = TranslationPeer::getString('wns.updated_at');
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

	public function getFilterTypeForColumn($sColumnIdentifier) {
		if($sColumnIdentifier === 'link_category_id') {
			return CriteriaListWidgetDelegate::FILTER_TYPE_IS;
		}
		if($sColumnIdentifier === 'language_id') {
			return CriteriaListWidgetDelegate::FILTER_TYPE_IS;
		}
		if($sColumnIdentifier === 'has_tags') {
			return CriteriaListWidgetDelegate::FILTER_TYPE_MANUAL;
		}
		return null;
	}

	public function getDatabaseColumnForColumn($sColumnIdentifier) {
		if($sColumnIdentifier === 'category_name') {
			return LinkPeer::LINK_CATEGORY_ID;
		}
		if($sColumnIdentifier === 'updated_at_formatted') {
			return LinkPeer::UPDATED_AT;
		}
		if($sColumnIdentifier === 'description_truncated') {
			return LinkPeer::DESCRIPTION;
		}
		if($sColumnIdentifier === 'name_truncated') {
			return LinkPeer::NAME;
		}
		return null;
	}

	public function getLinkCategoryId() {
		return $this->oDelegateProxy->getLinkCategoryId();
	}

	public function getLanguageName() {
		return TranslationPeer::getString('language.'.$this->oDelegateProxy->getLanguageId(), null, $this->oDelegateProxy->getLanguageId());
	}

	public function getLinkCategoryName() {
		$oLinkCategory = LinkCategoryQuery::create()->findPk($this->oDelegateProxy->getLinkCategoryId());
		if($oLinkCategory) {
			return $oLinkCategory->getName();
		}
		if($this->oDelegateProxy->getLinkCategoryId() === CriteriaListWidgetDelegate::SELECT_WITHOUT) {
			return TranslationPeer::getString('wns.links.without_category');
		}
		return $this->oDelegateProxy->getLinkCategoryId();
	}

	public function getTagName() {
		if($iTagId = $this->oDelegateProxy->getListSettings()->getFilterColumnValue('has_tags')) {
			return TagQuery::create()->filterById($iTagId)->select(['Name'])->findOne();
		}
		return null;
	}

  public function allowSort($sSortColumn) {
		return $this->oDelegateProxy->getLinkCategoryId() !== CriteriaListWidgetDelegate::SELECT_ALL;
	}

	public function doSort($sColumnIdentifier, $oLinkToSort, $oRelatedLink, $sPosition = 'before') {
		$iNewPosition = $oRelatedLink->getSort() + ($sPosition === 'before' ? 0 : 1);
		if($oLinkToSort->getSort() < $oRelatedLink->getSort()) {
			$iNewPosition--;
		}
		$oLinkToSort->setSort($iNewPosition);
		$oLinkToSort->save();
		$oQuery = $this->oDelegateProxy->getCriteria();
		$oQuery->filterById($oLinkToSort->getId(), Criteria::NOT_EQUAL);
		$oQuery->orderBySort();
		$i = 1;
		foreach($oQuery->find() as $oLink) {
			if($i == $iNewPosition) {
				$i++;
			}
			$oLink->setSort($i);
			$oLink->save();
			$i++;
		}
	}

	public function getCategoryHasLinks($iLinkCategoryId) {
		return LinkQuery::create()->filterByLinkCategoryId($iLinkCategoryId)->count() > 0;
	}

	public function getCriteria() {
		$oQuery = LinkQuery::create();
		if(!Session::getSession()->getUser()->getIsAdmin() || Settings::getSetting('admin', 'hide_externally_managed_link_categories', true)) {
			$oQuery->excludeExternallyManaged();
		}
		if($this->oTagFilter && $this->oDelegateProxy->getListSettings()->getFilterColumnValue('has_tags') !== CriteriaListWidgetDelegate::SELECT_ALL) {
			$oQuery->filterByTagName($this->oDelegateProxy->getListSettings()->getFilterColumnValue('has_tags'));
		}
		return $oQuery;
	}
}
