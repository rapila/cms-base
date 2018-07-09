<?php

/**
* @package widget
*/

class TagAreaWidgetModule extends PersistentWidgetModule {

	const USE_NAMESPACED_CSS = false;

	private $sModelName;
	private $mTaggedItemId;

	public function listTags($sAdminModuleName = null) {
		$oQuery = TagQuery::create();
		$sModelName = $this->sModelName;
		if($this->sModelName && $this->mTaggedItemId) {
			return $sModelName::tagsFor($this->mTaggedItemId, 'names');
		}

		// list only tags related to local principal model in case of config use_tags_globally = false
		$sPrincipalModel = null;
		if($sAdminModuleName !== null && !Settings::getSetting('admin', 'use_tags_globally', true)) {
			$sAdminModuleClass = AdminModule::getClassNameByName($sAdminModuleName);
			$cModelFunction = "$sAdminModuleClass::getPrincipalModel";
			if(is_callable($cModelFunction)) {
				$sPrincipalModel = $cModelFunction();
			}
		}

		$aTagModels = Settings::getSetting('admin', 'tag_models', 'Tag');
		if(!is_array($aTagModels)) {
			$aTagModels = array($aTagModels);
		}
		$aResult = array();
		foreach($aTagModels as $sTagModel) {
			$sQuery = "${sTagModel}Query";
			if($sPrincipalModel === null) {
				$oQuery = $sQuery::create()->select(['name']);
			} else {
				$sInstanceClassName = "${sTagModel}Instance";
				$sJoinMethodName = "join${sInstanceClassName}";
				$oQuery = $sQuery::create()->$sJoinMethodName()->useQuery($sInstanceClassName)->filterByModelName($sPrincipalModel)->endUse();
			}
			$aResult = array_merge($aResult, $oQuery->select(['name'])->find()->getArrayCopy());
		}
		$aResult = array_unique($aResult);
		sort($aResult);
		return $aResult;
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