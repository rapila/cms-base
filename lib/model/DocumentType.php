<?php

require_once 'model/om/BaseDocumentType.php';


/**
 * Skeleton subclass for representing a row from the 'document_types' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package model
 */	
class DocumentType extends BaseDocumentType {
  public function isImageType($sType = '') {
    return StringUtil::startsWith($this->getMimetype(), "image/$sType");
  }
  
  public function getDocumentKind() {
    $aResult = explode('/', $this->getMimeType());
    return $aResult[0];
  }
  
  public function getDocumentKindDetail() {
    $aResult = explode('/', $this->getMimeType());
    return $aResult[1];
  }
} // DocumentType
