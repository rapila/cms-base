<?php

  // include base peer class
  require_once 'model/om/BaseLanguageObjectPeer.php';
  
  // include object class
  include_once 'model/LanguageObject.php';


/**
 * Skeleton subclass for performing query and update operations on the 'language_objects' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package model
 */	
class LanguageObjectPeer extends BaseLanguageObjectPeer {

  public static function getReferencedLanguageObject($sObjectId, $sLanguageId) {
    $oCriteria = new Criteria();
    $oCriteria->add(self::OBJECT_ID, (int) $sObjectId);
    $oCriteria->add(self::LANGUAGE_ID, $sLanguageId);
    return self::doSelectOne($oCriteria);
  }
} // LanguageObjectPeer
