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
}

