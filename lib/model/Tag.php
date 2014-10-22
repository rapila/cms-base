<?php

require_once 'model/om/BaseTag.php';

/**
 * @package model
 */
class Tag extends BaseTag {
	public function getAllCorrespondingDataEntries($mType = null) {
		$aResults = array();
		$oCriteria = new Criteria();
		if($mType !== null) {
			if(is_array($mType)) {
				$oCriteria->add(TagInstancePeer::MODEL_NAME, $mType, Criteria::IN);
			} else {
				$oCriteria->add(TagInstancePeer::MODEL_NAME, $mType);
			}
		}
		foreach($this->getTagInstances($oCriteria) as $oTagInstance) {
			$oDataEntry = $oTagInstance->getCorrespondingDataEntry();
			if($oDataEntry === null) {
				continue;
			}
			$aResults[] = $oDataEntry;
		}
		return $aResults;
	}

	public function setName($sNewName) {
		$sNewName = StringUtil::normalizePath($sNewName);
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

	public function countTagInstancesByModel($sModelName) {
	  $oCriteria = new Criteria();
	  $oCriteria->add(TagInstancePeer::MODEL_NAME, $sModelName);
	  return $this->countTagInstances($oCriteria);
	}

	public function getLanguageIdsOfStrings() {
		$aLanguages = StringQuery::create()->filterByStringKey('tag.'.$this->getName())->select('LanguageId')->find()->toArray();
		if(is_array($aLanguages) && !empty($aLanguages)) {
			return $aLanguages;
		}
		return null;
	}
}

