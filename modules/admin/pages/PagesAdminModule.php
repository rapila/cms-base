<?php
/**
 * @package modules.admin
 */
class PagesAdminModule extends AdminModule {
	
	private $oTreeWidget;
	
	public function __construct() {
		$this->oTreeWidget = new TreeWidgetModule();
		$this->oTreeWidget->setDelegate($this);
		$this->oTreeWidget->setOrdered(true);
		$this->addResourceParameter(ResourceIncluder::RESOURCE_TYPE_JS, 'tree_session', $this->oTreeWidget->getSessionKey());
	}
	
	public function mainContent() {
		// return page details
	}	
	
	public function sidebarContent() {
		// return $this->oTreeWidget->doWidget();
	}

	public function usedWidgets() {
		return array($this->oTreeWidget);
	}
	
	public function listChildren($iId) {
		$oParentPage = null;
		if($iId === null) {
			$oParentPage = PagePeer::getRootPage();
		} else {
			$oParentPage = PagePeer::retrieveByPK($iId);
		}
		return $oParentPage->getChildren()->toArray();
	}
}