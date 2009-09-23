<?php

require_once 'model/om/BaseLanguage.php';


/**
 * @package model
 */	
class Language extends BaseLanguage {
  public function getLanguageName($sLanguageId = null) {
    return StringPeer::getString("language.".$this->getId(), $sLanguageId, $this->getId());
  }
  
  public function getName() {
    return $this->getLanguageName();
  }

  public static function languagesExist() {
    return self::doCount(new Criteria()) > 0;
  }
}