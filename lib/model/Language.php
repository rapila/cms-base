<?php

require_once 'model/om/BaseLanguage.php';


/**
 * Skeleton subclass for representing a row from the 'languages' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
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