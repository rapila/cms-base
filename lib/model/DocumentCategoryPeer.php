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
    $oC = new Criteria();
    if($bInactiveOnly) {
      $oC->add(self::IS_INACTIVE, true);
    }
    $oC->addAscendingOrderByColumn(self::NAME);
    return self::doSelect($oC);
  }
  
  public static function hasDocumentCategories($bInactiveOnly = false) {
    return count(self::getDocumentCategoriesSorted($bInactiveOnly)) > 0;
  }
}
