<?php

require_once 'model/om/BaseLink.php';

/**
 * @package model
 */ 
class Link extends BaseLink {
	
	public function delete(PropelPDO $con = null) {
		if(ReferencePeer::hasReference($this)) {
			throw new Exception("Exception in ".__METHOD__.": tried removing an instance from the database even though it is still referenced.");
		}
		TagPeer::deleteTagsForObject($this);
		ReferencePeer::removeReferences($this);
		return parent::delete($con);
	}

	public function getUpdatedAtFormatted() {
		return LocaleUtil::localizeDate($this->getUpdatedAt('c'));
	}
	
	public function getCategoryName() {
		if($this->getLinkCategory()) {
			return $this->getLinkCategory()->getName();
		}
		return null;
	}

}