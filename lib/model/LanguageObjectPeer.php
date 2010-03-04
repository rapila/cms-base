<?php

  // include base peer class
  require_once 'model/om/BaseLanguageObjectPeer.php';
  
  // include object class
  include_once 'model/LanguageObject.php';


/**
 * @package model
 */	
class LanguageObjectPeer extends BaseLanguageObjectPeer {
  /**
  * Corresponds to the overriding of {@link LanguageObject->getId()}
  * Provides a unified way of working with stored references (in the references or tags tables)
  */
  public static function retrieveByPK($object_id, $language_id = null, $con = null) {
    if($language_id === null && strpos($object_id, '_') !== false) {
      $object_id = explode('_', $object_id);
      $language_id = $object_id[1];
      $object_id = $object_id[0];
    }
    return parent::retrieveByPK((int)$object_id, $language_id, $con);
  }
}

