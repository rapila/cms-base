<?php

	// include base peer class
	require_once 'model/om/BaseReferencePeer.php';

	// include object class
	include_once 'model/Reference.php';


/**
 * @package		 model
 */
class ReferencePeer extends BaseReferencePeer {
	private static $aUnsavedReferences = array();

	/**
	* adds a reference track from an object to another if that reference does not already exist
	* expects objects or arrays in the form array(id, 'ModelName')
	*/
	public static function addReference($mFromObject, $mToObject) {
		if($mFromObject instanceof BaseObject && $mFromObject->isNew()) {
			self::$aUnsavedReferences[] = array($mFromObject, $mToObject);
			return;
		}

		self::prepareObjectArgument($mFromObject);
		self::prepareObjectArgument($mToObject);
		if(self::referenceExists($mFromObject, $mToObject)) {
			return;
		}

		$oReference = new Reference();
		$oReference->setFromId($mFromObject[0]);
		$oReference->setFromModelName($mFromObject[1]);
		$oReference->setToId($mToObject[0]);
		$oReference->setToModelName($mToObject[1]);
		try {
			$oReference->save();
		} catch (PropelException $ex) {
			if($ex->getCause() instanceof NotPermittedException) {
				//Silently discard NotPermittedException because the FromObject won’t be saved either
			} else {
				throw $ex;
			}
		}
	}

	public static function referenceExists($mFromObject, $mToObject) {
		$oCriteria = self::prepareCriteria($mFromObject, $mToObject);
		return $oCriteria->count() !== 0;
	}

	public static function countReferences($mToObject) {
		$oCriteria = self::prepareCriteria(null, $mToObject);
		return $oCriteria->count();
	}

	public static function hasReference($mToObject) {
		TestReferencesFileModule::checkReferences(self::getReferences($mToObject), true);
		return self::countReferences($mToObject) !== 0;
	}

	public static function getReferences($mToObject) {
		$oCriteria = self::prepareCriteria(null, $mToObject);
		return $oCriteria->find();
	}

	public static function getReferencesFromObject($mFromObject) {
		$oCriteria = self::prepareCriteria($mFromObject);
		return $oCriteria->find();
	}

	public static function removeReferences($mFromObject, $mToObject = null) {
		$oCriteria = self::prepareCriteria($mFromObject, $mToObject);
		foreach($oCriteria->find() as $oReference) {
			try {
				$oReference->delete();
			} catch (PropelException $ex) {
				if($ex->getCause() instanceof NotPermittedException) {
					//Silently discard NotPermittedException because the FromObject won’t be deleted either
				} else {
					throw $ex;
				}
			}
		}
	}

	public static function removeReference($mFromObject, $mToObject) {
		self::removeReferences($mFromObject, $mToObject);
	}

	public static function saveUnsavedReferences($oFromObjectFilter = null) {
		$aUnsavedReferences = self::$aUnsavedReferences;
		self::$aUnsavedReferences = array();
		foreach($aUnsavedReferences as $aUnsavedReference) {
			if($oFromObjectFilter !== null) {
				$bIsEqual = method_exists($oFromObjectFilter, 'equals') ? $oFromObjectFilter->equals($aUnsavedReference[0]) : $oFromObjectFilter === $aUnsavedReference[0];
				if(!$bIsEqual) {
					continue;
				}
			}
			$aUnsavedReference[0]->setNew(false);
			self::addReference($aUnsavedReference[0], $aUnsavedReference[1]);
		}
		return count(self::$aUnsavedReferences);
	}

	private static function prepareObjectArgument(&$mObject) {
		if(is_object($mObject)) {
			$mObject = array($mObject->getPKString(), get_class($mObject));
		}
	}

	private static function prepareCriteria($mFromObject = null, $mToObject = null) {
		$oCriteria = ReferenceQuery::create();
		if($mFromObject !== null) {
			self::prepareCriteriaFrom($oCriteria, $mFromObject);
		}
		if($mToObject !== null) {
			self::prepareCriteriaTo($oCriteria, $mToObject);
		}
		return $oCriteria;
	}

	private static function prepareCriteriaFrom($oCriteria, $mFromObject) {
		self::prepareObjectArgument($mFromObject);
		$oCriteria->filterByFromId($mFromObject[0]);
		$oCriteria->filterByFromModelName($mFromObject[1]);
	}

	private static function prepareCriteriaTo($oCriteria, $mToObject) {
		self::prepareObjectArgument($mToObject);
		$oCriteria->filterByToId($mToObject[0]);
		$oCriteria->filterByToModelName($mToObject[1]);
	}

	public static function mayOperateOn($oUser, $mObject, $sOperation) {
		$sSourcePeer = "{$mObject->getFromModelName()}Peer";
		//Take semantics from FROM object
		return $sSourcePeer::mayOperateOn($oUser, $mObject->getFrom(), $sOperation);
	}
}

