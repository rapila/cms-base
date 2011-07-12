<?php
class ResourceIncluder {
	const DEFAULT_INSTANCE_NAME = 'ResourceIncluder_default';
	
	const RESOURCE_TYPE_CSS = 'css';
	const RESOURCE_TYPE_JS = 'js';
	const RESOURCE_TYPE_IMAGE = 'images';
	const RESOURCE_TYPE_ICON = 'icons';
	
	const PRIORITY_FIRST = -1;
	const PRIORITY_NORMAL = 0;
	const PRIORITY_LAST = 1;
	
	const LIBRARY_VERSION_NEWEST = 'newest';
	
	const RESOURCE_PREFIX_LIBRARY = 'lib_';
	const RESOURCE_PREFIX_CUSTOM = 'cust_';
	const RESOURCE_PREFIX_INTERNAL = 'int_';
	const RESOURCE_PREFIX_EXTERNAL = 'ext_';
	const IE_CONDITIONAL = '<!--[if {{condition}}]>{{content}}<![endif]-->';

	private static $INSTANCES = array();
	
	private static $IE_CONDITIONAL = null;
	
	private $aIncludedResources;
	private $aReverseDependencies;
	private $aCurrentDependencyStack;
	
	public static function namedIncluder($sName) {
		if(!isset(self::$INSTANCES[$sName])) {
			self::$INSTANCES[$sName] = new ResourceIncluder();
		}
		return self::$INSTANCES[$sName];
	}
	
	public static function defaultIncluder() {
		return self::namedIncluder(self::DEFAULT_INSTANCE_NAME);
	}
	
	public function __construct() {
		$this->clearIncludedResources();
		$this->aCurrentDependencyStack = array();
		$this->aReverseDependencies = array();
	}
	
	/**
	* Use this to start a new dependency stack. This means that all dependencies added between this call and a resource added with addResourceEndingDependency will have the latter added as dependees. This means: the resource added using addResourceEndingDependency will always come after all the resources added between the two calls. Whenever one of the dependencies is added again later, the dependee will be moved down.
	*/
	public function startDependencies() {
		array_unshift($this->aCurrentDependencyStack, array());
	}

	public function addResourceEndingDependency($mLocation, $sTemplateName = null, $sIdentifier = null, $aExtraInfo = array(), $iPriority = self::PRIORITY_NORMAL, $sIeCondition = null, $bIncludeAll = false) {
		$this->addResource($mLocation, $sTemplateName, $sIdentifier, $aExtraInfo, $iPriority, $sIeCondition, $bIncludeAll, true);
	}
	
