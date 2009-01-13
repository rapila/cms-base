<?php

  // include base peer class
  require_once 'model/om/BasePageStringPeer.php';
  
  // include object class
  include_once 'model/PageString.php';


/**
 * Skeleton subclass for performing query and update operations on the 'page_strings' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package model
 */	
class PageStringPeer extends BasePageStringPeer {

  public static function initializeRootPageString($sPagestring, $iPageId, $sLanguageId) {
    $sPageString = new PageString();
    $sPageString->setPageId($iPageId);
    $sPageString->setLanguageId($sLanguageId);
    $sPageString->setLongTitle($sPagestring);
    $sPageString->setTitle(null);
    $sPageString->save();
    return $sPageString;
  }
} // PageStringPeer
