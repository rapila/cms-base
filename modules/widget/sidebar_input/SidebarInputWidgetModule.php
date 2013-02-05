<?php
/**
 * @package modules.widget
 */
class SidebarInputWidgetModule extends WidgetModule {
	
	public function createEntry($sModelName, $sItemName) {
		if(!method_exists($sModelName, 'setName')) {
			return false;
		}
		return $this->createDefaultBaseObject($sModelName, $sItemName);
	}
	
	private function createDefaultBaseObject($sModelName, $sItemName) {
		// maybe you have to create custom filterByName() and setName()
		$sQueryClass = "{$sModelName}Query";
		if($sQueryClass::create()->filterByName($sItemName)->count() > 0) {
			throw new LocalizedException("wns.input.object_exists");
		}
		$oModel = new $sModelName();
		$oModel->setName($sItemName);

		$oResult = new StdClass();
		$oResult->id = $oModel->getPrimaryKey();
		$oResult->saved = $oModel->save();

		return $oResult;
	}
	
	public static function isSingleton() {
		return true;
	}
}