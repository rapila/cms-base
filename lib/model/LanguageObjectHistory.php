<?php

require_once 'model/om/BaseLanguageObjectHistory.php';


/**
 * @package		 model
 */
class LanguageObjectHistory extends BaseLanguageObjectHistory {

	public function getName() {
		return 'Backup '.$this->getRevision().', '.$this->getCreatedAt('Y-m-d').' / '.$this->getUser()->getInitials();
	}
	
	private function getNextRevision() {
		$oLanguageObjectHistory = LanguageObjectHistoryPeer::doSelectOne(LanguageObjectHistoryPeer::getHistoryByObjectAndLanguageIdCriteria($this->getObjectId(), $this->getLanguageId()));
		if($oLanguageObjectHistory !== null) {
			return ($oLanguageObjectHistory->getRevision()+1);
		}
		return 1;
	}
}

