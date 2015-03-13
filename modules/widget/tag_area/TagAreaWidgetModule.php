<?php

/**
* @package widget
*/

class TagAreaWidgetModule extends PersistentWidgetModule {

	const USE_NAMESPACED_CSS = false;

	private $sModelName;
	private $mTaggedItemId;

	public function listTags() {
		$oQuery = TagQuery::create();
		$oQuery->filterByTagged($this->sModelName, $this->mTaggedItemId);
		return $oQuery->find()->toArray();
	}

	public function deleteTag($sTagName) {
		if($this->sModelName === null || $this->mTaggedItemId === null) {
			throw new Exception('Can only delete specific tags');
		}
		$sModel = $this->sModelName;
		$sInstanceModel = $sModel::TAG_INSTANCE_MODEL_NAME;
		$sInstanceQuery = "${sInstanceModel}Query";
		$oTag = $sInstanceQuery::create()->filterByModelName($this->sModelName)->filterByTaggedItemId($this->mTaggedItemId)->useTagQuery()->filterByName($sTagName)->endUse()->findOne();
		$oResult = new stdClass();
		$oResult->model_name = $this->sModelName;
		$oResult->tagged_item_id = $this->mTaggedItemId;
		if(!$oTag) {
			$oResult->is_removed = false;
			$oResult->is_removed_from_model = false;
		} else {
			$oTag->delete();
			$oQuery = $sInstanceQuery::create()->useTagQuery()->filterByName($sTagName)->endUse();
			$oResult->is_removed = $oQuery->count() === 0;
			$oResult->is_removed_from_model = $oResult->is_removed || $oQuery->filterByModelName($this->sModelName)->count() === 0;
			$oResult->was_last_of_model = $oResult->is_removed_from_model && $sInstanceQuery::create()->filterByModelName($this->sModelName)->count() === 0;
		}
		return $oResult;
	}

	public function tagId($sTagName) {
		$oTag = TagQuery::create()->filterByName($sTagName)->findOne();
		if($oTag === null) {
			return null;
		}
		return $oTag->getId();
	}

	public function setModelName($sModelName) {
		$this->sModelName = $sModelName;
	}

	public function getModelName() {
		return $this->sModelName;
	}

	public function setTaggedItemId($mTaggedItemId) {
		$this->mTaggedItemId = $mTaggedItemId;
	}

	public function getTaggedItemId() {
		return $this->mTaggedItemId;
	}
}