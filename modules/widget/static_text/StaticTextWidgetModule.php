<?php

class StaticTextWidgetModule extends PersistentWidgetModule {
	public static function includeResources($oResourceIncluder = null) {
		if($oResourceIncluder === null) {
			$oResourceIncluder = ResourceIncluder::defaultIncluder();
		}
		$oResourceIncluder->startDependencies();
		self::includeWidgetResources(true, $oResourceIncluder);
		$oCkEditor = ResourceFinder::findResourceObject(array('web', 'js', 'widget', 'ckeditor'));
		$oResourceIncluder->addCustomJs('CKEDITOR_BASEPATH = "'.$oCkEditor->getFrontendPath().'/";');
		$oResourceIncluder->addResource('widget/ckeditor/ckeditor.js');
	}
}