	public function addResource($mLocation, $sTemplateName = null, $sIdentifier = null, $aExtraInfo = null, $iPriority = self::PRIORITY_NORMAL, $sIeCondition = null, $bIncludeAll = false, $bEndsDependencyList = false) {
		//Not allowed
		if($bIncludeAll && $sIdentifier !== null) {
			$sIdentifier = null;
		}
		if($aExtraInfo === null) {
			$aExtraInfo = array();
		}
		$sResourcePrefix = self::RESOURCE_PREFIX_EXTERNAL;
		$mFileResource = null;
		$sFinalLocation = null;
		if($mLocation instanceof FileResource) {
			//FileResource given (internal)
			$mFileResource = $mLocation;
		} else if(is_array($mLocation)) {
			//Array given, relative -> convert to FileResource (internal)
			if($bIncludeAll) {
				$mFileResource = ResourceFinder::findAllResourceObjects($mLocation);
			} else {
				$mFileResource = ResourceFinder::findResourceObject($mLocation);
			}
		} else if(!is_string($mLocation)) {
			//Unknown input type given -> throw Exception
			throw new Exception("Eror in ResourceIncluder->addResource(): given location $mLocation is in unknown format");
		} else if(preg_match('/\w+\:/', $mLocation) !== 0) {
			//Absolute URL given with protocol -> set Location directly (external)
			$sFinalLocation = $mLocation;
		} else if(StringUtil::startsWith($mLocation, '/')) {
			//Absolute location given -> check if it’s a path or a URL
			if(file_exists($mLocation)) {
				//Path given -> convert to FileResource (internal)
				$mFileResource = new FileResource($mLocation);
			} else {
				//URL given, set Location directly (external)
				$sFinalLocation = $mLocation;
			}
		} else {
			//Relative location can be given with resource type, and without resource type (which will then be determined by extension)
			$aLocation = explode('/', $mLocation);
			if($sTemplateName === null) {
				$sTemplateName = $this->findTemplateNameForLocation($aLocation[count($aLocation)-1]);
			}
			array_unshift($aLocation, DIRNAME_WEB, $sTemplateName);
			if($bIncludeAll) {
				$mFileResource = ResourceFinder::findAllResourceObjects($aLocation);
			} else {
				$mFileResource = ResourceFinder::findResourceObject($aLocation);
			}
		}
		
		if($sFinalLocation === null && $mFileResource === null && !$bIncludeAll) {
			throw new Exception("Error in ResourceIncluder->addResource(): Specified internal file $mLocation could not be found.");
		}
		
		if(!is_array($mFileResource)) {
			$mFileResource = array($mFileResource);
		}
		
		foreach($mFileResource as $oFileResource) {
			if($sFinalLocation === null) {
				$sFinalLocation = $oFileResource->getFrontendPath();
				$sResourcePrefix = self::RESOURCE_PREFIX_INTERNAL;
			}
			
			if($sTemplateName === null) {
				$sTemplateName = $this->findTemplateNameForLocation($sFinalLocation);
			}

			if($sIdentifier === null) {
				$sIdentifier = $sResourcePrefix.$sFinalLocation;
			}
			
			if(($iPrevResoucePriority = $this->containsResource($sIdentifier)) !== false) {
				$aExtraInfo = array_merge($this->aIncludedResources[$iPrevResoucePriority][$sIdentifier], $aExtraInfo);
				unset($this->aIncludedResources[$iPrevResoucePriority][$sIdentifier]);
			}
		
			$aExtraInfo['location'] = $sFinalLocation;
			if(!isset($aExtraInfo['resource_type'])) {
				$aExtraInfo['resource_type'] = $sTemplateName;
			}
			if(!isset($aExtraInfo['template'])) {
				$aExtraInfo['template'] = $sTemplateName;
			}
			if($sIeCondition !== null && !isset($aExtraInfo['ie_condition'])) {
				$aExtraInfo['ie_condition'] = $sIeCondition;
			}
			if(!isset($aExtraInfo['dependees'])) {
				$aExtraInfo['dependees'] = array();
			}
			if($oFileResource instanceof FileResource && !isset($aExtraInfo['file_resource'])) {
				$aExtraInfo['file_resource'] = $oFileResource;
			}
			if($bEndsDependencyList) {
				$this->endDependencyList($sIdentifier);
			}
			
			//Include resource
			$this->aIncludedResources[$iPriority][$sIdentifier] = $aExtraInfo;
			
			//move down all dependent resources that already exist
			foreach($aExtraInfo['dependees'] as $sDependeeIdentifier => $bTrue) {
				if(($iDependeePriority = $this->containsResource($sDependeeIdentifier)) !== false) {
					$aDependee = $this->aIncludedResources[$iDependeePriority][$sDependeeIdentifier];
					unset($this->aIncludedResources[$iDependeePriority][$sDependeeIdentifier]);
					$this->aIncludedResources[$iDependeePriority][$sDependeeIdentifier] = $aDependee;
				}
			}
			
			//Add dependency
			if(count($this->aCurrentDependencyStack) > 0) {
				$this->aCurrentDependencyStack[0][$sIdentifier] = true;
			}
			
			$sFinalLocation = null;
			$sIdentifier = null;
		}
	}
	
