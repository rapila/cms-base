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
		$oInitialPage = $this->oRootPage;
		if(Manager::hasNextPathItem()) {
			$oInitialPage = PagePeer::retrieveByPK(Manager::usePath());
		}
		$this->addResourceParameter(ResourceIncluder::RESOURCE_TYPE_JS, 'tree_session', $this->oTreeWidget->getSessionKey());
		$this->addResourceParameter(ResourceIncluder::RESOURCE_TYPE_JS, 'initial_page_id', $oInitialPage->getId());
		$this->addResourceParameter(ResourceIncluder::RESOURCE_TYPE_JS, 'initial_page_tree_left', $oInitialPage->getTreeLeft());
		$oResourceIncluder = ResourceIncluder::defaultIncluder();
		$oResourceIncluder->addResource('admin/template.css');
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
		if($oParentPage && $oParentPage->hasChildren()) {
			return $oParentPage->getChildren()->toArray();
		}
		return array();
	}
	
	public function loadItem($iId) {
		return PagePeer::retrieveByPK($iId)->toArray();
	}
}