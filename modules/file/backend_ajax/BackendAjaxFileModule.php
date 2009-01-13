<?php
/**
 * @package modules.file
* This class is actually a file module and is not designed to be filled into pages. Its purpose is to redirect some ajax calls to the appropriate backend module whose name is given as the first path item. Currently, this is used for the tagging mechanism as well as reordering containers in the default page type module.
*/
class BackendAjaxFileModule extends FileModule {
  private $sBackendModuleName;
  private $aRequestPath;
  
  const ERROR_NOT_LOGGED_IN = "not_logged_in";
  const ERROR_NOT_PERMITTED = "not_permitted";
  const ERROR_MODULE_NOT_FOUND = "module_not_found";
  
  public function __construct($aRequestPath) {
    parent::__construct($aRequestPath);
    array_shift($aRequestPath);
    $this->sBackendModuleName = array_shift($aRequestPath);
    $this->aRequestPath = $aRequestPath;
  }
  
  public function renderFile() {
    $sCharset = Settings::getSetting("encoding", "browser", "utf-8");
	  header("Content-Type: application/xml;charset=".$sCharset);
    print "<?xml version=\"1.0\" encoding=\"$sCharset\"?>";
    if(!Session::getSession()->isAuthenticated()) {
      self::printError(self::ERROR_NOT_LOGGED_IN);
    }
    $oModule = BackendModule::getModuleInstance($this->sBackendModuleName);
    if($oModule === null) {
      self::printError(self::ERROR_MODULE_NOT_FOUND);
    }
    $oModule->getAjax($this->aRequestPath);
  }
  
  public static function printError($sErrorMessage) {
    print <<<EOD
  <error id="$sErrorMessage"/>
EOD;
    exit;
  }
}