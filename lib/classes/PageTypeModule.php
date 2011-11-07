<?php
/**
 */
abstract class PageTypeModule extends Module {
	protected static $MODULE_TYPE = 'page_type';
	
	protected $oPage;
	protected $oNavigationItem;

	public function __construct(Page $oPage = null, NavigationItem $oNavigationItem = null) {
		$this->oPage = $oPage;
		$this->oNavigationItem = $oNavigationItem;
	}
	
	public abstract function display(Template $oTemplate, $bIsPreview = false);
	
	public function setIsDynamicAndAllowedParameterPointers(&$bIsDynamic, &$aAllowedParams, $aModulesToCheck = null) {}
	
	//Warning: different than normal
	public static function getModuleInstance($sModuleName = null) {
		$aArgs = func_get_args();
		if(!$sModuleName) {
			$aArgs[0] = "default";
		}
		array_unshift($aArgs, self::getType());
		return call_user_func_array(array('Module', 'getModuleInstanceByTypeAndName'), $aArgs);
	}
}
