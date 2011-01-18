<?php


/**
 * Skeleton subclass for performing query and update operations on the 'tags' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
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
} // TagQuery
