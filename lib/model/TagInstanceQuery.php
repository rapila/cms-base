<?php


/**
 * @package    propel.generator.model
 */
class TagInstanceQuery extends BaseTagInstanceQuery {
	
	public function filterByTagName($mTagName) {
		$this->innerJoinTag();
		if(!is_array($mTagName)) {
			$this->add(TagPeer::NAME, $mTagName);
		} else {
			foreach($mTagName as $sTagName) {
				$this->add(TagPeer::NAME, $sTagName);
			}
		}
		return $this;
	}
}

