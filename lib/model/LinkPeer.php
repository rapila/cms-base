<?php

  // include base peer class
  require_once 'model/om/BaseLinkPeer.php';
  
  // include object class
  include_once 'model/Link.php';


/**
 * @package model
 */	
class LinkPeer extends BaseLinkPeer {
  
  public static function getLinksSorted($sOrderField='NAME', $sSortOrder='ASC', $sLinkCategory = null) {
    $oCriteria = new Criteria(); 
    /** 
     * @todo implement link_categories if makes sense ?
     */
    if(!is_null($sLinkCategory)) {
      // $oCriteria->add(self::LINK_CATEGORY_ID);
    }   
    $sSortMethodName = Util::getPropelSortMethodName($sSortOrder);
    $sOrderfield = constant("LinkPeer::".strtoupper($sOrderField));
    $oCriteria->$sSortMethodName($sOrderfield);
    return self::doSelect($oCriteria);
  }
  
  public static function getLinksByName($sName = null, $sOrderField='NAME', $sSortOrder='ASC') {
    $oCriteria = new Criteria(); 
    if($sName !== null) {
      $oSearchCriterion = $oCriteria->getNewCriterion(self::NAME, "%$sName%", Criteria::LIKE);
	    $oSearchCriterion->addOr($oCriteria->getNewCriterion(self::URL, "%$sName%", Criteria::LIKE));
      $oCriteria->add($oSearchCriterion);
    }
    $sSortMethodName = Util::getPropelSortMethodName($sSortOrder);
    $sOrderfield = constant("LinkPeer::".strtoupper($sOrderField));
    $oCriteria->$sSortMethodName($sOrderfield);
    return self::doSelect($oCriteria);
  }
} // LinkPeer
