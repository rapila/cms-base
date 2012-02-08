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
			$this->oRootPage = PagePeer::initializeRootPage();
		}
		$this->oTreeWidget = new TreeWidgetModule();
		$this->oTreeWidget->setDelegate($this);
		$this->oTreeWidget->setSetting('init_dnd', true);
		$oInitialPage = null;

		if(Manager::hasNextPathItem()) {
			$oInitialPage = PagePeer::retrieveByPK(Manager::usePath());
			if($oInitialPage !== null) {
				Session::getSession()->setAttribute('persistent_page_id', $oInitialPage->getId());
			}
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
	
	public function getModelName() {
		return 'Page';
	}
	
	private static function propertiesFromPage($oPage) {
		$oUser = Session::getSession()->getUser();
		$aResult = $oPage->toArray();
		$aResult['UserMayCreateChildren'] = $oUser->mayCreateChildren($oPage);
		$aResult['UserMayCreateSiblings'] = $oPage->getParent() !== null && $oUser->mayCreateChildren($oPage->getParent());
		return $aResult;
	}
	
	public function loadItem($iId) {
		return self::propertiesFromPage(PagePeer::retrieveByPK($iId));
	}
	
	public function moveItem($iIdNew, $iIdRef, $sPosition) {
		$oPage = PagePeer::retrieveByPK($iIdNew);
		$oRefPage = PagePeer::retrieveByPK($iIdRef);
		if($sPosition === 'first' || $sPosition === 'inside') {
			$oPage->moveToFirstChildOf($oRefPage);
		} else if($sPosition === 'before') {
			$oPage->moveToPrevSiblingOf($oRefPage);
		} else if($sPosition === 'after') {
			$oPage->moveToNextSiblingOf($oRefPage);
		} else if($sPosition === 'last') {
			$oPage->moveToLastChildOf($oRefPage);
		} else {
			return false;
		}
		return true;
	}
}