	public function addJavaScriptLibrary($sLibraryName, $sLibraryVersion, $bUseCompression = null, $bInlcudeDependencies = true, $bUseSsl = false, $iPriority = self::PRIORITY_NORMAL, $bUseLocalProxy = null) {
		if($bUseLocalProxy === null) {
			$bUseLocalProxy = Settings::getSetting('general', 'use_local_library_cache', 'auto', 'resource_includer');
			if($bUseLocalProxy === 'auto') {
				$bUseLocalProxy = ErrorHandler::getEnvironment() === 'development';
			}
		}
		if(!ini_get('allow_url_fopen')) {
			// Never use proxy if fopen_wrappers are disabled
			$bUseLocalProxy = false;
		}
		if($bUseCompression === null) {
			$bUseCompression = Settings::getSetting('general', 'use_compressed_libraries', 'auto', 'resource_includer');
			if($bUseCompression === 'auto') {
				$bUseCompression = ErrorHandler::getEnvironment() !== 'development';
			}
		}
		if(!is_string($sLibraryVersion)) {
			$sLibraryVersion = "$sLibraryVersion";
		}
		$aIncludes = array();
		if(strpos($sLibraryName, '?load=') !== false) {
			$aIncludes = explode(',', substr($sLibraryName, strpos($sLibraryName, '?load=')+strlen('?load=')));
			$sLibraryName = substr($sLibraryName, 0, strpos($sLibraryName, '?load='));
		}
		$sResourceIdentifier = self::RESOURCE_PREFIX_LIBRARY.$sLibraryName;
		$aLibraryOptions = Settings::getSetting('libraries', $sLibraryName, null, 'resource_includer');
		if($aLibraryOptions === null) {
			throw new Exception("Error in ResourceIncluder->addJavaScriptLibrary(): Library $sLibraryName not found. Libraries must be configured in the resource_includer.yml config file.");
		}
		if(is_string($aLibraryOptions)) {
			$aLibraryOptions = array('url' => $aLibraryOptions);
		}
		if(!$bUseCompression && !isset($aLibraryOptions['url_uncompressed'])) {
			$bUseCompression = true;
		}
		$sLibraryUrl = $aLibraryOptions[$bUseCompression ? 'url' : 'url_uncompressed'];
		
		//Handle duplicate includes
		if(($iPrevResoucePriority = $this->containsResource($sResourceIdentifier)) !== false) {
			$aResourceInfo = $this->aIncludedResources[$iPrevResoucePriority][$sResourceIdentifier];
			if(version_compare($aResourceInfo['version'], $sLibraryVersion, '>')) {
				// throw new Exception("Error in ResourceIncluder->addJavaScriptLibrary(): Library $sLibraryName ($sLibraryVersion) already included with different version ({$aResourceInfo['version']})");
				return;
			}
			if(version_compare($aResourceInfo['version'], $sLibraryVersion, '==') && ((!$aResourceInfo['use_compression'] && $bUseCompression) || ($aResourceInfo['use_compression'] === $bUseCompression))) {
				return;
			}
		}
		
		//Handle dependencies
		$aLibraryDependencies = $bInlcudeDependencies && Settings::getSetting('library_dependencies', $sLibraryName, null, 'resource_includer') !== null;
		if(is_array($aLibraryDependencies)) {
			$this->startDependencies();
			foreach($aLibraryDependencies as $sDependencyName => $sDependencyVersion) {
				$this->addJavaScriptLibrary($sDependencyName, $sDependencyVersion, $bUseCompression, true, $bUseSsl, $iPriority);
			}
		}
		
		if($bUseLocalProxy) {
			if(count($aIncludes) > 0) {
				$sLibraryName .= "?load=".implode(',', $aIncludes);
			}
			$this->addResource(LinkUtil::link(array('local_js_library', $sLibraryName), 'FileManager', array('version' => $sLibraryVersion, 'use_compression' => BooleanParser::stringForBoolean($bUseCompression), 'use_ssl' => BooleanParser::stringForBoolean($bUseSsl))), self::RESOURCE_TYPE_JS, $sResourceIdentifier, array('version' => $sLibraryVersion, 'use_compression' => $bUseCompression), $iPriority, null, false, false);
			return;
		}
		
		//Add resource
		$sLibraryUrl = str_replace('${version}', $sLibraryVersion, $sLibraryUrl);
		if($bUseSsl) {
			$sLibraryUrl = str_replace('http://', 'https://', $sLibraryUrl);
		}
		$this->addResource(str_replace('${library_name}', $sLibraryName, $sLibraryUrl), self::RESOURCE_TYPE_JS, $sResourceIdentifier, array('version' => $sLibraryVersion, 'use_compression' => $bUseCompression), $iPriority, null, false, is_array($aLibraryDependencies));
		
		//If includes are used (currently only scriptaculous does this)
		foreach($aIncludes as $sIncludeName) {
			$this->addResource(str_replace('${library_name}', $sIncludeName, $sLibraryUrl), self::RESOURCE_TYPE_JS, "$sResourceIdentifier-include_$sIncludeName", array('version' => $sLibraryVersion, 'use_compression' => $bUseCompression, 'dependees' => array($sResourceIdentifier)), $iPriority);
		}
	}
	
	public function addCustomResource($aResourceInfo, $iPriority = self::PRIORITY_NORMAL, $bEndsDependencyList = false) {
		$sIdentifier = self::RESOURCE_PREFIX_CUSTOM.md5(serialize($aResourceInfo));
		if(($iPrevResoucePriority = $this->containsResource($sIdentifier)) !== false) {
			if($iPrevResoucePriority === $iPriority) {
				return;
			}
			unset($this->aIncludedResources[$iPrevResoucePriority][$sIdentifier]);
		}
		if($bEndsDependencyList) {
			$this->endDependencyList($sIdentifier);
		}
		$this->aIncludedResources[$iPriority][$sIdentifier] = $aResourceInfo;
	}
	
