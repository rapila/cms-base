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
