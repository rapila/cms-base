<?php
require_once 'model/om/BaseContentObject.php';

/**
 * classname ContentObject
 * @package model
 */
class ContentObject extends BaseContentObject {
	
	const UNUSED_OBJECTS_KEY = '_unused_objects';

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

	public function sortIntoNew($sNewContainer = false, $iNewPosition = false) {
		$sOldContainer = $this->getContainerName();
		$iOldPosition = $this->getSort();
		//Phase 1: Resort old container
		if(!$this->isNew()) {
			$this->prepareContainerForReSort($sOldContainer, $iOldPosition, PHP_INT_MAX);
		}
		//Phase 2: Prepare list of new container for insertion
		if($sNewContainer !== false && $iNewPosition !== false) {
			$this->prepareContainerForReSort($sNewContainer, PHP_INT_MAX, $iNewPosition);
		}
		//Set container name to NULL if the Object is created or moved again to
		$this->setContainerName($sNewContainer);
		$this->setSort($iNewPosition);
	}
	
	public function setContainerName($sValue) {
		return parent::setContainerName(self::normalizeContainerName($sValue));
	}

	public function sortInsideExisting($iNewPosition) {
		$sContainer = $this->getContainerName();
		$iOldPosition = $this->getSort();
		$this->prepareContainerForReSort($sContainer, $iOldPosition, $iNewPosition);
		$this->setSort($iNewPosition);
	}

	private function prepareContainerForReSort($sNewContainer, $iOldPosition, $iNewPosition) {
		$sNewContainer = self::normalizeContainerName($sNewContainer);
		$iDelta = $iNewPosition > $iOldPosition ? -1 : 1;
		$iMinPos = min($iOldPosition, $iNewPosition);
		$iMaxPos = max($iOldPosition, $iNewPosition);
		$oQuery = ContentObjectQuery::create()->orderBySort();
		foreach($oQuery->filterById($this->getId(), "<>")->filterByPageId($this->getPageId())->filterByContainerName($sNewContainer)->filterBySort($iMinPos, ">=")->filterBySort($iMaxPos, "<=")->find() as $oObject) {
			$oObject->setSort($oObject->getSort()+$iDelta);
			$oObject->save();
		}
	}

	/**
	* Normalizes the container name
	*/
	public function normalizeContainerName($sContainerName) {
		return $sContainerName !== self::UNUSED_OBJECTS_KEY ? $sContainerName : null;
	}
}
