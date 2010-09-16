<?php
/**
 * @package modules.widget
 */
class RichTextWidgetModule extends PersistentWidgetModule {
	
	private $oImagePickerWidget;
	private $sModuleContents;
	private $aModuleSettings;
	
	public function __construct($sSessionKey = null, $sModuleContents = null, $aModuleSettings = null) {
		parent::__construct($sSessionKey);
		$this->oImagePickerWidget = new ImagePickerWidgetModule();
		$this->oImagePickerWidget->setAllowsMultiselect(true);
		$this->sModuleContents = $sModuleContents;
		if($aModuleSettings === null) {
			$aModuleSettings = Settings::getSetting('admin', 'text_module', array());
		}
		$this->aModuleSettings = $aModuleSettings;
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
	
	public function setObjectId($iObjectId) {
		//Important for CSS
		if(!isset($this->aModuleSettings['css_files'])) {
			$oContentObject = ContentObjectPeer::retrieveByPK($iObjectId);
			$oPage = PageQuery::create()->filterByContentObject($oContentObject)->findOne();
			$oTemplate = $oPage->getTemplate();
			$oTemplate->render();
			$oResourceIncluder = ResourceIncluder::defaultIncluder();
			$aResources = $oResourceIncluder->getAllIncludedResources();
			$aCssFiles = array();
			foreach($aResources as $aResourceInfo) {
				if($aResourceInfo['resource_type'] === 'css') {
					$aCssFiles[] = $aResourceInfo['location'];
				}
			}
			$this->aModuleSettings['css_files'] = $aCssFiles;
		}
	}
	
	public function getCssUrls() {
		$aResult = array();
		if(isset($this->aModuleSettings['css_files'])) {
			$aResult = $this->aModuleSettings['css_files'];
			if(!is_array($aResult)) {
				$aResult = array($aResult);
			}
		}
		return $aResult;
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
	
	public function getElementType() {
		return new TagWriter('textarea', array('data-widget-picker-session' => $this->oImagePickerWidget->getSessionKey()));
	}
	
	public function getModuleContents() {
		return $this->sModuleContents;
	}
}