<?php

/**
 * @package    propel.generator.model
 */
class LinkCategoryQuery extends BaseLinkCategoryQuery {
	
	public function filterByHasLinks($bHasLinks=true) {
		if($bHasLinks) {
			$this->distinct()->joinLink(null, Criteria::INNER_JOIN);
		}
		return $this;
	}
}

