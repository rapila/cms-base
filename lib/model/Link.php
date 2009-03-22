<?php

require_once 'model/om/BaseLink.php';

/**
 * @package model
 */	
class Link extends BaseLink {
  
  public function delete($con = null) {
    if(ReferencePeer::hasReference($this)) {
      throw new Exception("Exception in ".__METHOD__.": tried removing an instance from the database even though it is still referenced.");
    }
    TagPeer::deleteTagsForObject($this);
    ReferencePeer::removeReferences($this);
    return parent::delete($con);
  }
}

