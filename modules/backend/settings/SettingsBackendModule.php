<?php
/**
* @package modules.backend
*/
class SettingsBackendModule extends BackendModule {
  public static $AVAILABLE_SECTIONS = array('direct_links', 'site_links', 'admin_links');
  public static $FIXED_MODULE_NAMES = array('pages', 'content', 'my_dashboard');
  
  public function getChooser() {
    $oTemplate = $this->constructTemplate('chooser');
    $oTemplate->replacePstring('settings.intro_text', array('user' => Session::getSession()->getUser()->getFullName()));
    return $oTemplate;
  }
  
  public function getDetail() {
    $oUser = Session::getSession()->getUser();
    if(@$_REQUEST['_reset'] === 'true') {
      $oUser->setBackendSettings(null);
      $oUser->save();
      LinkUtil::redirect(LinkUtil::linkToSelf(null, null, true));
    }
    
    $oTemplate = $this->constructTemplate('detail');
    $aBackendModules = BackendModule::listModules();
    foreach($aBackendModules as $sBackendModuleName => $aModuleInfo) {
      if(!$oUser->getIsAdmin() && @$aModuleInfo['module_info']['admin_required']) {
        continue;
      }
      if(in_array($sBackendModuleName, self::$FIXED_MODULE_NAMES)) {
        continue;
      }
      if($sBackendModuleName === $this->getModuleName()) {
        continue;
      }
      $oModuleTemplate = $this->constructTemplate('module');
      $oModuleTemplate->replaceIdentifier('name', $sBackendModuleName);
      $oModuleTemplate->replaceIdentifier('title', Module::getDisplayNameByTypeAndName('backend', $sBackendModuleName));
      $oModuleTemplate->replaceIdentifier('path', implode('/', $aModuleInfo['path']));
      $oModuleTemplate->replaceIdentifier('description', @$aModuleInfo['module_info']['description']);
      $oTemplate->replaceIdentifierMultiple('module_list', $oModuleTemplate);
    }
    foreach(self::$AVAILABLE_SECTIONS as $sSectionName) {
      $oSectionTemplate = $this->constructTemplate('section');
      $oSectionTemplate->replaceIdentifier('section_name', $sSectionName);
      $oTemplate->replaceIdentifierMultiple('section_list', $oSectionTemplate);
    }
    return $oTemplate;
  }
  
  public function customCss() {
    return $this->constructTemplate('settings.css');
  }
  
  public function customJs() {
    return $this->constructTemplate('settings.js');
  }

  public function getAjax($aRequestPath) {
    $oDocument = new DOMDocument();
    $oRoot = $oDocument->createElement("settings");
    $oDocument->appendChild($oRoot);
    $oUser = Session::getSession()->getUser();
    if($aRequestPath[0] === 'load') {
      $aBackendSettings = $oUser->getBackendSettingsValue();
      foreach($aBackendSettings as $sBackendSettingCategory => $aBackendSettingItems) {
        $oCategory = $oDocument->createElement('category');
        $oCategory->setAttribute('name', $sBackendSettingCategory);
        foreach($aBackendSettingItems as $sBackendSettingItemName => $mBackendSettingItemValue) {
          $oItem = $oDocument->createElement('item');
          $oItem->setAttribute('name', $sBackendSettingItemName);
          $oCategory->appendChild($oItem);
        }
        $oRoot->appendChild($oCategory);
      }
    } else if($aRequestPath[0] === 'save') {
      $aResult = array();
      foreach(self::$AVAILABLE_SECTIONS as $sSectionName) {
        if(!isset($_REQUEST[$sSectionName])) {
          $aResult[$sSectionName] = array();
          continue;
        }
        $aSectionItems = explode(',', $_REQUEST[$sSectionName]);
        $aSectionItems = ArrayUtil::arrayWithValuesAsKeys($aSectionItems);
        $aResult[$sSectionName] = $aSectionItems;
      }
      $oUser->setBackendSettings(serialize($aResult));
      $oUser->save();
      $oRoot->setAttribute('status', 'ok');
    }
    return $oDocument;
  }
}