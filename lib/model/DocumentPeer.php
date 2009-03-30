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
  
  const ALL_CATEGORIES = '__all';
  const WITHOUT_CATEGORY = '__without';
  const ALL_KINDS = '__all';
  
  public static function getDocumentsByKindAndCategory($sDocumentKind=null, $iDocumentCategory=null, $sOrderField='NAME', $sSortOrder='ASC', $bDocumentKindIsNotInverted=true, $sDocumentName=null) {
    if($sDocumentKind === null) {
      $sDocumentKind = self::ALL_KINDS;
    }
    if($iDocumentCategory === null) {
      $iDocumentCategory = self::ALL_CATEGORIES;
    }
    
    $oCriteria = new Criteria();
    
    //Search
    if($sDocumentName !== null) {
      $oCriteria->add(self::NAME, "%$sDocumentName%", Criteria::LIKE);
    }
    
    //Catergory
    if($iDocumentCategory !== self::ALL_CATEGORIES) {
      $oCriteria->add(self::DOCUMENT_CATEGORY_ID, $iDocumentCategory === self::WITHOUT_CATEGORY ? null : $iDocumentCategory);
    } else {
      // is always excluded for any document calls, also for tinymce
      $aExcludeCategories = DocumentCategoryPeer::getExternallyManagedDocumentCategoryIds();
      if(count($aExcludeCategories) > 0) {
        $oCriteria->add(self::DOCUMENT_CATEGORY_ID, $aExcludeCategories, Criteria::NOT_IN);
      }
    }
    
    //Kind
    if($sDocumentKind !== self::ALL_KINDS) {
      $oCriteria->add(self::DOCUMENT_TYPE_ID, array_keys(DocumentTypePeer::getDocumentTypeAndMimetypeByDocumentKind($sDocumentKind, $bDocumentKindIsNotInverted)), Criteria::IN);
    }
    
    $sSortMethodName = Util::getPropelSortMethodName($sSortOrder);
    $oCriteria->$sSortMethodName(constant('self::'.strtoupper($sOrderField)));
    if($sOrderField != 'NAME') {
      $oCriteria->addAscendingOrderByColumn(self::NAME);
    }
    
    return self::doSelect($oCriteria);
  } 
  
  public static function getDocumentsForMceLinkArray($bExcludeExternallyManagedCategories=true) {
    $oCriteria = new Criteria();
    $oCriteria->add(self::DOCUMENT_TYPE_ID, array_keys(DocumentTypePeer::getDocumentTypeAndMimetypeByDocumentKind('image', false)), Criteria::IN);
    if($bExcludeExternallyManagedCategories) {
      $aExcludeCategories = DocumentCategoryPeer::getExternallyManagedDocumentCategoryIds();
      if(count($aExcludeCategories) > 0) {
        $oCriteria->add(self::DOCUMENT_CATEGORY_ID, $aExcludeCategories, Criteria::NOT_IN);
      }
    }
    $oCriteria->addJoin(self::DOCUMENT_CATEGORY_ID, DocumentCategoryPeer::ID, Criteria::LEFT_JOIN);
    $oCriteria->addAscendingOrderByColumn(DocumentCategoryPeer::NAME);
    $oCriteria->addAscendingOrderByColumn(self::NAME);
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