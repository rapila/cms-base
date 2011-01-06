<?php
/**
* @package modules.widget
*/
class GroupInputWidgetModule extends WidgetModule {
	
	public function getGroups() {
		return WidgetJsonFileModule::jsonBaseObjects(GroupPeer::getAllSorted(), array('id', 'name'));
	}
}