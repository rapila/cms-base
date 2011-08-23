<?php

class RecentActivityWidgetModule extends PersistentWidgetModule {
	public function listRecentlyChanged($aSettings) {
		$aResult = array();
		$iSeconds = $aSettings['days']*25*60*60;
		foreach($aSettings['models'] as $sModelName) {
			if($sModelName === false) {
				continue;
			}
			$sQueryClass = "{$sModelName}Query";
			$oCriteria = $sQueryClass::create();
			$oCriteria->filterByUpdatedAt(array('min' => time()-$iSeconds));
			$oCriteria->orderByUpdatedAt(Criteria::DESC);
			foreach($oCriteria->find() as $oModelObject) {
				$oUser = $oModelObject->getUserRelatedByCreatedBy();
				$sUserName = $oUser ? $oUser->getUsername() : 'root';
				$sMessage = "$sModelName ".Util::nameForObject($oModelObject)." updated by $sUserName on ".$oModelObject->getUpdatedAt();
				$aResult[] = array('message' => $sMessage);
			}
			$oCriteria = $sQueryClass::create();
			$oCriteria->filterByCreatedAt(array('min' => time()-$iSeconds));
			$oCriteria->orderByCreatedAt(Criteria::DESC);
			foreach($oCriteria->find() as $oModelObject) {
				$oUser = $oModelObject->getUserRelatedByCreatedBy();
				$sUserName = $oUser ? $oUser->getUsername() : 'root';
				$sMessage = "$sModelName ".Util::nameForObject($oModelObject)." created by $sUserName on ".$oModelObject->getCreatedAt();
				$aResult[] = array('message' => $sMessage);
			}
		}
		return $aResult;
	}
}
