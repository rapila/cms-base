<?php

  // include base peer class
  require_once 'model/om/BaseDocumentCategoryPeer.php';

  // include object class
  include_once 'model/DocumentCategory.php';

/**
 * Skeleton subclass for performing query and update operations on the 'document_categories' table.
 * @package model
 */	
class DocumentCategoryPeer extends BaseDocumentCategoryPeer {

  public static function getDocumentCategoriesSorted($bInactiveOnly = false) {
    $oCriteria = new Criteria();
    $oCriteria->add(self::IS_EXTERNALLY_MANAGED, false);
    if($bInactiveOnly) {
      $oC->add(self::IS_INACTIVE, true);
    }
    $oCriteria->addAscendingOrderByColumn(self::NAME);
    return self::doSelect($oCriteria);
  }
  
  public static function getExternallyManagedDocumentCategories() {
    $oCriteria = new Criteria();
    $oCriteria->add(self::IS_EXTERNALLY_MANAGED, true);
    return self::doSelect($oCriteria);
  }
  
  public static function getExternallyManagedDocumentCategoryIds() {
    $aResult = array();
    foreach(self::getExternallyManagedDocumentCategories() as $oDocumentCategory) {
      $aResult[] = $oDocumentCategory->getId();
    }
    return $aResult;
  }
  
  public static function getDocumentCategories($bInactiveOnly = false) {
    return self::getDocumentCategoriesSorted($bInactiveOnly);
  }
  
  public static function hasDocumentCategories($bInactiveOnly = false) {
    return count(self::getDocumentCategoriesSorted($bInactiveOnly)) > 0;
  }
  
  public static function getCategoryNameById($iCategoryId) {
    $oCriteria = new Criteria();
    $oDocumentCategory = self::retrieveByPK($iCategoryId);
    if($oDocumentCategory) {
      return $oDocumentCategory->getName();
    }
    return null;
  }
}
