<?php

require_once 'model/om/BaseDocumentCategory.php';


/**
 * @package model
 */	
class DocumentCategory extends BaseDocumentCategory {
	
	public function getDocumentCount() {
		return $this->countDocuments();
	}
	
  public function save($oConnection = null) {
    if(Session::getSession()->isAuthenticated()) {
      $this->setUpdatedBy(Session::getSession()->getUserId());
    }
    $this->setUpdatedAt(date('c'));

    if($this->isNew()) {
      if(Session::getSession()->isAuthenticated()) {
        $this->setCreatedBy(Session::getSession()->getUserId());
      }
      $this->setCreatedAt(date('c'));
    }
    return parent::save($oConnection);
  }
}

