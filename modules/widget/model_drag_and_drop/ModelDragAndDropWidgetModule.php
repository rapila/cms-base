<?php

/**
* @package widget
*/

class ModelDragAndDropWidgetModule extends WidgetModule {
	
	public function drop($sDroppedModelName, $mDroppedId, $sDroppableModelName, $mDroppableId) {
		$sPeerClass = "{$sDroppedModelName}Peer";
		if(method_exists($sPeerClass, 'droppedOnto')) {
			$mResult = $sPeerClass::droppedOnto($mDroppedId, $sDroppableModelName, $mDroppableId);
			if(is_string($mResult)) {
				$mResult = array('status' => $mResult);
			}
			return $mResult;
		}
		return false;
	}
	
	public function getPossibleTargetsFor($sModelName) {
		$sPeerClass = "{$sModelName}Peer";
		if(method_exists($sPeerClass, 'dropTargets')) {
			return $sPeerClass::dropTargets();
		}
		return array();
	}
	
	public static function isSingleton() {
		return true;
	}
}
