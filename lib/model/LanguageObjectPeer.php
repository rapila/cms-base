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
  /**
  * Corresponds to the overriding of {@link LanguageObject->getId()}
  * Provides a unified way of working with stored references (in the references or tags tables)
  */
  public static function retrieveByPk($object_id, $language_id = null, $con = null) {
    if($language_id === null && strpos($object_id, '_') !== false) {
      $object_id = explode('_', $object_id);
      $language_id = $object_id[1];
      $object_id = $object_id[0];
    }
    return parent::retrieveByPk((int)$object_id, $language_id, $con);
  }
} // LanguageObjectPeer
