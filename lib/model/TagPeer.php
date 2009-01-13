<?php

  // include base peer class
  require_once 'model/om/BaseTagPeer.php';
  
  // include object class
  include_once 'model/Tag.php';


/**
 * @package model
 */ 
class TagPeer extends BaseTagPeer {
  
  public static function getTagsSorted($sSearch = null) {
    $oCriteria = new Criteria();
    if($sSearch !== null) {
      $oCriteria->add(self::NAME, "%$sSearch%", Criteria::LIKE);
    }
    $oCriteria->addAscendingOrderByColumn(self::NAME);
    return self::doSelect($oCriteria);
  }
  
  public static function retrieveByName($sTagName) {
    $oCriteria = new Criteria(self::DATABASE_NAME);
    $oCriteria->add(self::NAME, Util::normalize($sTagName));
    return self::doSelectOne($oCriteria);
  }
  
  public static function deleteTagsForObject($oObject) {
    $aTagInstances = self::tagInstancesForObject($oObject);
    foreach($aTagInstances as $oTagInstance) {
      self::deleteInstance($oTagInstance);
    }
  }
  
  public static function tagInstancesForObject($oObject) {
    return self::tagInstancesForModel(get_class($oObject), $oObject->getId());
  }
  
  public static function tagInstancesForModel($sModelName, $iTaggedItemId) {
    $oCriteria = new Criteria();
    $oCriteria->add(TagInstancePeer::TAGGED_ITEM_ID, $iTaggedItemId);
    $oCriteria->add(TagInstancePeer::MODEL_NAME, $sModelName);
    return TagInstancePeer::doSelect($oCriteria);
  }
  
  public static function deleteInstance($oTagInstance) {
    $oTag = $oTagInstance->getTag();
    if(count($oTag->getTagInstances()) === 1) {
      $oTag->delete();
      return true;
    }
    $oTagInstance->delete();
    $oTag->reloadInstances();
    return false;
  }
} // TagPeer
