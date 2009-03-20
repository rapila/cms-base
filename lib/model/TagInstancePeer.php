<?php

  // include base peer class
  require_once 'model/om/BaseTagInstancePeer.php';
  
  // include object class
  include_once 'model/TagInstance.php';

/**
 * @package model
 */	
class TagInstancePeer extends BaseTagInstancePeer {
  public static function newTagInstance($sTagName, $sModelName, $iTaggedItemId) {
    $oTag = TagPeer::retrieveByName($sTagName);
    if($oTag === null) {
      $oTag = new Tag();
      $oTag->setName($sTagName);
      $oTag->save();
    }
    $oTagInstance = self::retrieveByPk($oTag->getId(), $iTaggedItemId, $sModelName);
    if($oTagInstance !== null) {
      throw new Exception("Instance of this tag does already exist");
    }
    $oTagInstance = new TagInstance();
    $oTagInstance->setTag($oTag);
    $oTagInstance->setModelName($sModelName);
    $oTagInstance->setTaggedItemId($iTaggedItemId);
    $oTagInstance->save();
    return $oTagInstance;
  }
  
  public static function newTagInstanceForObject($sTagName, $oObject) {
    return self::newTagInstance($sTagName, get_class($oObject), $oObject->getId());
  }
  
  public static function getByModelNameAndIdCriteria($sModelName, $iId) {
    $oCriteria = new Criteria();
    $oCriteria->add(self::MODEL_NAME, $sModelName);
    $oCriteria->add(self::TAGGED_ITEM_ID, $iId);
    return $oCriteria;
  }
  
  public static function countByModelNameAndIdCriteria($sModelName, $iId) {
    return self::doCount(self::getByModelNameAndIdCriteria($sModelName, $iId));
  }
  
  public static function getByModelName($sModelName) {
    $oCriteria = new Criteria();
    $oCriteria->add(self::MODEL_NAME, $sModelName);
    return self::doSelect($oCriteria);
  }
}
