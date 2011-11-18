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
	
	public function getDescription($sLanguageId = null) {
		return StringPeer::getString('wns.model.description.language_object', $sLanguageId, $this->getId(), array('id' => $this->getId(), 'page' => Util::nameForObject($this->getContentObject()->getPage()), 'language' => LanguagePeer::getLanguageName($this->getLanguageId()), 'type' => Module::getDisplayNameByTypeAndName('frontend', $this->getContentObject()->getObjectType())));
	}
	
	public function postSave(PropelPDO $oConnection = null) {
		PagePeer::ignoreRights(true);
		//Mark page as updated to flush full page caches
		$this->getContentObject()->getPage()->save();
		PagePeer::ignoreRights(false);
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

	public function newHistory($bDraft = false) {
		$oHistory = new LanguageObjectHistory();
		$oHistory->setObjectId($this->getObjectId());
		$oHistory->setLanguageId($this->getLanguageId());
		$oHistory->setData($this->getData());
		$this->setHasDraft($bDraft);
		return $oHistory;
	}

	private $bStoredHasDraft = null;

	public function getHasDraft() {
		if($this->bStoredHasDraft === null) {
			if($this->isNew()) {
				parent::setHasDraft(LanguageObjectHistoryQuery::create()->filterByLanguageObject($this)->count() > 0);
			}
			$this->bStoredHasDraft = parent::getHasDraft();
		}
		return $this->bStoredHasDraft;
	}

	public function setHasDraft($bHasDraft) {
		$this->bStoredHasDraft = $bHasDraft;
		parent::setHasDraft($bHasDraft);
	}

	public function getDraft() {
		if($this->getHasDraft()) {
			return LanguageObjectHistoryQuery::create()->filterByLanguageObject($this)->sort()->findOne();
		}
		return $this;
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

