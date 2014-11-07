<?php


/**
 * @package    propel.generator.model
 */
class UserRoleQuery extends BaseUserRoleQuery {
	public function createOrFind(User $oUser, Role $oRole) {
		$oUserRole = $this->filterByUser($oUser)->filterByRole($oRole)->findOne();
		if(!$oUserRole) {
			$oUserRole = new UserRole();
			$oUserRole->setRole($oRole);
			$oUserRole->setUser($oUser);
			$oUserRole->save();
		}
		return $oUserRole;
	}
}

