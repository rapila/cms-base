<?php
/**
 * @package navigation
 */
class HiddenVirtualNavigationItem extends VirtualNavigationItem {
	public function isVisible() {
		return false;
	}
}
