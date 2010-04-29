<?php
/**
 * @package modules.backend
 */

class ModuleManagerBackendModule extends BackendModule {
  private $sModuleType;
  private $sModuleNamel;
  
  public function __construct() {
    $this->sModuleType = Manager::usePath();
    $this->sModuleName = Manager::usePath();
  }
  
  public function getChooser() {
    $oTemplate = $this->constructTemplate('chooser');
    foreach(Module::listModuleTypes() as $sModuleType) {
      $oModuleTypeTemplate = $this->constructTemplate('chooser_module_type');
      $oModuleTypeTemplate->replaceIdentifier('module_type', $sModuleType);
      foreach(Module::listModulesByType($sModuleType, false) as $sModuleName => $aModuleAttributes) {
        $oModuleTemplate = $this->constructTemplate('chooser_module');
        $oModuleTemplate->replaceIdentifier('module_name', $sModuleName);
        $oModuleTemplate->replaceIdentifier('module_link', $this->link("$sModuleType/$sModuleName"));
        $oModuleTypeTemplate->replaceIdentifierMultiple('modules', $oModuleTemplate);
      }
      $oTemplate->replaceIdentifierMultiple('module_types', $oModuleTypeTemplate);
    }
    return $oTemplate;
  }
  
  public function getDetail() {
    if($this->sModuleName === null) {
      return;
    }
    $oTemplate = $this->constructTemplate('detail');
    
    $aModuleInfo = Module::getModuleInfoByTypeAndName($this->sModuleType, $this->sModuleName);
    $sDisplayName = Module::getDisplayNameByTypeAndName($this->sModuleType, $this->sModuleName);
    
    if($this->sModuleType === 'backend') {
      $oBackendModuleTemplate = $this->constructTemplate('backend_module_detail_info');
      $oBackendModuleTemplate->replaceIdentifier('allowed_groups', TagWriter::optionsFromObjects(GroupPeer::doSelect(new Criteria()), null, null, @$aModuleInfo['allowed_groups'], array()));
      $oTemplate->replaceIdentifier('backend_module_detail_info', $oBackendModuleTemplate, null, Template::LEAVE_IDENTIFIERS);
    }
    $oTemplate->replaceIdentifier('display_name', $sDisplayName);
    $oTemplate->replaceIdentifier('action', $this->link("$this->sModuleType/$this->sModuleName"));
    foreach($aModuleInfo as $sModuleInfoKey => $sModuleInfoValue) {
      $oTemplate->replaceIdentifier($sModuleInfoKey, $sModuleInfoValue);
    }
    
    return $oTemplate;
  }
  
  public function doSave() {
    $aModuleInfo = Module::getModuleInfoByTypeAndName($this->sModuleType, $this->sModuleName);
    $aInfo = array();
    
    $aInfo['enabled'] = isset($_POST['enabled']) || @$aModuleInfo['required'];
    $aInfo['admin_required'] = isset($_POST['admin_required']);
    if(isset($_POST['allowed_groups'])) {
      $aInfo['allowed_groups'] = $_POST['allowed_groups'];
    }
    require_once("spyc/Spyc.php");
    $sInfoFilePath = SITE_DIR.'/'.DIRNAME_MODULES;
    if(!file_exists($sInfoFilePath)) {
      mkdir($sInfoFilePath);
    }
    $sInfoFilePath .= "/".$this->sModuleType;
    if(!file_exists($sInfoFilePath)) {
      mkdir($sInfoFilePath);
    }
    $sInfoFilePath .= "/".$this->sModuleName;
    if(!file_exists($sInfoFilePath)) {
      mkdir($sInfoFilePath);
    }
    $sInfoFilePath .= "/".Module::INFO_FILE;
    file_put_contents($sInfoFilePath, Spyc::YAMLDump($aInfo));
    LinkUtil::redirect($this->link("$this->sModuleType/$this->sModuleName"));
  }
}