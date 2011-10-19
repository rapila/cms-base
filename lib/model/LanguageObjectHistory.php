<?php

require_once 'model/om/BaseLanguageObjectHistory.php';


/**
 * @package		 model
 */
class LanguageObjectHistory extends BaseLanguageObjectHistory {
	/**
	* Corresponds to the overriding of {@link LanguageObjectPeer::retrieveByPK()}
	* Provides a unified way of working with stored references (in the references or tags tables)
	*/
	public function getId() {
		return $this->getObjectId().'_'.$this->getLanguageId().'_'.$this->getRevision();
	}

	public function getName() {
		return 'Backup '.$this->getRevision().', '.$this->getCreatedAt('Y-m-d').' / '.$this->getUser()->getInitials();
	}

	public function preInsert(PropelPDO $con = null) {
		$this->setRevision($this->getNextRevision());
		return true;
	}
	
	private function getNextRevision() {
		$oLanguageObjectHistory = LanguageObjectHistoryQuery::create()->filterByLanguageObject($this)->sort()->findOne();
		if($oLanguageObjectHistory !== null) {
			return ($oLanguageObjectHistory->getRevision()+1);
		}
		return 1;
	}

	///Convenience function to allow LanguageObjectHistory objects in contexts where LanguageObject objects are expected
	public function getDraft() {
		return $this;
	}
}

