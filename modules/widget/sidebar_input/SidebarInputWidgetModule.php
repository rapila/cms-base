<?php
/**
 * @package modules.widget
 */
class SidebarInputWidgetModule extends WidgetModule {
	
	public function createEntry($sModelName, $sItemName) {
		if(!method_exists($sModelName, 'setName')) {
			return false;
		}
		// maybe you have to create custom filterByName() and setName()
		$sQueryClass = "{$sModelName}Query";
		if($sQueryClass::create()->filterByName($sItemName)->count() > 0) {
			throw new LocalizedException("wns.input.object_exists");
		}
		$oModel = new $sModelName();
		$oModel->setName($sItemName);

		$oResult = new StdClass();
		$oResult->inserted = true;
		$oResult->saved = $oModel->save();
		$oResult->id = $oModel->getPrimaryKey();

		return $oResult;
	}
	
	public static function isSingleton() {
		return true;
	}
}
