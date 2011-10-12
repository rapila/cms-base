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
		$config = Propel::getConfiguration(PropelConfiguration::TYPE_OBJECT);
		$config->setParameter('debugpdo.logging.details.method.enabled', true);
		$config->setParameter('debugpdo.logging.details.time.enabled', true);
		$config->setParameter('debugpdo.logging.details.mem.enabled', true);
		$allMethods = array(
			'PropelPDO::exec',              // logs a query
			'PropelPDO::query',             // logs a query
			'PropelPDO::beginTransaction',  // logs a transaction begin
			'PropelPDO::commit',            // logs a transaction commit
			'PropelPDO::rollBack',          // logs a transaction rollBack (watch out for the capital 'B')
			'DebugPDOStatement::execute',   // logs a query from a prepared statement
		);
		$config->setParameter('debugpdo.logging.methods', $allMethods, false);
		
		$con = Propel::getConnection(PagePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		$con->useDebug(true);
		$con->beginTransaction();
		$oPage = PagePeer::retrieveByPK($iIdNew, $con);
		$oRefPage = PagePeer::retrieveByPK($iIdRef, $con);
		try {
			if($sPosition === 'first' || $sPosition === 'inside') {
				$oPage->moveToFirstChildOf($oRefPage, $con);
			} else if($sPosition === 'before') {
				$oPage->moveToPrevSiblingOf($oRefPage, $con);
			} else if($sPosition === 'after') {
				$oPage->moveToNextSiblingOf($oRefPage, $con);
			} else if($sPosition === 'last') {
				$oPage->moveToLastChildOf($oRefPage, $con);
			} else {
				return false;
			}
			$oPage->save($con);
			$con->commit();
		} catch(Exception $e) {
			ErrorHandler::log($con);
			$con->rollBack();
			throw $e;
		}
		return true;
	}
}
