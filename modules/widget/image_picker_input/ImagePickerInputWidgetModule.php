<?php
/**
 * @package modules.widget
 */
class ImagePickerInputWidgetModule extends PersistentWidgetModule {
	
	private $aDisplayedCategories = null;
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
	
	public function getElementType() {
		return new TagWriter('input', array('type' => 'hidden'));
	}

	public function setDisplayedCategories($aDisplayedCategories) {
		$this->aDisplayedCategories = $aDisplayedCategories;
	}
}