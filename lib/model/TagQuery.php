<?php


/**
 * @package    propel.generator.model
 */
class TagQuery extends BaseTagQuery {
	
	public function filterByTagged($sModel = null, $iId = null) {
		$q = $this->distinct()->useTagInstanceQuery();
		$q->filterByTagged($sModel, $iId);
		$q->endUse();
		return $this;
	}
	
	/**
	* @deprecated use filterByTagged($sModelName)
	*/
	public function filterByTaggedModel($sModelName) {
		return $this->filterByTagged($sModelName);
	}
	
	/**
	* Shortcut for filterByTagged(null, $mItemId);
	* NOTE: This method does not make much sense: ids are not guaranteed to be unique across models.
	*/
	public function filterByTaggedItem($mItemId) {
		return $this->distinct()->useTagInstanceQuery()->filterByTaggedItemId($mItemId)->endUse();
	}
	
	/**
	* @deprecated use filterByTagged($sModelName, $mItemId)
	*/
	public function filterByTaggedModelAndId($sModelName, $mItemId) {
		return $this->filterByTagged($sModelName, $mItemId);
	}
	
	public function exclude($iTagId) {
		if(is_array($iTagId)) {
			return $this->filterById($iTagId, Criteria::NOT_IN);
		}
		return $this->filterById($iTagId, Criteria::NOT_EQUAL);
	}
	/**
	* withTagInstanceCountFilteredByModel()
	* 
	* @param string model name, optional
	* @param array tagged_item_id, optional
	* 
	* Description
	* we need both model and included tagged_item_ids in order to create a list of tags
	* that are usefull in the context, i.e. journal. All Tags should be related to entries of the configured journal
	* return $this
	*/
	public function withTagInstanceCountFilteredByModel($sModelName = null, $aAllowedTaggedItemIds = array()) {
		$this->joinTagInstance();
		if($sModelName !== null || $aAllowedTaggedItemIds) {
			if($sModelName !== null && $aAllowedTaggedItemIds) {
				$this->useQuery('TagInstance')->filterByModelName($sModelName)->filterByTaggedItemId($aAllowedTaggedItemIds)->endUse();
			} elseif($sModelName) {
				$this->useQuery('TagInstance')->filterByModelName($sModelName)->endUse();
			} else {
				$this->useQuery('TagInstance')->filterByTaggedItemId($aAllowedTaggedItemIds)->endUse();
			}
		}
		$this->withColumn('COUNT('.TagInstancePeer::TAGGED_ITEM_ID.')', 'TagInstanceCount');
		$this->groupById();
		return $this;
	}


}

