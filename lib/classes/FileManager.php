<?php
/**
 * class FileManager
 * @package manager
 */
class FileManager extends Manager {
  
  private $oModule;
  
  /**
   * __construct()
   */
  public function __construct() {
    parent::__construct();
    if(!self::hasNextPathItem()) {
      throw new Exception("Request to /".Manager::getPrefixForManager($this)." without moduleName");
    }
    $this->oModule = FileModule::getModuleInstance(self::peekNextPathItem(), self::$REQUEST_PATH);
    $this->oModule->renderFile();
  } // __construct()
      
  /**
   * render()
   */
  public function render() {
  } // render()
} // class FileManager