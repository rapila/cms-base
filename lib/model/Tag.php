<?php

require_once 'model/om/BaseTag.php';

/**
 * @package model
 */ 
class Tag extends BaseTag {
	public function getAllCorrespondingDataEntries($sType=null) {
		$aResults = array();
		foreach($this->getTagInstances() as $oTagInstance) {
			$oDataEntry = $oTagInstance->getCorrespondingDataEntry();
			if($oDataEntry === null || ($sType !== null && $sType !== get_class($oDataEntry))) {
				continue;
			}
			$aResults[] = $oDataEntry;
		}
		return $aResults;
	}
	
	public function setName($sNewName) {
		$sNewName = StringUtil::normalize($sNewName);
		parent::setName($sNewName);
	}

	public function getReadableName() {
		return StringUtil::makeReadableName($this->getName());
	}
	
	public function reloadInstances() {
		$this->collTagInstances=null;
	}
	
	public function getTagInstanceCount() {
		return $this->countTagInstances();
	}
}

