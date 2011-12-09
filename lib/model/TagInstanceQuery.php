<?php


/**
 * @package    propel.generator.model
 */
class TagInstanceQuery extends BaseTagInstanceQuery {
	public function filterByTagName($sTagName) {
		$this->innerJoinTag();
		$this->add(TagPeer::NAME, $sTagName);
		return $this;
	}
}