	public function addCustomJs($mCustomJs, $iPriority = self::PRIORITY_NORMAL, $bEndsDependencyList = false) {
		$this->addCustomResource(array('template' => 'inline_js', 'content' => $mCustomJs), $iPriority, $bEndsDependencyList);
	}
	
	public function addCustomCss($mCustomCss, $iPriority = self::PRIORITY_NORMAL, $bEndsDependencyList = false) {
		$this->addCustomResource(array('template' => 'inline_css', 'content' => $mCustomCss), $iPriority, $bEndsDependencyList);
	}
	
	public function addReverseDependency($sIdentifier, $bIsBefore = false) {
		$aArgs = func_get_args();
		array_shift($aArgs);array_shift($aArgs);
		if(!isset($this->aReverseDependencies[$sIdentifier])) {
			$this->aReverseDependencies[$sIdentifier] = array('before' => array(), 'after' => array());
		}
		$this->aReverseDependencies[$sIdentifier][$bIsBefore ? 'before' : 'after'][] = $aArgs;
	}

	public function getIncludedResources() {
			return $this->aIncludedResources;
	}

	public function getAllIncludedResources() {
			return array_merge($this->aIncludedResources[self::PRIORITY_LAST], $this->aIncludedResources[self::PRIORITY_NORMAL], $this->aIncludedResources[self::PRIORITY_FIRST]);
	}
	
	public function getResourceInfosForIncludedResourcesOfPriority($iPriority = self::PRIORITY_NORMAL) {
		$aResult = array();
		foreach($this->aIncludedResources[$iPriority] as $aResourceInfo) {
			$aResult[] = $aResourceInfo;
		}
		return $aResult;
	}
	
	public function getLocationsForIncludedResourcesOfPriority($iPriority = self::PRIORITY_NORMAL) {
		$aResult = array();
		foreach($this->aIncludedResources[$iPriority] as $aResourceInfo) {
			$aResult[] = $aResourceInfo['location'];
		}
		return $aResult;
	}
	
	public function getIncludes($bPrintNewlines = true) {
		$this->cleanupReverseDependencies();
		$iTemplateFlags = 0;
		if(!$bPrintNewlines) {
			$iTemplateFlags = Template::NO_NEWLINE;
		}
		$oTemplate = new Template(TemplateIdentifier::constructIdentifier('includes'), null, true, false, null, null, $iTemplateFlags);
		$aTemplateMasters = array();
		foreach($this->aIncludedResources as $iPriority => $aIncludedResourcesOfType) {
			if(count($aIncludedResourcesOfType) === 0) {
				continue;
			}
			foreach($aIncludedResourcesOfType as $aResourceInfo) {
				if(!isset($aTemplateMasters[$aResourceInfo['template']])) {
					$aTemplateMasters[$aResourceInfo['template']] = new Template($aResourceInfo['template'], array(DIRNAME_TEMPLATES, 'resource_includers'));
				}
				$oIncludeTemplate = clone $aTemplateMasters[$aResourceInfo['template']];
				foreach($aResourceInfo as $sResourceInfoKey => $sResourceInfoValue) {
					$oIncludeTemplate->replaceIdentifier($sResourceInfoKey, $sResourceInfoValue);
				}
				if(isset($aResourceInfo['ie_condition'])) {
					$oIeConditionalTemplate = $this->ieConditionalTemplate();
					$oIeConditionalTemplate->replaceIdentifier('condition', $aResourceInfo['ie_condition']);
					$oIeConditionalTemplate->replaceIdentifier('content', $oIncludeTemplate);
					$oIncludeTemplate = $oIeConditionalTemplate;
				}
				$oTemplate->replaceIdentifierMultiple('includes', $oIncludeTemplate);
			}
		}
		return $oTemplate;
	}
	
