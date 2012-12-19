<?php


/**
 * @package    propel.generator.model
 */
class UserGroupQuery extends BaseUserGroupQuery {
	
	public function filterByRole($oRole) {
		return $this->useGroupQuery()->useGroupRoleQuery()->filterByRole($oRole)->endUse()->endUse();
	}
}

