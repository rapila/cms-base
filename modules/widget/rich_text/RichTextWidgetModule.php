<?php
/**
 * @package modules.widget
 */
class RichTextWidgetModule extends PersistentWidgetModule {
	
	private $oImagePickerWidget;
	private $sModuleContents;
	
	public function __construct($sSessionKey = null, $sModuleContents = null) {
		parent::__construct($sSessionKey);
		$this->oImagePickerWidget = new ImagePickerWidgetModule();
		$this->oImagePickerWidget->setAllowsMultiselect(true);
		$this->sModuleContents = $sModuleContents;
	}
	
	public static function includeResources($oResourceIncluder = null) {
		if($oResourceIncluder === null) {
			$oResourceIncluder = ResourceIncluder::defaultIncluder();
		}
		$oResourceIncluder->startDependencies();
		ImagePickerWidgetModule::includeResources($oResourceIncluder);
		self::includeWidgetResources(true, $oResourceIncluder);
		$oCkEditor = ResourceFinder::findResourceObject(array('web', 'js', 'admin', 'ckeditor'));
		$oResourceIncluder->addCustomJs('CKEDITOR_BASEPATH = "'.$oCkEditor->getFrontendPath().'/";');
		$oResourceIncluder->addResource('admin/ckeditor/ckeditor.js');
	}
	
	public function getElementType() {
		return new TagWriter('textarea', array('data-widget-picker-session' => $this->oImagePickerWidget->getSessionKey()));
	}
	
	public function getModuleContents() {
		return $this->sModuleContents;
	}
}