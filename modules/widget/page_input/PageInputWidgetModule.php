<?php
/**
 * @package modules.widget
 */
class PageInputWidgetModule extends WidgetModule {
	
	public function pages() {
		return PagePeer::getRootPage()->getTree(true);
	}
	
  public function getElementType() {
		return 'select';
	}

}
