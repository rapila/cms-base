<?php
/**
 * @package manager
 */
class GotoManager extends Manager {
  
  /**
  * Redirects to a page with the given id
  */
  public function __construct() {
    parent::__construct();
    $oPage = PagePeer::retrieveByPk(Manager::usePath());
    LinkUtil::redirectToManager($oPage->getFullPathArray(), 'FrontendManager');
  }
  
  /**
   * empty
   */
  public function render() {}
}