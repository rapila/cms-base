<?php
/**
 */
abstract class PageTypeModule extends Module {
	protected static $MODULE_TYPE = 'page_type';
	
	protected $oPage;
	
	public function __construct(Page $oPage) {
		$this->oPage = $oPage;
	}
	
	public abstract function display(Template $oTemplate);
	public abstract function backendDisplay();
	public abstract function backendSave();
	public abstract function backendInit();
	public $backendCustomJs = "";
	
	public function setIsDynamicAndAllowedParameterPointers(&$bIsDynamic, &$aAllowedParams, $aModulesToCheck = null) {}
	
	protected function backendLink($aPath = array(), $aParameters = array()) {
		array_unshift($aPath, "content");
		return LinkUtil::link($aPath, 'BackendManager', $aParameters);
	}

	/**
	* Returns the class name of the main model that is being modified at the moment by the backend module
	* Used only to assign tags using the tag panel
	* Default is null
	*/
	public function getModelName() {return null;}
	
	/**
	* Returns the primary key value of the main model ({@link getModelName}) row that is being modified at the moment by the backend module
	* Used only to assign tags using the tag panel
	* Default is null
	*/
	public function getCurrentId() {return null;}
	
	//Warning: different than normal
	public static function getModuleInstance($sModuleName = null) {
		$aArgs = func_get_args();
		if(!$sModuleName) {
			$aArgs[0] = "default";
		}
		return call_user_func_array(array('Module', 'getModuleInstance'), $aArgs);
	}
}