<?php
/**
 * @package modules.widget
 */
class PageInputWidgetModule extends WidgetModule {
	
	public function getPages() {
		return PagePeer::getRootPage()->getTree(true);
	}
	
  public function getElementType() {
		return 'select';
	}

}