<?php
require_once 'model/om/BaseContentObject.php';

/**
 * classname ContentObject
 * @package model
 */	
class ContentObject extends BaseContentObject {
  
  public function getActiveLanguageObject() {
    return self::getLanguageObject(Session::language());
  }
  
  public function getActiveLanguageObjectBe() {
    return self::getLanguageObject(BackendManager::getContentEditLanguage());
  }
  
  public function getLanguageObject($sLanguageId = null) {
    if($sLanguageId === null) {
      $sLanguageId = Session::language();
    }
    $oResult = $this->getLanguageObjectsByLanguage($sLanguageId);
    if(count($oResult) === 0) {
      return null;
    }
    return $oResult[0];
  }
    
  public function getLanguageObjectsByLanguage($sLanguage) {
    $c = new Criteria();
    $c->add(LanguageObjectPeer::LANGUAGE_ID, $sLanguage);
    return $this->getLanguageObjects($c);
  }
  
  public function hasLanguage($sLanguageId) {
    return $this->getLanguageObjectsByLanguage($sLanguageId) !== null;
  }
  
  public function getObjectTypeName($sLanguageId=null) {
    return FrontendModule::getDisplayNameByName($this->getObjectType(), $sLanguageId);
  }
}
?>