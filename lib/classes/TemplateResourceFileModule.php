<?php

abstract class TemplateResourceFileModule extends FileModule {
	protected $sResourceType;
	protected $sModuleName;
	protected $sModuleType;
	
	public static $RESOURCE_TYPES = array(ResourceIncluder::RESOURCE_TYPE_CSS, ResourceIncluder::RESOURCE_TYPE_JS, 'html');
	
	public function __construct($aRequestPath) {
		parent::__construct($aRequestPath);
		$this->sResourceType = Manager::usePath();
		if(!in_array($this->sResourceType, self::$RESOURCE_TYPES)) {
			throw new Exception("Error in ".__METHOD__.": Resource type $this->sResourceType not allowed");
		}
		$this->sModuleName = Manager::usePath();
		$this->sModuleType = $this->getModuleType();
	}
	
	public function renderFile() {
		$iTemplateFlags = 0;
		$oResourceFinder = ResourceFinder::create(array(DIRNAME_MODULES, $this->sModuleType, $this->sModuleName, DIRNAME_TEMPLATES))->returnObjects();
		$sFileName = "$this->sModuleName.$this->sModuleType.$this->sResourceType";
		$oResourceFinder->addPath($sFileName.Template::$SUFFIX);
		if($this->sResourceType === ResourceIncluder::RESOURCE_TYPE_CSS) {
			header("Content-Type: text/css;charset=utf-8");
			$oResourceFinder->all();
		} else if($this->sResourceType === ResourceIncluder::RESOURCE_TYPE_JS) {
			header("Content-Type: text/javascript;charset=utf-8");
			$iTemplateFlags = Template::ESCAPE|Template::NO_HTML_ESCAPE;
		} else {
			header("Content-Type: text/html;charset=utf-8");
		}
		$oCache = new Cache('template_resource-'.$sFileName.'-'.Session::language(), 'resource');
		$oTemplate = null;
		if($oCache->entryExists() && !$oCache->isOutdated($oResourceFinder)) {
			$oCache->sendCacheControlHeaders();
			$oTemplate = $oCache->getContentsAsVariable();
		} else {
			$oTemplate = new Template(TemplateIdentifier::constructIdentifier('contents'), null, true, false, null, $sFileName);
			$aResources = $oResourceFinder->find();
			if(!$aResources) {
				$aResources = array();
			}
			if($aResources instanceof FileResource) {
				$aResources = array($aResources);
			}
			foreach($aResources as $oResource) {
				$oSubTemplate = new Template($oResource, null, false, false, null, null, $iTemplateFlags);
				$oTemplate->replaceIdentifierMultiple('contents', $oSubTemplate, null, Template::LEAVE_IDENTIFIERS);
			}
			$oCache->setContents($oTemplate);
			$oCache->sendCacheControlHeaders();
		}
		print($oTemplate->render());
	}
	
	protected abstract function getModuleType();
	
	public static function includeAvailableResources($mModule, $bEndDependenciesOnJS = false, $oResourceIncluder = null, $aParameters = null) {
		if($aParameters === null) {
			$aParameters = array_fill_keys(self::$RESOURCE_TYPES, array());
		}
		$sModuleName = null;
		$sModuleType = null;
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
		if($aParameters === null) {
			$aParameters = array();
		}
		$sFileModule = str_replace('template_', "{$sModuleType}_", self::getNameByClassName(get_class()));
		$sFileName = "$sModuleName.$sModuleType.$sResourceType.tmpl";
		if(ResourceFinder::findResource(array(DIRNAME_MODULES, $sModuleType, $sModuleName, DIRNAME_TEMPLATES, "$sFileName")) === null) {
			return null;
		}
		return LinkUtil::link(array($sFileModule, $sResourceType, $sModuleName), 'FileManager', $aParameters);
	}
}
