<?php


/**
 * @package    propel.generator.model
 */
class UserQuery extends BaseUserQuery {
	
	public function isActive() {
		return $this->filterByIsInactive(false);
	}
}

