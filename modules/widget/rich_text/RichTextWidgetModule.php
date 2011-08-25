<?php
/**
 * @package modules.widget
 */
class RichTextWidgetModule extends PersistentWidgetModule {
	
	private $sModuleContents;
	private $aModuleSettings;
	private $aCssUrls;
	
	public function __construct($sSessionKey = null, $sModuleContents = null, $aModuleSettings = null) {
		parent::__construct($sSessionKey);
		$this->sModuleContents = $sModuleContents;
		if($aModuleSettings === null) {
			$aModuleSettings = Settings::getSetting('admin', 'text_module', array());
		}
		$this->aModuleSettings = $aModuleSettings;
		$this->aCssUrls = array();
		if(isset($this->aModuleSettings['css_files'])) {
			if(!is_array($this->aModuleSettings['css_files'])) {
				$this->aModuleSettings['css_files'] = array($this->aModuleSettings['css_files']);
			}
			foreach($this->aModuleSettings['css_files'] as $sCssFile) {
				$oFileUrl = ResourceFinder::findResourceObject(array(DIRNAME_WEB, 'css', "$sCssFile.css"));
				if($oFileUrl !== null) {
					$this->aCssUrls[] = $oFileUrl->getFrontendPath();
				}
			}
		}
    $this->setSetting('language', Session::language());
	}
	
	public static function includeResources($oResourceIncluder = null) {
		if($oResourceIncluder === null) {
			$oResourceIncluder = ResourceIncluder::defaultIncluder();
		}
		$oResourceIncluder->startDependencies();
		ImagePickerWidgetModule::includeResources($oResourceIncluder);
		self::includeWidgetResources(true, $oResourceIncluder);
		$oCkEditor = ResourceFinder::findResourceObject(array('web', 'js', 'widget', 'ckeditor'));
		$oResourceIncluder->addCustomJs('CKEDITOR_BASEPATH = "'.$oCkEditor->getFrontendPath().'/";');
		$oResourceIncluder->addResource('widget/ckeditor/ckeditor.js');
	}
	
	public function setTemplate($mTemplate) {
		//Important for CSS
		if(!isset($this->aModuleSettings['css_files'])) {
			if(is_string($mTemplate)) {
				$mTemplate = new Template($mTemplate);
			}
			$mTemplate->render();
			$oResourceIncluder = ResourceIncluder::defaultIncluder();
			$aResources = $oResourceIncluder->getAllIncludedResources();
			foreach($aResources as $aResourceInfo) {
				if($aResourceInfo['resource_type'] !== 'css') {
					continue;
				}
				if(isset($aResourceInfo['media']) && !preg_match('/\\b(screen|all)\\b/', $aResourceInfo['media'])) {
					continue;
				}
				$this->aCssUrls[] = $aResourceInfo['location'];
			}
			//Always include an editor.css file if found
			foreach(ResourceFinder::findAllResourceObjects(array(DIRNAME_WEB, 'css', 'editor.css')) as $oFileUrl) {
				$this->aCssUrls[] = $oFileUrl->getFrontendPath();
			}
		}
	}
	
	public function getCssUrls() {
		return $this->aCssUrls;
	}
	
	public function getStyles() {
		$aClasses = array();
		if(isset($this->aModuleSettings['classes'])) {
			$aClasses = $this->aModuleSettings['classes'];
		}
		$aResult = array();
		foreach($aClasses as $mKey => $sClassName) {
			$sTagName = 'span';
			if(!is_numeric($mKey)) {
				$sTagName = $sClassName;
				$sClassName = $mKey;
			}
			$aResult[] = array('name' => StringUtil::makeReadableName($sClassName), 'element' => $sTagName, 'attributes' => array('class' => $sClassName));
		}
		if(count($aResult) == 0) {
			return 'default';
		}
		return $aResult;
	}
	
	public function getFormatTags() {
		$aTags = array();
		if(isset($this->aModuleSettings['blockformats'])) {
			$aTags = $this->aModuleSettings['blockformats'];
		}
		if(count($aTags) == 0) {
			return 'p;h1;h2;h3;h4;h5;h6;pre;address;div';
		}
		return implode(';', $aTags);
	}
	
	public function getCustomConfiguration() {
		return Settings::getSetting('newsletter_plugin', 'richtext_settings', null);
	}
	
	public function getElementType() {
		return new TagWriter('div', array(), new TagWriter('textarea', array(), ' '));
	}
	
	public function getModuleContents() {
		return $this->sModuleContents;
	}
}
