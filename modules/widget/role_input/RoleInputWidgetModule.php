<?php
/**
 * @package modules.widget
 */
class RoleInputWidgetModule extends WidgetModule {

	public function allRoles() {
		$oCriteria = new Criteria();
		$oCriteria->addAscendingOrderByColumn(RolePeer::ROLE_KEY);
		return WidgetJsonFileModule::jsonBaseObjects(RolePeer::doSelect($oCriteria), array('role_key', 'description'));
	}
}
