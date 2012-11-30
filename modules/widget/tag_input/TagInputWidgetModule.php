<?php
class TagInputWidgetModule extends PersistentWidgetModule {
	
	var $sSelectedTagId;
	
	public function __construct($sWidgetId) {
		parent::__construct($sWidgetId);
	}
	
	public function getTags($sModelName) {
		$oQuery = TagQuery::create()->filterByTaggedModel($sModelName);
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