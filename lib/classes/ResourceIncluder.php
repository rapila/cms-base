<?php
class ResourceIncluder {
	/// The default resource includer. Many plugins and internal modules use this so you should have at least one {{writeResourceIncludes}} without the includer name in your template.
	const DEFAULT_INSTANCE_NAME = 'ResourceIncluder_default';
	/// The Resource includer for meta tags like keywords, description and link tags (excluding stylesheet links). This ({{writeResourceIncludes=meta}}) is not required to have in your template but highly recommended.
	const META_INSTANCE_NAME = 'meta';

	const RESOURCE_TYPE_CSS = 'css';
	const RESOURCE_TYPE_JS = 'js';
	const RESOURCE_TYPE_IMAGE = 'images';
	const RESOURCE_TYPE_ICON = 'icons';
	const RESOURCE_TYPE_LINK = 'link';
	const RESOURCE_TYPE_INTERNAL_LINK = 'internal_link';

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

	/**
	 * @static
	 * @param $sName name of the static includer
	 * @return ResourceIncluder the named static includer or a new instance if name did not yet reference an includer.
	 */
	public static function namedIncluder($sName) {
		if(!isset(self::$INSTANCES[$sName])) {
			self::$INSTANCES[$sName] = new ResourceIncluder();
		}
		return self::$INSTANCES[$sName];
	}

	/**
	 * @static Get the default includer. Same as calling ResourceIncluder::namedIncluder(ResourceIncluder::DEFAULT_INSTANCE_NAME).
	 * @return ResourceIncluder the default includer
	 */
	public static function defaultIncluder() {
		return self::namedIncluder(self::DEFAULT_INSTANCE_NAME);
	}

	/**
	 * @static Get the includer used for meta tags. Same as calling ResourceIncluder::namedIncluder(ResourceIncluder::META_INSTANCE_NAME).
	 * @return ResourceIncluder the meta includer
	 */
	public static function metaIncluder() {
		return self::namedIncluder(self::META_INSTANCE_NAME);
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
		return $this;
	}

	public function addResourceEndingDependency($mLocation, $sResourceType = null, $sIdentifier = null, $aExtraInfo = array(), $iPriority = self::PRIORITY_NORMAL, $sIeCondition = null, $bIncludeAll = false) {
		$this->addResource($mLocation, $sResourceType, $sIdentifier, $aExtraInfo, $iPriority, $sIeCondition, $bIncludeAll, true);
	}

