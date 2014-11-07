<?php


/**
 * @package    propel.generator.model
 */
class RoleQuery extends BaseRoleQuery {
	public function createOrFindPk($sRoleKey) {
		$oRole = $this->findPk($sRoleKey);
		if(!$oRole) {
			$oRole = new Role();
			$oRole->setRoleKey($sRoleKey);
			$oRole->save();
		}
		return $oRole;
	}
}

