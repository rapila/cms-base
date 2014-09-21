<?php
require_once 'model/om/BaseContentObject.php';

/**
 * classname ContentObject
 * @package model
 */
class ContentObject extends BaseContentObject {

	public function getLanguageObject($sLanguageId = null) {
		if($sLanguageId === null) {
			$sLanguageId = Session::language();
		}
		$oResult = $this->getLanguageObjectsByLanguage($sLanguageId);
		if(count($oResult) === 0) {
			return null;
		}
		return $oResult[0];
	}

	public function getLanguageObjectsByLanguage($sLanguage) {
		$oCriteria = new Criteria();
		$oCriteria->add(LanguageObjectPeer::LANGUAGE_ID, $sLanguage);
		return $this->getLanguageObjects($oCriteria);
	}

	public function hasLanguage($sLanguageId) {
		return $this->getLanguageObjectsByLanguage($sLanguageId) !== null;
	}

	public function getObjectTypeName($sLanguageId=null) {
		return FrontendModule::getDisplayNameByName($this->getObjectType(), $sLanguageId);
	}

	public function postSave(PropelPDO $oConnection = null) {
		PagePeer::ignoreRights(true);
		//Mark page as updated to flush full page caches
		$this->getPage()->save();
		PagePeer::ignoreRights(false);
	}

	public function sortIntoNew($sNewContainer = null, $iNewPosition = null) {
		$sOldContainer = $this->getContainerName();
		$iOldPosition = $this->getSort();
		//Phase 1: Resort existing
		if($sOldContainer !== null && $iOldPosition !== null) {
			$this->prepareContainerForReSort($sOldContainer, $iOldPosition, PHP_INT_MAX);
		}
		//Phase 2: Prepare list of new container for insertion
		if($sNewContainer !== null && $iNewPosition !== null) {
			$this->prepareContainerForReSort($sNewContainer, PHP_INT_MAX, $iNewPosition);
		}
		//Set container name to NULL if the Object is created or moved again to
		$this->setContainerName($sNewContainer !== 'unused_objects' ? $sNewContainer : NULL);
		$this->setSort($iNewPosition);
	}

	public function sortInsideExisting($iNewPosition) {
		$sContainer = $this->getContainerName();
		$iOldPosition = $this->getSort();
		$this->prepareContainerForReSort($sContainer, $iOldPosition, $iNewPosition);
		$this->setSort($iNewPosition);
	}

	private function prepareContainerForReSort($sNewContainer, $iOldPosition, $iNewPosition) {
		$iDelta = $iNewPosition > $iOldPosition ? -1 : 1;
		$iMinPos = min($iOldPosition, $iNewPosition);
		$iMaxPos = max($iOldPosition, $iNewPosition);
		$oQuery = ContentObjectQuery::create()->orderBySort();
		foreach($oQuery->filterById($this->getId(), "<>")->filterByPageId($this->getPageId())->filterByContainerName($sNewContainer)->filterBySort($iMinPos, ">=")->filterBySort($iMaxPos, "<=")->find() as $oObject) {
			$oObject->setSort($oObject->getSort()+$iDelta);
			$oObject->save();
		}
	}
}
