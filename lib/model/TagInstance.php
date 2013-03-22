<?php

require_once 'model/om/BaseTagInstance.php';


/**
 * @package model
 */ 
class TagInstance extends BaseTagInstance {
	public function getCorrespondingDataEntry() { 
		if($this->getModelName() != '') {
			$sModelQueryName = $this->getModelName()."Query";
			if(!@class_exists($sModelQueryName)) {
				return null;
			}
			return $sModelQueryName::create()->filterByPKString($this->getTaggedItemId())->findOne();
		}
		return null;
	}
	
	public function getTagName() {
		return $this->getTag()->getName();
	}
	
	//Returns the OBJECT's name. call getTagName() to get the tag name
	public function getName() {
		$oDataEntry = $this->getCorrespondingDataEntry();
		if($oDataEntry === null) {
			return $this->getTaggedItemId();
		}
		return Util::nameForObject($oDataEntry);
	}
	
	public function delete(PropelPDO $oConnection = null) {
		$oTag = $this->getTag();
		if(count($oTag->getTagInstances()) === 1) {
			$oTag->delete();
		}
		$mReturn = parent::delete($oConnection);
		$oTag->reloadInstances();
		return $mReturn;
	}
	
}

