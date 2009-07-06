<?php

  // include base peer class
  require_once 'model/om/BaseGroupPeer.php';

  // include object class
  include_once 'model/Group.php';

/**
 * @package    model
 */
class GroupPeer extends BaseGroupPeer {
  
  public static function getGroupByName($sName) {
    $oCriteria = new Criteria();
    $oCriteria->add(self::NAME, $sName);
    return self::doSelectOne($oCriteria);
  }
  
  public static function getGroupsBySearch($sSearch = null) {
    $oCriteria = new Criteria();
    $oCriteria->add(self::NAME, "%$sSearch%", Criteria::LIKE);
    $oCriteria->addAscendingOrderByColumn(self::NAME);
    return self::doSelect($oCriteria);
  }
}
