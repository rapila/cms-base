<?php
/**
 * @package modules.admin
 */
class PagesAdminModule extends AdminModule {
	
	private $oTreeWidget;
	private $oRootPage;
	
	public function __construct() {
		try {
			$this->oRootPage = PagePeer::getRootPage();
		} catch (Exception $e) {
				$this->oRootPage = PagePeer::initialiseRootPage();
		}
		$this->oTreeWidget = new TreeWidgetModule();
		$this->oTreeWidget->setDelegate($this);
		$this->oTreeWidget->setOrdered(true);
		$oInitialPage = null;
    // ErrorHandler::log(Manager::hasNextPathItem(), Session::getSession()->hasAttribute('persistent_page_id'));
		if(Manager::hasNextPathItem()) {
			$oInitialPage = PagePeer::retrieveByPK(Manager::usePath());
			Session::getSession()->setAttribute('persistent_page_id', $oInitialPage->getId());
		} else if(Session::getSession()->hasAttribute('persistent_page_id')) {
      $oInitialPage = PagePeer::retrieveByPK(Session::getSession()->getAttribute('persistent_page_id'));
		}
		if($oInitialPage === null) {
			$oInitialPage = $this->oRootPage;
		}
		$this->addResourceParameter(ResourceIncluder::RESOURCE_TYPE_JS, 'tree_session', $this->oTreeWidget->getSessionKey());
		$this->addResourceParameter(ResourceIncluder::RESOURCE_TYPE_JS, 'initial_page_id', $oInitialPage->getId());
		$this->addResourceParameter(ResourceIncluder::RESOURCE_TYPE_JS, 'initial_page_tree_left', $oInitialPage->getTreeLeft());
		$oResourceIncluder = ResourceIncluder::defaultIncluder();
		$oResourceIncluder->addResource('admin/template.css', null, null, array(), ResourceIncluder::PRIORITY_NORMAL, null, true);
	}
	
	public function mainContent() {
	}	
	
	public function sidebarContent() {
	}

	public function usedWidgets() {
		return array($this->oTreeWidget);
	}
	
	public function listChildren($iId) {
		$aResult = array();
		if($iId === null) {
			$aResult[] = self::propertiesFromPage($this->oRootPage);
		} else {
			$oParentPage = PagePeer::retrieveByPK($iId);
			if($oParentPage !== null) {
				foreach($oParentPage->getChildren() as $oChild) {
					$aResult[] = self::propertiesFromPage($oChild);
				}
			}
		}
		return $aResult;
	}
	
	private static function propertiesFromPage($oPage) {
		$aResult = $oPage->toArray();
		// $aResult['page_string'] = $oPage->getActivePageString(AdminManager::getContentLanguage())->toArray();
		return $aResult;
	}
	
	public function loadItem($iId) {
		return self::propertiesFromPage(PagePeer::retrieveByPK($iId));
	}
}