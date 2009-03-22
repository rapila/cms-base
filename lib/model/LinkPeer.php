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
    return self::doSelect($oCriteria);
  }

  /** 
   * getLinksByTagNameBackend()
   * for backend admin, also untagged links can be retrieved
   */ 
  public static function getLinksByTagNameBackend($sName=null, $sOrderField='NAME', $sSortOrder='ASC', $sTagName=null, $bCriteriaIsIn = true) {
    $oCriteria = new Criteria();
    $aTaggedItemIds = array();
    foreach(TagInstancePeer::getByModelNameAndTagName('Link', $sTagName) as $oTagInstance) {
      $aTaggedItemIds[] = $oTagInstance->getTaggedItemId();
    }
    if($sTagName !== null && $bCriteriaIsIn) {
      $oCriteria->add(self::ID, $aTaggedItemIds, Criteria::IN);
    } elseif($bCriteriaIsIn === false) {
      $oCriteria->add(self::ID, $aTaggedItemIds, Criteria::NOT_IN);
    }
    return self::doSelect(self::getLinksByNameCriteria($sName, $sOrderField, $sSortOrder, $oCriteria));
  }
  
  /** 
   * getLinksByTagName()
   * @param mixed string|array tagname
   * @param boolean optional sortorder
   * @return array of objects
   */
  public static function getLinksByTagName($mTagName, $bOrderByLinkName=true) {
    $oCriteria = new Criteria();
    $oCriteria->addJoin(self::ID, TagInstancePeer::TAGGED_ITEM_ID, Criteria::INNER_JOIN);
    $oCriteria->addJoin(TagInstancePeer::TAG_ID, TagPeer::ID, Criteria::INNER_JOIN);
    $oCriteria->add(TagInstancePeer::MODEL_NAME, 'Link');
    if(!is_array($mTagName)) $mTagName = array($mTagName);
    $oCriteria->add(TagPeer::NAME, $mTagName, Criteria::IN);
    if($bOrderByLinkName) {
      $oCriteria->addAscendingOrderByColumn(self::NAME);
    } else {
      $oCriteria->addAscendingOrderByColumn(self::URL);
    }
    return self::doSelect($oCriteria);
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

}

