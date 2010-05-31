<?php
/**
 * @package modules.admin
 */
class PagesAdminModule extends AdminModule {
	
	private $oTreeWidget;
	private $oRootPage;
	
	public function __construct() {
		$this->oRootPage = PagePeer::getRootPage();
		$this->oTreeWidget = new TreeWidgetModule();
		$this->oTreeWidget->setDelegate($this);
		$this->oTreeWidget->setOrdered(true);
		$this->addResourceParameter(ResourceIncluder::RESOURCE_TYPE_JS, 'tree_session', $this->oTreeWidget->getSessionKey());
		$this->addResourceParameter(ResourceIncluder::RESOURCE_TYPE_JS, 'page_id', $this->oRootPage->getId());
	}
	
	public function mainContent() {
	}	
	
	public function sidebarContent() {
	}

	public function usedWidgets() {
		return array($this->oTreeWidget);
	}
	
	public function listChildren($iId) {
		$oParentPage = null;
		if($iId === null) {
			return array($this->oRootPage->toArray());
		} else {
			$oParentPage = PagePeer::retrieveByPK($iId);
		}
		return $oParentPage->getChildren()->toArray();
	}
}