	public function addResourceFromTemplateIdentifier($oIdentifier) {
		$mLocation = $oIdentifier->getValue();
		$iPriority = $oIdentifier->hasParameter('priority') ? constant("ResourceIncluder::PRIORITY_".strtoupper($oIdentifier->getParameter('priority'))) : ResourceIncluder::PRIORITY_NORMAL;
		if($oIdentifier->hasParameter('library')) {
			$this->addJavaScriptLibrary($mLocation, $oIdentifier->getParameter('library'), !$oIdentifier->hasParameter('uncompressed'), !$oIdentifier->hasParameter('nodeps'), $oIdentifier->hasParameter('use_ssl'), $iPriority);
			return null;
		}
		if($oIdentifier->hasParameter('fromBase')) { //Is named the same in include so we leave it in camel case
			$mLocation = explode('/', $mLocation);
		}
		$aParams = $oIdentifier->getParameters();
		$aParams['from_template'] = true;
		
		$sResourceType = $oIdentifier->hasParameter('resource_type') ? $oIdentifier->getParameter('resource_type') : null;
		$sIeCondition = $oIdentifier->hasParameter('ie_condition') ? $oIdentifier->getParameter('ie_condition') : null;
		$bIncludeAll = $oIdentifier->hasParameter('include_all');
		
		$this->addResource($mLocation, $sResourceType, null, $aParams, $iPriority, $sIeCondition, $bIncludeAll);
	}
	
	public function clearIncludedResources() {
		$this->aIncludedResources = array(self::PRIORITY_FIRST => array(), self::PRIORITY_NORMAL => array(), self::PRIORITY_LAST => array());
	}
	
	private function findTemplateNameForLocation($sLocation) {
		if(strrpos($sLocation, '#') !== false) {
			$sLocation = substr($sLocation, 0, strrpos($sLocation, '#'));
		}
		if(strrpos($sLocation, '?') !== false) {
			$sLocation = substr($sLocation, 0, strrpos($sLocation, '?'));
		}
		if(strrpos($sLocation, '.') === false) {
			throw new Exception("Error in ResourceIncluder->findTemplateNameForLocation(): no resource type given for indecisive $sLocation");
		}
		$sExtension = strtolower(substr($sLocation, strrpos($sLocation, '.')+1));
		if($sExtension === 'png' || $sExtension === 'gif' || $sExtension === 'jpg' || $sExtension === 'jpeg') {
			return self::RESOURCE_TYPE_IMAGE;
		} else if($sExtension === 'ico') {
			return self::RESOURCE_TYPE_ICON;
		} else if ($sExtension === 'css') {
			return self::RESOURCE_TYPE_CSS;
		} else if ($sExtension === 'js') {
			return self::RESOURCE_TYPE_JS;
		} else {
			throw new Exception("Error in ResourceIncluder->findTemplateNameForLocation(): no resource type found for $sLocation");
		}
	}
	
	private function ieConditionalTemplate() {
		if(self::$IE_CONDITIONAL === null) {
			self::$IE_CONDITIONAL = new Template(self::IE_CONDITIONAL, null, true);
		}
		return clone self::$IE_CONDITIONAL;
	}
	
	private function containsResource($sIdentifier) {
		foreach($this->aIncludedResources as $iPriority => $aResources) {
			if(isset($aResources[$sIdentifier])) {
				return $iPriority;
			}
		}
		return false;
	}
	
	private function endDependencyList($sIdentifier) {
		$aDependencyList = array_shift($this->aCurrentDependencyStack);
		if($aDependencyList === null) {
			throw new Exception("Error in ResourceIncluder->endDependency(): Incorrect nesting of dependencies. No dependencies left to end");
		}
		foreach($aDependencyList as $sDependencyIdentifier => $bTrue) {
			if(($iDependencyPriority = $this->containsResource($sDependencyIdentifier)) !== false) {
				$this->aIncludedResources[$iDependencyPriority][$sDependencyIdentifier]['dependees'][$sIdentifier] = true;
			}
		}
	}
	
	private function cleanupReverseDependencies() {
		foreach($this->aReverseDependencies as $sDependee => $aDependencies) {
			$iPriority = $this->containsResource($sDependee);
			if($iPriority === false) {
				continue;
			}
			foreach($aDependencies['before'] as $aDependency) {
				for($i=0;$i<4;$i++) {
					if(!isset($aDependency[$i])) {
						$aDependency[$i] = null;
					}
				}
				$aDependency[4] = $iPriority-1; // 4th Parameter to addResource: Priority
				call_user_func_array(array($this, 'addResource'), $aDependency);
			}
			foreach($aDependencies['after'] as $aDependency) {
				for($i=0;$i<4;$i++) {
					if(!isset($aDependency[$i])) {
						$aDependency[$i] = null;
					}
				}
				$aDependency[4] = $iPriority+1; // 4th Parameter to addResource: Priority
				call_user_func_array(array($this, 'addResource'), $aDependency);
			}
		}
	}
}