<?php

require_once 'model/om/BaseLanguageObject.php';


/**
 * @package model
 */ 
class LanguageObject extends BaseLanguageObject {
	/**
	* Corresponds to the overriding of {@link LanguageObjectQuery::create()->findPk()}
	* Provides a unified way of working with stored references (in the references or tags tables)
	*/
	public function getId() {
		return $this->getObjectId().'_'.$this->getLanguageId();
	}
	
	public function getDescription($sLanguageId = null) {
		return StringPeer::getString('wns.model.description.language_object', $sLanguageId, $this->getId(), array('id' => $this->getId(), 'page' => Util::nameForObject($this->getContentObject()->getPage()), 'language' => LanguageInputWidgetModule::getLanguageName($this->getLanguageId()), 'type' => Module::getDisplayNameByTypeAndName('frontend', $this->getContentObject()->getObjectType())));
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
		$oLanguageObjectHistory = LanguageObjectHistoryQuery::create()->findPk(array($this->getObjectId(), $this->getLanguageId(), $sHistoryId));
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

	/**
	* Gets the draft version of this language object (if any).
	* @param $bDraftOnly If true, the function will return null instead of $this if no draft exists.
	* @return LanguageObject|LanguageObjectHistory The draft version of this object.
	*/
	public function getDraft($bDraftOnly = false) {
		if($this->getHasDraft()) {
			return LanguageObjectHistoryQuery::create()->filterByLanguageObject($this)->sort()->findOne();
		}
		if($bDraftOnly) {
			return null;
		}
		return $this;
	}
	
	public function getAdminWidget() {
		return WidgetModule::getWidget('language_object_control', null, $this, FrontendModule::getModuleInstance($this->getContentObject()->getObjectType(), $this));
	}
}

