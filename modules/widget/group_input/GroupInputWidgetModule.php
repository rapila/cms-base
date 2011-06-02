<?php
/**
* @package modules.widget
*/
class GroupInputWidgetModule extends WidgetModule {
	
	public function allGroups() {
		return WidgetJsonFileModule::jsonBaseObjects(GroupPeer::getAllSorted(), array('id', 'name'));
	}
}