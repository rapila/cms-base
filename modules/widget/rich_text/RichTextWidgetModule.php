<?php
/**
 * @package modules.widget
 */
class RichTextWidgetModule extends PersistentWidgetModule {
	
	private $oImagePickerWidget;
	
	public function __construct($sSessionKey = null) {
		parent::__construct($sSessionKey);
		$this->oImagePickerWidget = new ImagePickerWidgetModule();
		$this->oImagePickerWidget->setAllowsMultiselect(true);
	}
	
	public static function includeResources($oResourceIncluder = null) {
		if($oResourceIncluder === null) {
			$oResourceIncluder = ResourceIncluder::defaultIncluder();
		}
		$oResourceIncluder->startDependencies();
		ImagePickerWidgetModule::includeResources($oResourceIncluder);
		self::includeWidgetResources(true, $oResourceIncluder);
		$oResourceIncluder->addResource('admin/ckeditor/ckeditor.js');
	}
	
	public function doWidget() {
		$oTemplate = parent::doWidget();
		$oTemplate->replaceIdentifier('picker_session_key', $this->oImagePickerWidget->getSessionKey());
		return $oTemplate;
	}
}