<?php
/**
* @package modules.widget
*/
class GroupInputWidgetModule extends WidgetModule {

	public function allGroups() {
		return WidgetJsonFileModule::jsonBaseObjects(GroupQuery::create()->orderByName()->find(), array('id', 'name'));
	}
}