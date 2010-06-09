<?php

abstract class TemplateResourceFileModule extends FileModule {
	protected $sResourceType;
	protected $sModuleName;
	protected $sModuleType;
	
	public static $RESOURCE_TYPES = array(ResourceIncluder::RESOURCE_TYPE_CSS, ResourceIncluder::RESOURCE_TYPE_JS, 'html');
	
	public function __construct($aRequestPath) {
		parent::__construct($aRequestPath);
		$this->sResourceType = Manager::usePath();
		if(!in_array($this->sResourceType, array(ResourceIncluder::RESOURCE_TYPE_CSS, ResourceIncluder::RESOURCE_TYPE_JS, 'html'))) {
			throw new Exception("Error in ".__METHOD__.": Resource type $this->sResourceType not allowed");
		}
		$this->sModuleName = Manager::usePath();
		$this->sModuleType = $this->getModuleType();
	}
	
	public function renderFile() {
		$iTemplateFlags = 0;
		if($this->sResourceType === ResourceIncluder::RESOURCE_TYPE_CSS) {
			header("Content-Type: text/css;charset=utf-8");
		} else if($this->sResourceType === ResourceIncluder::RESOURCE_TYPE_JS) {
			header("Content-Type: text/javascript;charset=utf-8");
			$iTemplateFlags = Template::ESCAPE;
		} else {
			header("Content-Type: text/html;charset=utf-8");
		}
		$oTemplate = new Template("$this->sModuleType.$this->sResourceType", array(DIRNAME_MODULES, $this->sModuleType, $this->sModuleName, DIRNAME_TEMPLATES), false, true, null, null, $iTemplateFlags);
		$oTemplate->render();
	}
	
	protected abstract function getModuleType();
	
	public static function includeAvailableResources($mModule, $bEndDependenciesOnJS = false, $oResourceIncluder = null, $aParameters = null) {
		if($aParameters === null) {
			$aParameters = array_fill_keys(self::$RESOURCE_TYPES, array());
		}
		$sModuleName;
		$sModuleType;
	  if($mModule instanceof Module) {
  		$sModuleName = $mModule->getModuleName();
  		$sModuleType = $mModule->getType();
	  } else {
      $sModuleName = $mModule::getNameByClassName($mModule);
      $sModuleType = $mModule::getType();
	  }
		if($oResourceIncluder === null) {
			$oResourceIncluder = ResourceIncluder::defaultIncluder();
		}
		foreach(self::$RESOURCE_TYPES as $sResourceType) {
			$sResourceLink = self::getAvailableResource($sModuleName, $sModuleType, $sResourceType, @$aParameters[$sResourceType]);
			if($sResourceLink !== null) {
				if($sResourceType === ResourceIncluder::RESOURCE_TYPE_JS && $bEndDependenciesOnJS) {
					$oResourceIncluder->addResourceEndingDependency($sResourceLink, $sResourceType);
				} else {
					$oResourceIncluder->addResource($sResourceLink, $sResourceType);
				}
			}
		}
	}
	
	public static function getAvailableResource($sModuleName, $sModuleType, $sResourceType, $aParameters) {
		$sFileModule = str_replace('template_', "{$sModuleType}_", self::getNameByClassName(get_class()));
		$sFileName = "$sModuleType.$sResourceType.tmpl";
		if(ResourceFinder::findResource(array(DIRNAME_MODULES, $sModuleType, $sModuleName, DIRNAME_TEMPLATES, "$sFileName")) === null) {
			return null;
		}
		return LinkUtil::link(array($sFileModule, $sResourceType, $sModuleName), 'FileManager', $aParameters);
	}
}