	public function addResource($mLocation, $sResourceType = null, $sIdentifier = null, $aExtraInfo = null, $iPriority = self::PRIORITY_NORMAL, $sIeCondition = null, $bIncludeAll = false, $bEndsDependencyList = false) {
		//Not allowed
		if($bIncludeAll && $sIdentifier !== null) {
			$sIdentifier = null;
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
		} else if($mLocation instanceof NavigationItem) {
			$sFinalLocation = LinkUtil::link($mLocation->getLink(), 'FrontendManager');
			$sResourcePrefix = self::RESOURCE_PREFIX_INTERNAL;
			if($sResourceType === null) {
				$sResourceType = self::RESOURCE_TYPE_LINK;
			}
		} else if(!is_string($mLocation)) {
			//Unknown input type given -> throw Exception
			throw new Exception("Eror in ResourceIncluder->addResource(): given location $mLocation is in unknown format");
		} else if(preg_match('/\w+\:/', $mLocation) !== 0 || StringUtil::startsWith($mLocation, '//')) {
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
			if($sResourceType === null) {
				$sResourceType = $this->findResourceTypeForLocation($aLocation[count($aLocation)-1]);
			}
			array_unshift($aLocation, DIRNAME_WEB, $sResourceType);
			if($bIncludeAll) {
				$mFileResource = ResourceFinder::findAllResourceObjects($aLocation);
			} else {
				$mFileResource = ResourceFinder::findResourceObject($aLocation);
			}
		}

		if($sFinalLocation === null && $mFileResource === null && !$bIncludeAll) {
			if(is_array($mLocation)) {
				$mLocation = implode('/', $mLocation);
			}
			throw new Exception("Error in ResourceIncluder->addResource(): Specified internal file $mLocation could not be found.");
		}

		if(!is_array($mFileResource)) {
			$mFileResource = array($mFileResource);
		}

		if($aExtraInfo === null) {
			$aExtraInfo = array();
		}
		foreach($mFileResource as $oFileResource) {
			$aExtraInfoForResource = $aExtraInfo;
			if($sFinalLocation === null) {
				$sFinalLocation = $oFileResource->getFrontendPath();
				$sResourcePrefix = self::RESOURCE_PREFIX_INTERNAL;
			}

			if($sResourceType === null) {
				$sResourceType = $this->findResourceTypeForLocation($sFinalLocation);
			}

			if($sIdentifier === null) {
				$sIdentifier = $sResourcePrefix.$sFinalLocation;
			}

			if(StringUtil::startsWith($sFinalLocation, '/') && !StringUtil::startsWith($sFinalLocation, '//')) {
				// This will actually only convert to an absolute URL if linking/always_link_absolutely is true
				// or linking/ssl_in_absolute_links requests a different protocol than currently employed
				$sFinalLocation = LinkUtil::absoluteLink($sFinalLocation, null, 'default', true);
			}

			$aExtraInfoForResource['location'] = $sFinalLocation;
			if(!isset($aExtraInfoForResource['resource_type'])) {
				$aExtraInfoForResource['resource_type'] = $sResourceType;
			}
			if(!isset($aExtraInfoForResource['template'])) {
				$aExtraInfoForResource['template'] = $sResourceType;
			}
			if($sIeCondition !== null && !isset($aExtraInfoForResource['ie_condition'])) {
				$aExtraInfoForResource['ie_condition'] = $sIeCondition;
			}
			if(!isset($aExtraInfoForResource['dependees'])) {
				$aExtraInfoForResource['dependees'] = array();
			}
			if($oFileResource instanceof FileResource && !isset($aExtraInfoForResource['file_resource'])) {
				$aExtraInfoForResource['file_resource'] = $oFileResource;
			}
			if($bEndsDependencyList) {
				$this->endDependencyList($sIdentifier);
			}

			if(($iPrevResoucePriority = $this->containsResource($sIdentifier)) !== false) {
				$aExtraInfoForResource = array_merge($this->aIncludedResources[$iPrevResoucePriority][$sIdentifier], $aExtraInfoForResource);
				$aExtraInfoForResource['dependees'] = array_merge($this->aIncludedResources[$iPrevResoucePriority][$sIdentifier]['dependees'], $aExtraInfoForResource['dependees']);
				unset($this->aIncludedResources[$iPrevResoucePriority][$sIdentifier]);
			}

			//Include resource
			$this->aIncludedResources[$iPriority][$sIdentifier] = $aExtraInfoForResource;

			//move down all dependent resources that already exist
			if(isset($aExtraInfoForResource['dependees'])) {
				$this->moveDependees($aExtraInfoForResource['dependees'], $sIdentifier);
			}

			//Add dependency
			$this->registerAsDependency($sIdentifier);

			$sFinalLocation = null;
			$sIdentifier = null;
		}
	}

	private function moveDependees($aDependees, $sDependeeIdentifier) {
		foreach($aDependees as $sDependeeIdentifier => $bTrue) {
			if(($iDependeePriority = $this->containsResource($sDependeeIdentifier)) !== false) {
				$aDependee = $this->aIncludedResources[$iDependeePriority][$sDependeeIdentifier];
				unset($this->aIncludedResources[$iDependeePriority][$sDependeeIdentifier]);
				$this->aIncludedResources[$iDependeePriority][$sDependeeIdentifier] = $aDependee;
				if(isset($aDependee['dependees'])) {
					$this->moveDependees($aDependee['dependees'], $sDependeeIdentifier);
				}
			}
		}
	}

