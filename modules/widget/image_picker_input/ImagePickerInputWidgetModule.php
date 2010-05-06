<?php
/**
 * @package modules.widget
 */
class ImagePickerInputWidgetModule extends PersistentWidgetModule {
	
	private $aAllowedCategories = null;
	private $oImagePicker = null;
	
	public function __construct($sSessionKey = null) {
		parent::__construct($sSessionKey);
		$this->oImagePicker = new ImagePickerWidgetModule();
		$this->oImagePicker->setAllowsMultiselect(false);
	}
	
	public static function includeResources($oResourceIncluder = null) {
		if($oResourceIncluder === null) {
			$oResourceIncluder = ResourceIncluder::defaultIncluder();
		}
		$oResourceIncluder->startDependencies();
		ImagePickerWidgetModule::includeResources($oResourceIncluder);
		self::includeWidgetResources(true, $oResourceIncluder);
	}
	
	public function doWidget() {
		$this->oImagePicker->doWidget();
		$oTemplate = $this->constructTemplate();
		$oTemplate->replaceIdentifier('session_key', $this->oImagePicker->sPersistentSessionKey);
		$oTemplate->replaceIdentifier('input_name', $this->sInputName);
		return $oTemplate;
	}
	
	public function setAllowedCategories($aAllowedCategories) {
		$this->aAllowedCategories = $aAllowedCategories;
	}
}