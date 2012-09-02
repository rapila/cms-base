<?php


/**
 * @package    propel.generator.model
 */
class TagQuery extends BaseTagQuery {
	
	public function filterByTaggedModel($sModelName) {
		$this->setDistinct();
		$this->innerJoinTagInstance();
		$this->add(TagInstancePeer::MODEL_NAME, $sModelName);
		return $this;
	}
	
	public function filterByTaggedItem($mItemId) {
		$this->setDistinct();
		$this->innerJoinTagInstance();
		$this->add(TagInstancePeer::TAGGED_ITEM_ID, $mItemId);
		return $this;
	}
	
	public function exclude($iTagId) {
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
	public function withTagInstanceCountFilteredByModel($sModelName = null, $aIncludeIds = array()) {
		$this->joinTagInstance();
		if($sModelName !== null || $aIncludeIds) {
			if($sModelName !== null && $aIncludeIds) {
				$this->useQuery('TagInstance')->filterByModelName($sModelName)->filterByTaggedItemId($aIncludeIds)->endUse();
			} elseif($sModelName) {
				$this->useQuery('TagInstance')->filterByModelName($sModelName)->endUse();
			} else {
				$this->useQuery('TagInstance')->filterByTaggedItemId($aIncludeIds)->endUse();
			}
		}
		$this->withColumn('COUNT('.TagInstancePeer::TAGGED_ITEM_ID.')', 'TagInstanceCount');
		$this->groupById();
		return $this;
	}


}

