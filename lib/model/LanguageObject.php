<?php

require_once 'model/om/BaseLanguageObject.php';


/**
 * Skeleton subclass for representing a row from the 'language_objects' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package model
 */	
class LanguageObject extends BaseLanguageObject {
  /**
  * Corresponds to the overriding of {@link LanguageObjectPeer::retrieveByPk()}
  * Provides a unified way of working with stored references (in the references or tags tables)
  */
  public function getId() {
    return $this->getObjectId().'_'.$this->getLanguageId();
  }
  
  public function delete($con = null) {
    if(ReferencePeer::hasReference($this)) {
      throw new Exception("Exception in ".__METHOD__.": tried removing an instance from the database even though it is still referenced.");
    }
    TagPeer::deleteTagsForObject($this);
    ReferencePeer::removeReferences($this);
    return parent::delete($con);
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
    
    $this->getContentObject()->getPage()->save();
    return parent::save($oConnection);
  }
  
  public function getTimestamp() {
    return (int)$this->getUpdatedAt('U');
  }
} // LanguageObject
