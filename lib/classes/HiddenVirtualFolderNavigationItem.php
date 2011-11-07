<?php
/**
 * @package navigation
 */
class HiddenVirtualFolderNavigationItem extends VirtualNavigationItem {
	public function isVisible() {
		return false;
	}
	public function isFolder() {
		return true;
	}
}
