<?php

  // include base peer class
  require_once 'model/om/BaseReferencePeer.php';

  // include object class
  include_once 'model/Reference.php';


/**
 * Skeleton subclass for performing query and update operations on the 'references' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    model
 */
class ReferencePeer extends BaseReferencePeer {
  private static $aUnsavedReferences = array();
  
  /**
  * adds a reference track from an object to another if that reference does not already exist
  * expects objects or arrays in the form array(id, 'ModelName')
  */
  public static function addReference($mFromObject, $mToObject) {
    if($mFromObject instanceof BaseObject && $mFromObject->isNew()) {
      self::$aUnsavedReferences[] = array($mFromObject, $mToObject);
      return;
    }
    
    self::prepareObjectArgument($mFromObject);
    self::prepareObjectArgument($mToObject);
    if(self::referenceExists($mFromObject, $mToObject)) {
      return;
    }
    
    $oReference = new Reference();
    $oReference->setFromId($mFromObject[0]);
    $oReference->setFromModelName($mFromObject[1]);
    $oReference->setToId($mToObject[0]);
    $oReference->setToModelName($mToObject[1]);
    
    $oReference->save();
  }
  
  public static function referenceExists($mFromObject, $mToObject) {
    $oCriteria = self::prepareCriteria($mFromObject, $mToObject);
    return self::doCount($oCriteria) !== 0;
  }
  
  public static function countReferences($mToObject) {
    $oCriteria = self::prepareCriteria(null, $mToObject);
    return self::doCount($oCriteria);
  }
  
  public static function hasReference($mToObject) {
    return self::countReferences($mToObject) !== 0;
  }
  
  public static function getReferences($mToObject) {
    $oCriteria = self::prepareCriteria(null, $mToObject);
    return self::doSelect($oCriteria);
  }
  
  public static function getReferencesFromObject($mFromObject) {
    $oCriteria = self::prepareCriteria($mFromObject);
    return self::doSelect($oCriteria);
  }
  
  public static function removeReferences($mFromObject) {
    $oCriteria = self::prepareCriteria($mFromObject);
    return self::doDelete($oCriteria);
  }
  
  public static function removeReference($mFromObject, $mToObject) {
    $oCriteria = self::prepareCriteria($mFromObject, $mToObject);
    return self::doDelete($oCriteria);
  }
  
  public static function saveUnsavedReferences() {
    $aUnsavedReferences = self::$aUnsavedReferences;
    self::$aUnsavedReferences = array();
    foreach($aUnsavedReferences as $aUnsavedReference) {
      self::addReference($aUnsavedReference[0], $aUnsavedReference[1]);
    }
    return count(self::$aUnsavedReferences);
  }
  
  private static function prepareObjectArgument(&$mObject) {
    if(is_object($mObject)) {
      $mObject = array(Util::idForObject($mObject), get_class($mObject));
    }
  }
  
  private static function prepareCriteria($mFromObject = null, $mToObject = null) {
    $oCriteria = new Criteria();
    if($mFromObject !== null) {
      self::prepareCriteriaFrom($oCriteria, $mFromObject);
    }
    if($mToObject !== null) {
      self::prepareCriteriaTo($oCriteria, $mToObject);
    }
    return $oCriteria;
  }
  
  private static function prepareCriteriaFrom($oCriteria, $mFromObject) {
    self::prepareObjectArgument($mFromObject);
    $oCriteria->add(self::FROM_ID, $mFromObject[0]);
    $oCriteria->add(self::FROM_MODEL_NAME, $mFromObject[1]);
  }
  
  private static function prepareCriteriaTo($oCriteria, $mToObject) {
    self::prepareObjectArgument($mToObject);
    $oCriteria->add(self::TO_ID, $mToObject[0]);
    $oCriteria->add(self::TO_MODEL_NAME, $mToObject[1]);
  }

} // ReferencePeer
