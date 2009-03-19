<?php

  // include base peer class
  require_once 'model/om/BaseModuleCategoryPeer.php';

  // include object class
  include_once 'model/ModuleCategory.php';


/**
 * new Categories that replace old document categories in order to allow easy and simple categorisation of links and maybe other modules too
 * for backend and frontend use
 * @package    model
 */
class ModuleCategoryPeer extends BaseModuleCategoryPeer {
  
  // Criteria::IN does not work properly with null
  const GENERAL_CATEGORY_ID = 'general';

  public static function getCategoriesByModule($sModuleName=null) {
    return self::doSelect(self::getCategoriesByModuleCriteria($sModuleName));
  }  
  
  public static function getCategoriesByModuleCriteria($sModuleName=null) {
    $oCriteria = new Criteria();
    if($sModuleName !== null) {
      $oCriteria->add(self::MODULE_NAME, array($sModuleName, self::GENERAL_CATEGORY_ID), Criteria::IN);
    }
    $oCriteria->addAscendingOrderByColumn(self::NAME);
    return $oCriteria;
  }
  
  public static function getDocumentCategories() {
    return self::doSelect(self::getCategoriesByModuleCriteria('document'));
  }
  
  public static function getLinkCategories() {
    return self::doSelect(self::getCategoriesByModuleCriteria('link'));
  }
  
  public static function hasDocumentCategories() {
    return self::doCount(self::getCategoriesByModuleCriteria('document'));
  }
  
  public static function hasLinkCategories() {
    return self::doCount(self::getCategoriesByModuleCriteria('link'));
  }
}

