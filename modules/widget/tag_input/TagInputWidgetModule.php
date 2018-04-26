<?php
class TagInputWidgetModule extends PersistentWidgetModule {

	var $sSelectedTagId;

	public function __construct($sWidgetId) {
		parent::__construct($sWidgetId);
	}

	public function getTags($sModelName) {
		$sQuery = $sModelName::TAG_MODEL_NAME.'Query';
		$oQuery = $sQuery::create()->distinct()->useTagInstanceQuery()->filterByModelName($sModelName)->endUse();
		return $oQuery->find()->toKeyValue('Id', 'Name');
	}

	public function setSelectedTagId($sSelectedTagId) {
		if($sSelectedTagId === '') {
			$sSelectedTagId = null;
		}
		$this->sSelectedTagId = $sSelectedTagId;
	}

	public function getSelectedTagId() {
		return $this->sSelectedTagId;
	}

	public function getElementType() {
		return 'select';
	}
}