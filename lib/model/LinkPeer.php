<?php

  // include base peer class
  require_once 'model/om/BaseLinkPeer.php';
  
  // include object class
  include_once 'model/Link.php';


/**
 * @package model
 */	
class LinkPeer extends BaseLinkPeer {
  
  public static function getLinksSorted($sOrderField='NAME', $sSortOrder='ASC') {
    $oCriteria = new Criteria();   
    $sSortMethodName = Util::getPropelSortMethodName($sSortOrder);
    $sOrderfield = constant("LinkPeer::".strtoupper($sOrderField));
    $oCriteria->$sSortMethodName($sOrderfield);
    return self::doSelect(self::getLinksSortedCriteria($sOrderField, $sSortOrder));
  }
  
  public static function getLinksSortedCriteria($sOrderField='NAME', $sSortOrder='ASC', $oCriteria = null) {
    $oCriteria = $oCriteria === null ? new Criteria() : $oCriteria;   
    $sSortMethodName = Util::getPropelSortMethodName($sSortOrder);
    $sOrderfield = constant("LinkPeer::".strtoupper($sOrderField));
    $oCriteria->$sSortMethodName($sOrderfield);
    return $oCriteria;
  }
  
  public static function getLinksByTagName($sName=null, $sOrderField='NAME', $sSortOrder='ASC', $sTagName=null, $bCriteriaIsIn = true) {
    $oCriteria = new Criteria();
    if($sTagName !== null || $bCriteriaIsIn === false) {
      $aTaggedItemIds = null;
      foreach(TagInstancePeer::getByModelName('Link') as $oTagInstance) {
        $aTaggedItemIds[] = $oTagInstance->getTaggedItemId();
      }
      if($aTaggedItemIds !== null && $bCriteriaIsIn) {
        $oCriteria->add(self::ID, $aTaggedItemIds, Criteria::IN);
      } elseif($bCriteriaIsIn) {
        $oCriteria->add(self::ID, $aTaggedItemIds, Criteria::NOT_IN);
      }
    } 
    return self::doSelect(self::getLinksByNameCriteria($sName, $sOrderField, $sSortOrder, $oCriteria));
  }
  
  public static function getLinksByName($sName = null, $sOrderField='NAME', $sSortOrder='ASC') {
    return self::doSelect(self::getLinksByNameCriteria($sName, $sOrderField, $sSortOrder));
  }
  
  public static function getLinksByNameCriteria($sName = null, $sOrderField='NAME', $sSortOrder='ASC', $oCriteria=null) {
    $oCriteria = $oCriteria === null ? new Criteria() : $oCriteria; 
    if($sName !== null) {
      $oSearchCriterion = $oCriteria->getNewCriterion(self::NAME, "%$sName%", Criteria::LIKE);
	    $oSearchCriterion->addOr($oCriteria->getNewCriterion(self::URL, "%$sName%", Criteria::LIKE));
      $oCriteria->add($oSearchCriterion);
    }
    $sSortMethodName = Util::getPropelSortMethodName($sSortOrder);
    $sOrderfield = constant("LinkPeer::".strtoupper($sOrderField));
    $oCriteria->$sSortMethodName($sOrderfield);
    return $oCriteria;
  }

} // LinkPeer