	/**
	* Add a JavaScript Library to this ResourceIncluder instance.
	* @param string $sLibraryName The library’s name as configured in the config files
	* @param string $sLibraryVersion The library’s version number, should be as specific as possible. If multiple libraries are included at different versions, only the higher versioned instances are included.
	* @param boolean|null $bUseCompression Whether we should include a GZIPped-Minified version of the said Library. If set to null, the default will be used (as configured in the “use_compressed_libraries” setting of the “general” section of the resource_includer.yml config file).
	* @param boolean $bInlcudeDependencies Whether to include all the necessary dependencies (as configured in the “library_dependencies” section of the resource_includer.yml config file) of this library.
	* @param boolean|null $bUseSsl Whether to force the usage or non-usage of SSL. If null, this will use the library’s configured location (which should start with a protocol-agnostic “//”). To force either HTTP or HTTPS, use false or true, respectively. This will also determine how the library will be included when proxied (not, however, how it will be fetched, which is always unencrypted HTTP).
	* @param int $iPriority Which priority level to use when addin this library’s reference. One of the defined priority constants (ResourceIncluder::PRIORITY_FIRST, ResourceIncluder::PRIORITY_NORMAL, ResourceIncluder::PRIORITY_LAST).
	* @param boolean|null $bUseLocalProxy Whether we should proxy the included library through our own server. If set to null, the default will be used (as configured in the “use_local_library_cache” setting of the “general” section of the resource_includer.yml config file, which is off by default for production environments). This is useful for environments that need to be testable without an active internet connection or for production environments where libraries should not be loaded from external sources due to privacy concerns.
	* @param string $sIeCondition An IE conditional-comment condition to put around the include. Will only print conditional comments when not null. Example: “lt IE 9”.
	*/
	public function addJavaScriptLibrary($sLibraryName, $sLibraryVersion, $bUseCompression = null, $bInlcudeDependencies = true, $bUseSsl = 'default', $iPriority = self::PRIORITY_NORMAL, $bUseLocalProxy = null, $sIeCondition = null) {
		if($bUseLocalProxy === null) {
			$bUseLocalProxy = Settings::getSetting('general', 'use_local_library_cache', false, 'resource_includer');
		}
		if(!ini_get('allow_url_fopen')) {
			// Never use proxy if fopen_wrappers are disabled
			$bUseLocalProxy = false;
		}
		if($bUseCompression === null) {
			$bUseCompression = Settings::getSetting('general', 'use_compressed_libraries', false, 'resource_includer');
		}
		if(!is_string($sLibraryVersion)) {
			$sLibraryVersion = "$sLibraryVersion";
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
			// Priority is higher as the “priority” value is lower.
			if($iPrevResoucePriority < $iPriority
			   || version_compare($aResourceInfo['version'], $sLibraryVersion, '>')
			   || (version_compare($aResourceInfo['version'], $sLibraryVersion, '==')
			       && ((!$aResourceInfo['use_compression'] && $bUseCompression) || ($aResourceInfo['use_compression'] === $bUseCompression)))) {
				$this->registerAsDependency($sResourceIdentifier);
				return;
			}
		}

		//Handle dependencies
		$aLibraryDependencies = null;
		if($bInlcudeDependencies) {
			$aLibraryDependencies = Settings::getSetting('library_dependencies', $sLibraryName, null, 'resource_includer');
		}
		if(is_array($aLibraryDependencies)) {
			$this->startDependencies();
			foreach($aLibraryDependencies as $sDependencyName => $sDependencyVersion) {
				$this->addJavaScriptLibrary($sDependencyName, $sDependencyVersion, $bUseCompression, true, $bUseSsl, $iPriority);
			}
		}

		// Handle crossorigin and SRI attributes
		$aSri = array();
		$sSriDigest = null;
		$sSriKey = $bUseCompression ? 'sri' : 'sri_uncompressed';
		if(isset($aLibraryOptions[$sSriKey])) {
			$aSri = $aLibraryOptions[$sSriKey];
			if(!is_array($aSri)) {
				$aSri = array($sLibraryVersion => $aSri);
			}
		}
		if(isset($aSri[$sLibraryVersion])) {
			$sSriDigest = $aSri[$sLibraryVersion];
		}
		if(is_array($sSriDigest)) {
			$sSriDigest = implode(' ', $sSriDigest);
		}

		// Don’t send cookies for libraries if a SRI digest is used
		$sCrossOrigin = $sSriDigest ? 'anonymous' : null;
		if(isset($aLibraryOptions['crossorigin'])) {
			$sCrossOrigin = $aLibraryOptions['crossorigin'];
		}

		if($bUseLocalProxy) {
			$sLink = LinkUtil::link(array('local_js_library', $sLibraryName, $sLibraryVersion, ($bUseCompression ? 'min.js' : 'js')), 'FileManager');
			$sLink = LinkUtil::absoluteLink($sLink, null, $bUseSsl, true);
			$this->addResource($sLink, self::RESOURCE_TYPE_JS, $sResourceIdentifier, array(
				'version' => $sLibraryVersion,
				'use_compression' => $bUseCompression,
				'crossorigin' => $sCrossOrigin,
				'sri' => $sSriDigest
			), $iPriority, $sIeCondition, false, is_array($aLibraryDependencies));
			return;
		}

		//Add resource
		$sLibraryUrl = str_replace('${version}', $sLibraryVersion, $sLibraryUrl);
		// Normalize $bUseSsl from 'default', 'auto' to null, true, false
		if($bUseSsl === 'default') {
			$bUseSsl = Settings::getSetting('linking', 'ssl_in_absolute_links', null);
		}
		if($bUseSsl === 'auto') {
			$bUseSsl = LinkUtil::isSSL();
		}
		if($bUseSsl !== null) {
			if(StringUtil::startsWith($sLibraryUrl, '//')) {
				$sLibraryUrl = ($bUseSsl ? 'https://' : 'http://').substr($sLibraryUrl, 2);
			} else if($bUseSsl) {
				$sLibraryUrl = str_replace('http://', 'https://', $sLibraryUrl);
			} else {
				$sLibraryUrl = str_replace('https://', 'http://', $sLibraryUrl);
			}
		}

		$this->addResource(str_replace('${library_name}', $sLibraryName, $sLibraryUrl), self::RESOURCE_TYPE_JS, $sResourceIdentifier, array(
			'version' => $sLibraryVersion,
			'use_compression' => $bUseCompression,
			'crossorigin' => $sCrossOrigin,
			'sri' => $sSriDigest
		), $iPriority, $sIeCondition, false, is_array($aLibraryDependencies));
	}

