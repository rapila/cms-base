<?php

  // include base peer class
  require_once 'model/om/BaseTagPeer.php';
  
  // include object class
  include_once 'model/Tag.php';


/**
 * @package model
 */ 
class TagPeer extends BaseTagPeer {
  
  public static function getTagsSorted($sSearch = null, $bJoinInstances = false) {
    $oCriteria = new Criteria();
    if($bJoinInstances) {
      $oCriteria->addJoin(self::ID, TagInstancePeer::TAG_ID, Criteria::INNER_JOIN);
    }
    if($sSearch !== null) {
      $oCriteria->add(self::NAME, "%$sSearch%", Criteria::LIKE);
    }
    $oCriteria->addAscendingOrderByColumn(self::NAME);
    return self::doSelect($oCriteria);
  }
  
  public static function retrieveByName($sTagName) {
    $oCriteria = new Criteria(self::DATABASE_NAME);
    $oCriteria->add(self::NAME, StringUtil::normalize($sTagName));
    return self::doSelectOne($oCriteria);
  }
  
  public static function deleteTagsForObject($oObject) {
    $aTagInstances = self::tagInstancesForObject($oObject);
    foreach($aTagInstances as $oTagInstance) {
      $oTagInstance->delete();
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
  
  public static function getTagsUsedInModel($sModelName) {
    $oCriteria = new Criteria();
    $oCriteria->addJoin(self::ID, TagInstancePeer::TAG_ID, Criteria::INNER_JOIN);
    $oCriteria->add(TagInstancePeer::MODEL_NAME, $sModelName);
    $oCriteria->addAscendingOrderByColumn(self::NAME);
    return self::doSelect($oCriteria);
  }
}

