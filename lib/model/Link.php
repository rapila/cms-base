<?php

require_once 'model/om/BaseLink.php';


/**
 * Skeleton subclass for representing a row from the 'links' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
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
} // Link
