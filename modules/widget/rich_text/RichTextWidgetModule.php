<?php
/**
 * @package modules.widget
 */
class RichTextWidgetModule extends PersistentWidgetModule {

	private $sModuleContents;
	private $aModuleSettings;

	public function __construct($sSessionKey = null, $sModuleContents = null, $mModuleSettings = null) {
		parent::__construct($sSessionKey);
		$this->sModuleContents = $sModuleContents;
		if($mModuleSettings === null || is_string($mModuleSettings)) {
			$this->aModuleSettings = Settings::getSetting('text_module', null, array());
			if($mModuleSettings !== null) {
				$this->aModuleSettings = array_merge($this->aModuleSettings, Settings::getSetting($mModuleSettings, 'text_module', array()));
			}
		} else {
			$this->aModuleSettings = $mModuleSettings;
		}
		$this->cleanupCss();
		$this->cleanupStyles();
		$this->cleanupFormatTags();
		$this->cleanupInsertableParts();
		$this->cleanupToolbar();
		foreach($this->aModuleSettings as $sKey => $mSetting) {
			$this->setSetting($sKey, $mSetting);
		}

		// let CKEDITOR find plugins
		$aPlugins = array();
		foreach(ResourceFinder::create()->addPath(DIRNAME_WEB, ResourceIncluder::RESOURCE_TYPE_JS, 'widget', 'ckeditor-plugins')->addDirPath()->addRecursion()->addPath('plugin.js')->returnObjects()->find() as $oPluginPath) {
			$oPluginPath = $oPluginPath->parent();
			$aPlugins[$oPluginPath->getFileName()] = $oPluginPath->getFrontendPath().'/';
		}
		if(count($aPlugins) === 0) {
			$aPlugins = null;
		}
		$this->setSetting('additional_plugin_paths', $aPlugins);

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
		$aCssUrls = array();
		//Important for CSS
		if(!isset($this->aModuleSettings['css_files'])) {
			if(is_string($mTemplate)) {
				$mTemplate = new Template($mTemplate);
			}
			$oIncluder = new ResourceIncluder();
			foreach($mTemplate->identifiersMatching('addResourceInclude', Template::$ANY_VALUE) as $oIdentifier) {
				$oIncluder->addResourceFromTemplateIdentifier($oIdentifier);
			}
			$aResources = $oIncluder->getAllIncludedResources();
			foreach($aResources as $aResourceInfo) {
				if(!(isset($aResourceInfo['resource_type']) && $aResourceInfo['resource_type'] === ResourceIncluder::RESOURCE_TYPE_CSS)) {
					continue;
				}
				if(isset($aResourceInfo['ie_condition'])) {
					continue;
				}
				if(isset($aResourceInfo['media']) && !preg_match('/\\b(screen|all)\\b/', $aResourceInfo['media'])) {
					continue;
				}
				$aCssUrls[] = $aResourceInfo['location'];
			}
			//Always include an editor.css file if found
			foreach(ResourceFinder::findAllResourceObjects(array(DIRNAME_WEB, 'css', 'editor.css')) as $oFileUrl) {
				$aCssUrls[] = $oFileUrl->getFrontendPath();
			}
		}
		$this->setSetting('contentsCss', $aCssUrls);
	}

	private function cleanupCss() {
		$aCssUrls = array();
		if(isset($this->aModuleSettings['css_files'])) {
			if(!is_array($this->aModuleSettings['css_files'])) {
				$this->aModuleSettings['css_files'] = array($this->aModuleSettings['css_files']);
			}
			foreach($this->aModuleSettings['css_files'] as $sCssFile) {
				$oFileUrl = ResourceFinder::findResourceObject(array(DIRNAME_WEB, 'css', "$sCssFile.css"));
				if($oFileUrl !== null) {
					$aCssUrls[] = $oFileUrl->getFrontendPath();
				}
			}
		}
		unset($this->aModuleSettings['css_files']);
		$this->setSetting('contentsCss', $aCssUrls);
	}

	private function cleanupStyles() {
		$aClasses = array();
		if(isset($this->aModuleSettings['classes'])) {
			$aClasses = $this->aModuleSettings['classes'];
			unset($this->aModuleSettings['classes']);
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
			$this->setSetting('stylesSet', 'default');
		} else {
			$this->setSetting('stylesSet', $aResult);
		}
	}

	private function cleanupInsertableParts() {
		if(isset($this->aModuleSettings['insertable_parts'])) {
			foreach($this->aModuleSettings['insertable_parts'] as &$aPartSpec) {
				if(isset($aPartSpec['tooltip_string_key'])) {
					$aPartSpec['tooltip'] = StringPeer::getString($aPartSpec['tooltip_string_key']);
					unset($aPartSpec['tooltip_string_key']);
				}
				if(!isset($aPartSpec['template'])) {
					continue;
				}
				$oTemplate = new Template($aPartSpec['template']);
				$aPartSpec['content'] = $oTemplate->render();
				unset($aPartSpec['template']);
			}
		}
	}

	private function cleanupToolbar() {
		if(isset($this->aModuleSettings['toolbar'])) {
			$aResult = array();
			foreach($this->aModuleSettings['toolbar'] as $i => $aRowElements) {
				$aResult = array_merge($aResult, $aRowElements, array('/'));
			}
			array_pop($aResult);
			$this->setSetting('toolbar', $aResult);
			unset($this->aModuleSettings['toolbar']);
		}
	}

	private function cleanupFormatTags() {
		$aTags = array();
		if(isset($this->aModuleSettings['blockformats'])) {
			foreach($this->aModuleSettings['blockformats'] as $mFormat) {
				if(is_string($mFormat)) {
					$mFormat = array('element' => $mFormat);
				}
				$sKey = 'format_'.Util::uuid();
				$this->setSetting($sKey, $mFormat);
				$aTags[] = $mFormat['element'];
			}
			unset($this->aModuleSettings['blockformats']);
		}
		if(count($aTags) == 0) {
			$this->setSetting('format_tags', 'p;h1;h2;h3;h4;h5;h6;pre;address;div');
		} else {
			$this->setSetting('format_tags', implode(';', $aTags));
		}
	}

	public function getSettings($sKey, $mDefault = null) {
		if(isset($this->aModuleSettings[$sKey])) {
			return $this->aModuleSettings[$sKey];
		}
		return $mDefault;
	}

	public function getElementType() {
		return new TagWriter('div', array(), new TagWriter('textarea', array(), ' '));
	}

	public function getModuleContents() {
		return $this->sModuleContents;
	}
}
