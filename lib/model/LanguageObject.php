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
	
	public function setData($mData, $bIgnorePermissions = false) {
		if(!$bIgnorePermissions) {
			$oUser = Session::getSession()->getUser();
			if(!$oUser || !$oUser->mayEditPageContents($this->getContentObject()->getPage())) {
				throw new Exception('Changing data not permitted');
			}
		}
		
		return parent::setData($mData);
	}
	
}

