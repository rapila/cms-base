<?php

  // include base peer class
  require_once 'model/om/BaseDocumentPeer.php';
  
  // include object class
  include_once 'model/Document.php';

/**
 * @package model
 */	
class DocumentPeer extends BaseDocumentPeer {
  
  public static function getDocumentsByKindAndCategory($sDocumentKind=null, $iDocumentCategory=null, $bDocumentKindIsNotInverted=true, $bExcludeExternallyManaged = true) {
    $oCriteria = self::getDocumentsCriteria($bExcludeExternallyManaged);
    if($iDocumentCategory !== null) {
      $oCriteria->add(self::DOCUMENT_CATEGORY_ID, $iDocumentCategory);
    }
    if($sDocumentKind !== null) {
      $oCriteria->add(self::DOCUMENT_TYPE_ID, array_keys(DocumentTypePeer::getDocumentTypeAndMimetypeByDocumentKind($sDocumentKind, $bDocumentKindIsNotInverted)), Criteria::IN);
    }
    $oCriteria->addAscendingOrderByColumn(self::NAME);
    return self::doSelect($oCriteria);
  }
  
  public static function getDocumentsCriteria($bExcludeExternallyManaged = true) {
    $oCriteria = new Criteria();
    $oCriteria->addJoin(DocumentPeer::DOCUMENT_TYPE_ID, DocumentTypePeer::ID);
    $oCriteria->addJoin(DocumentPeer::DOCUMENT_CATEGORY_ID, DocumentCategoryPeer::ID, Criteria::LEFT_JOIN);
    if($bExcludeExternallyManaged) {
      $oExternalCriterion = $oCriteria->getNewCriterion(DocumentPeer::DOCUMENT_CATEGORY_ID, null);
      $oExternalCriterion->addOr($oCriteria->getNewCriterion(DocumentCategoryPeer::IS_EXTERNALLY_MANAGED, false));
      $oCriteria->add($oExternalCriterion);
    }
    return $oCriteria;
  }
  
  public static function addSearchToCriteria($sSearch, $oCriteria) {
    $oCriteria->add(self::NAME, "%$sSearch%", Criteria::LIKE);
  }
    
  public static function getDocumentsByCategory($iDocumentCategory=null, $sDocumentKind=null) {
    return self::getDocumentsByKindAndCategory($sDocumentKind, $iDocumentCategory);
  }
  
  public static function getDocumentsByKindOfNotImage($bExcludeExternallyManaged = true) {
    return self::getDocumentsByKindAndCategory('image', null, false, $bExcludeExternallyManaged);
  }
  
  public static function getDocumentsByKindOfImage($bExcludeExternallyManaged = true) {
    return self::getDocumentsByKindAndCategory('image', null, true, $bExcludeExternallyManaged);
  }

  public static function countDocumentsInternallyManaged() {
    return self::doCount(self::getDocumentsCriteria());
  }

  public static function countDocumentsExceedsLimit($iLimit = 40) {
    return self::countDocumentsInternallyManaged() > $iLimit;
  }
  
  public static function getDocumentsForMceLinkArray($bExcludeExternallyManagedCategories=true) {
    $oCriteria = self::getDocumentsCriteria();
    $oCriteria->add(self::DOCUMENT_TYPE_ID, array_keys(DocumentTypePeer::getDocumentTypeAndMimetypeByDocumentKind('image', false)), Criteria::IN);
    $oCriteria->addAscendingOrderByColumn(DocumentCategoryPeer::NAME);
    $oCriteria->addAscendingOrderByColumn(self::NAME);
    return self::doSelect($oCriteria);
  } 
    
  public static function getMostRecent($bIsProtected = false) {
    $oCriteria = new Criteria();
    $oCriteria->addDescendingOrderByColumn(self::CREATED_AT);
    $oCriteria->add(self::IS_INACTIVE, false);
    $oCriteria->add(self::IS_PROTECTED, $bIsProtected);
    return self::doSelectOne($oCriteria);
  }
}