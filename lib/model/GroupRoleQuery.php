<?php


/**
 * @package    propel.generator.model
 */
class GroupRoleQuery extends BaseGroupRoleQuery {
	public function createOrFind(Group $oGroup, Role $oRole) {
		$oGroupRole = $this->filterByGroup($oGroup)->filterByRole($oRole)->findOne();
		if(!$oGroupRole) {
			$oGroupRole = new GroupRole();
			$oGroupRole->setRole($oRole);
			$oGroupRole->setGroup($oGroup);
			$oGroupRole->save();
		}
		return $oGroupRole;
	}
}

