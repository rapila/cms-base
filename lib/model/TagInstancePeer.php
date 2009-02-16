<?php

  // include base peer class
  require_once 'model/om/BaseTagInstancePeer.php';
  
  // include object class
  include_once 'model/TagInstance.php';


/**
 * Skeleton subclass for performing query and update operations on the 'tag_instances' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
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
} // TagInstancePeer
