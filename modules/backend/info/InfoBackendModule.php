<?php
/**
 * @package modules.backend
 */
class InfoBackendModule extends BackendModule {
  
  public function __construct() {
  }
  
  public function getChooser() {
    $oTemplate = $this->constructTemplate('list');
    $oTemplate->replaceIdentifier("php_version", phpversion());
    foreach(FrontendModule::listModules() as $aModule) {
      $sModuleName = Module::getDisplayNameByTypeAndName($aModule['type'], $aModule['name']);
      $sModulePath = implode('/', $aModule['path']);
      $oModuleTemplate = $this->constructTemplate("info_module");
      $oModuleTemplate->replaceIdentifier("name", $sModuleName);
      $oModuleTemplate->replaceIdentifier("path", $sModulePath);
      // TODO: Implement isInt using plugin awareness
      // $oModuleTemplate->replaceIdentifier("module_info", ResourceFinder::isInt($sModulePath) ? 'int' : 'ext');
      $oTemplate->replaceIdentifierMultiple("modules", $oModuleTemplate);
    }
    return $oTemplate;
  }
  
  public function getDetail() {
	ob_start();
	phpinfo();
	$sInfo = ob_get_contents();
	ob_end_clean();

	return preg_replace('%^.*<body>(.*)</body>.*$%ms', '$1', $sInfo);
  }
}
