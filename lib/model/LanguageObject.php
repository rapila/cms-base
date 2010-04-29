<?php

require_once 'model/om/BaseLanguageObject.php';


/**
 * @package model
 */ 
class LanguageObject extends BaseLanguageObject {
	/**
	* Corresponds to the overriding of {@link LanguageObjectPeer::retrieveByPK()}
	* Provides a unified way of working with stored references (in the references or tags tables)
	*/
	public function getId() {
		return $this->getObjectId().'_'.$this->getLanguageId();
	}
	
	public function delete(PropelPDO $con = null) {
		if(ReferencePeer::hasReference($this)) {
			throw new Exception("Exception in ".__METHOD__.": tried removing an instance from the database even though it is still referenced.");
		}
		TagPeer::deleteTagsForObject($this);
		ReferencePeer::removeReferences($this);
		return parent::delete($con);
	}
	
	public function save(PropelPDO $oConnection = null) {
		$this->getContentObject()->getPage()->save();
		return parent::save($oConnection);
	}
	
	public function revertToHistory($sHistoryId) {
		if($sHistoryId === null) {
			return;
		}
		$oLanguageObjectHistory = LanguageObjectHistoryPeer::retrieveByPK($this->getObjectId(), $this->getLanguageId(), $sHistoryId);
		if($oLanguageObjectHistory !== null) {
			$this->setData($oLanguageObjectHistory->getData());
		}
	}
} // LanguageObject
