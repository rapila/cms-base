<?php
/**
 * @package manager
 */
class GotoManager extends Manager {
    
  public function __construct() {
    parent::__construct();
    $oPage = PagePeer::retrieveByPk(Manager::usePath());
    LinkUtil::redirectToManager($oPage->getFullPathArray(), 'FrontendManager');
  }
  
  /**
   * render()
   */
  public function render() {}
}