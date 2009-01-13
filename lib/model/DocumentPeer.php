<?php

  // include base peer class
  require_once 'model/om/BaseDocumentPeer.php';
  
  // include object class
  include_once 'model/Document.php';


/**
 * Skeleton subclass for performing query and update operations on the 'documents' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package model
 */	
class DocumentPeer extends BaseDocumentPeer {
  
  public static function getDocumentsByKindAndCategory($sDocumentKind=null, $iDocumentCategory=null, $sOrderField='NAME', $sSortOrder='ASC', $bDocumentKindIsInverted = true, $sDocumentName = null) {
    $oCriteria = new Criteria();
    if($sDocumentName !== null) {
      $oCriteria->add(self::NAME, "%$sDocumentName%", Criteria::LIKE);
    }
    if($iDocumentCategory !== null) {
      $oCriteria->add(self::DOCUMENT_CATEGORY_ID, is_int($iDocumentCategory) ? $iDocumentCategory : 0);
    }
    if($sDocumentKind !== null) {
      $oCriteria->add(self::DOCUMENT_TYPE_ID, array_keys(DocumentTypePeer::getDocumentTypeAndMimetypeByDocumentKind($sDocumentKind, $bDocumentKindIsInverted)), Criteria::IN);
    }
    $sSortMethodName = Util::getPropelSortMethodName($sSortOrder);
    $oCriteria->$sSortMethodName(constant('self::'.strtoupper($sOrderField)));
    if($sOrderField != 'NAME') {
      $oCriteria->addAscendingOrderByColumn(self::NAME);
    }
    return self::doSelect($oCriteria);
  }  
    
  public static function getDocumentsByCategory($iDocumentCategory=null, $sDocumentKind=null) {
    return self::getDocumentsByKindAndCategory($sDocumentKind, $iDocumentCategory);
  }
  
  public static function getDocumentsByKindOfNotImage() {
    return self::getDocumentsByKindAndCategory('image', null, 'NAME', 'ASC', false);
  }
  
  public static function getDocumentsByKindOfImage() {
    return self::getDocumentsByKindAndCategory('image', null, 'NAME', 'ASC', true);
  }
  
  public static function getMostRecent() {
    $oCriteria = new Criteria();
    $oCriteria->addDescendingOrderByColumn(self::CREATED_AT);
    return self::doSelectOne($oCriteria);
  } // getMostRecent()
}