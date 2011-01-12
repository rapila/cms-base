<?php

/**
* @package widget
*/

class ModelDragAndDropWidgetModule extends WidgetModule {
	
	public function drop($sDroppedModelName, $mDroppedId, $sDroppableModelName, $mDroppableId) {
		if($sDroppedModelName === 'Tag') {
			TagInstancePeer::newTagInstance($mDroppedId, $sDroppableModelName, $mDroppableId);
			return 'tagged';
		}
		return false;
	}
	
	public function getPossibleTargetsFor($sModelName) {
		//Everything can be tagged
		if($sModelName === 'Tag') {
			return '*';
		}
		
		return array();
	}
	
	public static function isSingleton() {
		return true;
	}
}