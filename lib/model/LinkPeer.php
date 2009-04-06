<?php

  // include base peer class
  require_once 'model/om/BaseLinkPeer.php';
  
  // include object class
  include_once 'model/Link.php';


/**
 * @package model
 */	
class LinkPeer extends BaseLinkPeer {
  
  private static $aLinkProtocols = array('http'  => 'http://', 
                                        'https' => 'https://', 
                                        'ftp'   => 'ftp://', 
                                        'ftps'  => 'ftps://', 
                                        'mailto'=> 'mailto');
  
  public static function getLinksSorted($sOrderField='NAME', $sSortOrder='ASC') {
    $oCriteria = new Criteria();
    Util::addSortColumn($oCriteria, constant("LinkPeer::".strtoupper($sOrderField)), $sSortOrder);
    return self::doSelect($oCriteria);
  }

  /** 
   * getLinksByTagNameBackend()
   * for backend admin, also untagged links can be retrieved
   */ 
  public static function getLinksByTagNameBackend($sName=null, $sProtocol=null, $sTagName=null, $sOrderField='NAME', $sSortOrder='ASC', $bCriteriaIsIn = true) {
    $oCriteria = self::getLinksByNameCriteria($sName, $sOrderField, $sSortOrder, new Criteria());
    $aTaggedItemIds = array();
    foreach(TagInstancePeer::getByModelNameAndTagName('Link', $sTagName) as $oTagInstance) {
      $aTaggedItemIds[] = $oTagInstance->getTaggedItemId();
    }
    if($sTagName !== null && $bCriteriaIsIn) {
      $oCriteria->add(self::ID, $aTaggedItemIds, Criteria::IN);
    } elseif($bCriteriaIsIn === false) {
      $oCriteria->add(self::ID, $aTaggedItemIds, Criteria::NOT_IN);
    }
    if($sProtocol !== null) {
      $oCriteria->add(self::URL, "$sProtocol%", Criteria::LIKE);
    }
    return self::doSelect($oCriteria);
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
    Util::addSortColumn($oCriteria, constant("LinkPeer::".strtoupper($sOrderField)), $sOrderfield);
    return $oCriteria;
  }
  
  public static function getProtocolsWithLinksAssoc() {
    $aResult = array();
    foreach(self::getProtocolsWithLinks() as $oLink) {
      foreach(self::$aLinkProtocols as $sKey => $sProtocols) {
        if(Util::startsWith($oLink->getUrl(), $sProtocols)) {
          $aResult[$sKey] = $sProtocols;
        }
      }
    }
    return $aResult;
  }
  
  public static function getProtocolsWithLinks() {
    $oCriteria = new Criteria();
    $oCriteria->setDistinct();
    $oSearchCriterion = null;
    foreach(self::$aLinkProtocols as $sProtocols) {
      if($oSearchCriterion === null) {
        $oSearchCriterion = $oCriteria->getNewCriterion(self::URL, "$sProtocols%", Criteria::LIKE);
      } else {
  	    $oSearchCriterion->addOr($oCriteria->getNewCriterion(self::URL, "$sProtocols%", Criteria::LIKE));
      }
    }
    $oCriteria->add($oSearchCriterion);
    return self::doSelect($oCriteria);
  }

}