	public function addCustomResource($aResourceInfo, $iPriority = self::PRIORITY_NORMAL, $bEndsDependencyList = false) {
		if(!isset($aResourceInfo['resource_type'])) {
			$aResourceInfo['resource_type'] = $aResourceInfo['template'];
		}
		ksort($aResourceInfo);
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

	/**
	* Add a meta tag. This adds a custom resource with the “meta” template.
	* Note: This will not add anything if the content is empty.
	* @param $sName The name (or http-equiv) attribute of the resulting tag.
	* @param $sContent The resulting tag’s content.
	* @param $bIsHttpEquiv Whether this is a meta tag used with the name or the http-equiv attribute.
	*/
	public function addMeta($sName, $sContent, $bIsHttpEquiv = false) {
		if(!$sContent) {
			return;
		}
		$aResourceInfo = array('template' => 'meta', 'content' => $sContent);
		$aResourceInfo[$bIsHttpEquiv ? 'http-equiv' : 'name'] = $sName;
		$this->addCustomResource($aResourceInfo);
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

	/**
	* Returns a Template containing all of the necessary HTML code for the browser to load the included resources.
	* @param $bPrintNewlines Whether to put each include on a new line. Turn this off for “location_only”-type includes.
	* @param $bConsolidate Whether to consolidate CSS and JS includes into a single tag which will point to a new location which will serve all the scripts of one type concatenated.
	* Valid values — true: Consolidate all css/js resources, false: Don’t consolidate, 'internal': Only consolidate internal scripts, but not the ones loaded from external servers, null: Use the default value from the general/consolidate_resources configuration seting from resource_includer.yml.
	* Note that all concatenated scripts will have to be in the same charset, namely the one defined in the encoding/browser configuration setting.
	* Also note that a value of "internal" for $bConsolidate will only have an effect on js libraries if they’re not being locally cached (use_local_library_cache is false)
	*/
	public function getIncludes($bPrintNewlines = true, $bConsolidate = null) {
		$bConsolidateSetting = Settings::getSetting('general', 'consolidate_resources', false, 'resource_includer');
		if($bConsolidate === null) {
			$bConsolidate = $bConsolidateSetting;
		}
		if($bConsolidate === 'never' || $bConsolidateSetting === 'never') { //In the “never” case, $bConsolidateSetting overrides a local $bConsolidate
			$bConsolidate = false;
		}
		if($bConsolidate && !ini_get('allow_url_fopen')) {
			// Never consolidate external files if fopen_wrappers are disabled
			$bConsolidate = 'internal';
		}
		if($bConsolidate) {
			$this->replaceContentsWithConsolidated($bConsolidate === 'internal');
		}
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

	private function replaceContentsWithConsolidated($bExcludeExternal = false) {
		$aCssConsolidator = null;
		$aJsConsolidator = null;

		foreach($this->aIncludedResources as $iPriority => &$aIncludedResourcesOfType) {
			foreach($aIncludedResourcesOfType as $sKey => &$aResourceInfo) {
				list($resource_type, $file_resource, $location, $content, $template, $media) = null;
				extract($aResourceInfo, EXTR_IF_EXISTS);
				$this->consolidationStepForResourceType('css', $bExcludeExternal, $iPriority, $sKey, $aCssConsolidator, $resource_type, $file_resource, $location, $content, $template, $media, $aResourceInfo);
				$this->consolidationStepForResourceType('js', $bExcludeExternal, $iPriority, $sKey, $aJsConsolidator, $resource_type, $file_resource, $location, $content, $template, $media, $aResourceInfo);
			}
		}
		$this->cleanupConsolidator($aCssConsolidator);
		$this->cleanupConsolidator($aJsConsolidator);
	}

	private function consolidationStepForResourceType($sType, $bExcludeExternal, $iPriority, $sKey, &$aConsolidatorInfo, &$resource_type, &$file_resource, &$location, &$content, &$template, &$media, $aResourceInfo) {
		$sSSLMode = 'default';
		if($resource_type !== $sType && $resource_type !== "inline_$sType") {
			return;
		}
		//External location (no file_resource given) or location not determinable
		$bIsExternal = $file_resource === null && $content === null;

		// Files with external references should only be consolidated if explicitly requested (resource_includer.yml/general/consolidate_resources == 'internal' disables this)
		$bShouldNotBeConsolidated = $bIsExternal && ($bExcludeExternal || $location === null);
		// Files with an IE condition can’t be consolidated because the condition (unlike CSS media queries) can only be set in HTML
		$bShouldNotBeConsolidated = $bShouldNotBeConsolidated || isset($aResourceInfo['ie_condition']);
		if($bShouldNotBeConsolidated) {
			$this->cleanupConsolidator($aConsolidatorInfo);
		} else {
			$this->initConsolidator($sType, $iPriority, $sKey, $aConsolidatorInfo);
			$oCache = new Cache('consolidated-'.$sKey, DIRNAME_PRELOAD, CachingStrategy::fromConfig('file'));
			if(!$oCache->entryExists()) {
				$sRelativeLocationRoot = null;
				$sContents = '';
				if($file_resource !== null) {
					// We have a file resource
					$sContents = file_get_contents($file_resource->getFullPath());
					$sRelativeLocationRoot = LinkUtil::absoluteLink($file_resource->getFrontendPath(), null, $sSSLMode, true);
				} else if($location !== null) {
					// No file resource given, we only have a URL to go on
					if(StringUtil::startsWith($location, '//')) {
						$location = substr($location, strlen('//'));
						// The path is a protocol-relative URL. Absolutize for file_get_contents and relativize for linking (according to linking/always_link_absolutely)
						$sRelativeLocationRoot = LinkUtil::getProtocol().$location;
						$mProtocolSetting = 'auto';
						$location = LinkUtil::getProtocol($mProtocolSetting).$location;
					} else if(StringUtil::startsWith($location, '/')) {
						// The path is a domain-relative-URL. Absolutize for file_get_contents and relativize for linking (according to linking/always_link_absolutely)
						$sRelativeLocationRoot = LinkUtil::absoluteLink($location, null, $sSSLMode, true);
						$location = LinkUtil::absoluteLink($location, null, LinkUtil::isSSL());
					} else {
						$sRelativeLocationRoot = $location;
					}
					$sContents = file_get_contents($location);
				} else if($content !== null) {
					if($content instanceof Template) {
						$content = $content->render();
					}
					$sContents = $content;
				}

				if($sType === self::RESOURCE_TYPE_CSS && $media) {
					$sContents = "@media $media { $sContents }";
				}

				// Fix relative locations in CSS
				if($sType === self::RESOURCE_TYPE_CSS && $sRelativeLocationRoot !== null) {
					//Remove the protocol so our slash-detection logic works correctly (because the protocol may also contain slashes)
					if(preg_match(',^([a-z][a-z.\\-+]*:)?//,', $sRelativeLocationRoot, $sProtocol) === 1) {
						$sProtocol = $sProtocol[0];
					} else {
						$sProtocol = '';
					}
					$sRelativeLocationRoot = substr($sRelativeLocationRoot, strlen($sProtocol));

					$sAbsoluteLocationRoot = $sRelativeLocationRoot;

					$bHasTruncatedTail = false;
					$iSlashPosition = null;
					// Calculate the absolute location root (will be "" most of the time unless the CSS was loaded from an external domain or linking/always_link_absolutely is true)
					while(($iSlashPosition = strrpos($sAbsoluteLocationRoot, '/')) !== false) {
						$sAbsoluteLocationRoot = substr($sAbsoluteLocationRoot, 0, $iSlashPosition);
						if(!$bHasTruncatedTail) {
							// Remove the last part from the relative location as it’s the resource itself
							$sRelativeLocationRoot = "$sAbsoluteLocationRoot/";
							$bHasTruncatedTail = true;
						}
					}

					// Re-add the protocol part
					$sRelativeLocationRoot = $sProtocol.$sRelativeLocationRoot;
					$sAbsoluteLocationRoot = $sProtocol.$sAbsoluteLocationRoot;

					// Find url() tokens
					$sContents = preg_replace_callback(',url\\s*\\(\\s*(\'[^\']+\'|\"[^\"]+\"|[^(\'\"]+?)\\s*\\),', function($aMatches) use($sRelativeLocationRoot, $sAbsoluteLocationRoot) {
						// Convert /something/../ to /
						$sQuote = '';
						$sUrl = $aMatches[1];
						$sFirst = substr($sUrl, 0, 1);
						if($sFirst === '"' || $sFirst === "'") {
							$sQuote = $sFirst;
							$sUrl = substr($sUrl, 1, -1);
						}
						if(StringUtil::startsWith($sUrl, '//')) {
							// URL is protocol-relative. Do nothing.
							// If this were pointing to the local host, we’d need to respect linking/ssl_in_absolute_links
							// but if it did come from a file resource, we’d already have that
						} else if(StringUtil::startsWith($sUrl, '/')) {
							// URL absolute. That means relative to $sAbsoluteLocationRoot
							$sUrl = $sAbsoluteLocationRoot.$sUrl;
						} else if(!preg_match(',^[a-z][a-z.\\-+]*:,', $sUrl)) {
							// URL is relative to the resource being changed. That means relative to $sRelativeLocationRoot
							// Absolutize only relative URLs (the ones not starting with a protocol)
							// Prepend the coomon root for the relative location
							$sUrl = $sRelativeLocationRoot.$sUrl;
	 						// Fix explicit relative URLs (./)
							$sUrl = preg_replace(',/\\./,', '/', $sUrl);
							// Resolve Uplinks (/some-place/../)
							$sParentPattern = ',/[^/]+/\\.\\./,';
							while(preg_match($sParentPattern, $sUrl) === 1) {
								$sUrl = preg_replace($sParentPattern, '/', $sUrl, 1);
							}
						}
						return "url($sQuote$sUrl$sQuote)";
					}, $sContents);
				}
				$oCache->setContents($sContents);
			}
			$aConsolidatorInfo['contents'][$sKey] = $oCache;
		}
	}

	private function initConsolidator($sType, $iPriority, $sKey, &$aConsolidatorInfo) {
		if($aConsolidatorInfo === null) {
			$aConsolidatorInfo = array('type' => $sType, 'contents' => array());
		} else {
			//Delete the previous consolidated resource. The very last consolidated resource include will be overwritten by the consolidator itself.
			unset($this->aIncludedResources[$aConsolidatorInfo['priority']][$aConsolidatorInfo['key']]);
		}
		$aConsolidatorInfo['priority'] = $iPriority;
		$aConsolidatorInfo['key'] = $sKey;
	}

	/**
	* Closes the consolidator and adds the consolidation link.
	* Sometimes consolidatable resources are interrupted by ones that can’t be consolidated (if they were added with a flag prohibiting consolidation or if they have an IE condition or if they are from an external source)
	*/
	private function cleanupConsolidator(&$aConsolidatorInfo) {
		if($aConsolidatorInfo === null) {
			return;
		}
		$aLocation = array('consolidated_resource', $aConsolidatorInfo['type']);
		foreach($aConsolidatorInfo['contents'] as $oCache) {
			$aLocation[] = $oCache->getStrategy()->encodedKey($oCache);
		}
		$sLink = LinkUtil::absoluteLink(LinkUtil::link($aLocation, 'FileManager'), null, 'default', true);
		$aConsolidatorLink = array('location' => $sLink, 'template' => $aConsolidatorInfo['type']);
		$this->aIncludedResources[$aConsolidatorInfo['priority']][$aConsolidatorInfo['key']] = $aConsolidatorLink;
		$aConsolidatorInfo = null;
	}

	public function addResourceFromTemplateIdentifier($oIdentifier) {
		$mLocation = $oIdentifier->getValue();
		$iPriority = $oIdentifier->hasParameter('priority') ? constant("ResourceIncluder::PRIORITY_".strtoupper($oIdentifier->getParameter('priority'))) : ResourceIncluder::PRIORITY_NORMAL;
		$sIeCondition = $oIdentifier->hasParameter('ie_condition') ? $oIdentifier->getParameter('ie_condition') : null;
		if($oIdentifier->hasParameter('library')) {
			$bUseSsl = $oIdentifier->hasParameter('use_ssl') ? null : 'default';

			if($oIdentifier->getParameter('use_ssl')) {
				$bUseSsl = $oIdentifier->getParameter('use_ssl');
				if($bUseSsl !== 'auto' && $bUseSsl !== 'default') {
					$bUseSsl = BooleanParser::booleanForString($bUseSsl);
				}
			}
			$this->addJavaScriptLibrary($mLocation, $oIdentifier->getParameter('library'), $oIdentifier->hasParameter('uncompressed') ? false : null, !$oIdentifier->hasParameter('nodeps'), $bUseSsl, $iPriority, null, $sIeCondition);
			return null;
		}
		if($oIdentifier->hasParameter('inline')) {
			if($oIdentifier->getParameter('inline') === 'css') {
				$this->addCustomCss($mLocation);
			} else if($oIdentifier->getParameter('inline') === 'js') {
				$this->addCustomJs($mLocation);
			}
			return null;
		}
		if($oIdentifier->hasParameter('fromBase')) { //Is named the same in include so we leave it in camel case
			$mLocation = explode('/', $mLocation);
		}
		$aParams = $oIdentifier->getParameters();
		$aParams['from_template'] = true;

		$sResourceType = $oIdentifier->hasParameter('type') ? $oIdentifier->getParameter('type') : null;
		// Fall back to 'resource_type' param for backwards compatiblity
		if($sResourceType === null && $oIdentifier->hasParameter('resource_type')) {
			$sResourceType = $oIdentifier->getParameter('resource_type');
		}
		$bIncludeAll = $oIdentifier->hasParameter('include_all');

		$this->addResource($mLocation, $sResourceType, null, $aParams, $iPriority, $sIeCondition, $bIncludeAll);
	}

	public function clearIncludedResources() {
		$this->aIncludedResources = array(self::PRIORITY_FIRST => array(), self::PRIORITY_NORMAL => array(), self::PRIORITY_LAST => array());
	}

	private function findResourceTypeForLocation($sLocation) {
		if(strrpos($sLocation, '#') !== false) {
			$sLocation = substr($sLocation, 0, strrpos($sLocation, '#'));
		}
		if(strrpos($sLocation, '?') !== false) {
			$sLocation = substr($sLocation, 0, strrpos($sLocation, '?'));
		}
		if(strrpos($sLocation, '.') === false) {
			throw new Exception("Error in ResourceIncluder->findResourceTypeForLocation(): no resource type given for indecisive $sLocation");
		}
		$sExtension = strtolower(substr($sLocation, strrpos($sLocation, '.')+1));
		if($sExtension === 'png' || $sExtension === 'gif' || $sExtension === 'jpg' || $sExtension === 'jpeg' || $sExtension === 'svg') {
			return self::RESOURCE_TYPE_IMAGE;
		} else if($sExtension === 'ico') {
			return self::RESOURCE_TYPE_ICON;
		} else if ($sExtension === 'css') {
			return self::RESOURCE_TYPE_CSS;
		} else if ($sExtension === 'js') {
			return self::RESOURCE_TYPE_JS;
		} else {
			throw new Exception("Error in ResourceIncluder->findResourceTypeForLocation(): no resource type found for $sLocation");
		}
	}

	private function registerAsDependency($sResourceIdentifier) {
		if(count($this->aCurrentDependencyStack) > 0) {
			$this->aCurrentDependencyStack[0][$sResourceIdentifier] = true;
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
