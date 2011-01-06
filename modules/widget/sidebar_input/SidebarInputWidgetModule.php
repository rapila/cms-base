<?php
/**
 * @package modules.widget
 */
class SidebarInputWidgetModule extends WidgetModule {
	
	public function createEntry($sModelName, $sItemName) {
		if(method_exists($sModelName, 'setName')) {
			return array('saved' => $this->createDefaultBaseObject($sModelName, $sItemName));
		}
	}
	
	private function createDefaultBaseObject($sModelName, $sItemName) {
		$sPeerClassName = "{$sModelName}Peer";
		$oCriteria = new Criteria();
		$oCriteria->add(constant("$sPeerClassName::NAME"), $sItemName);
		if($sPeerClassName::doCount($oCriteria) > 0) {
			throw new LocalizedException("wns.input.object_exists");
		}
		$oModel = new $sModelName();
		$oModel->setName($sItemName);
		return $oModel->save();
	}
	
	public static function isSingleton() {
		return true;
	}
}