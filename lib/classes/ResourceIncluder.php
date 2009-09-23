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
  
  private static $LIBRARY_URLS = array('jquery' => 'http://ajax.googleapis.com/ajax/libs/jquery/${version}/jquery.min.js', 
                                       'jquery-uncomp' => 'http://ajax.googleapis.com/ajax/libs/jquery/${version}/jquery.js',
                                       'jqueryui' => 'http://ajax.googleapis.com/ajax/libs/jqueryui/${version}/jquery-ui.min.js',
                                       'jqueryui-uncomp' => 'http://ajax.googleapis.com/ajax/libs/jqueryui/${version}/jquery-ui.js',
                                       'prototype' => 'http://ajax.googleapis.com/ajax/libs/prototype/${version}/prototype.js',
                                       'scriptaculous' => 'http://ajax.googleapis.com/ajax/libs/scriptaculous/${version}/${library_name}.js',
                                       'mootools' => 'http://ajax.googleapis.com/ajax/libs/mootools/${version}/mootools-yui-compressed.js',
                                       'mootools-uncomp' => 'http://ajax.googleapis.com/ajax/libs/mootools/${version}/mootools.js',
                                       'dojo' => 'http://ajax.googleapis.com/ajax/libs/dojo/${version}/dojo/dojo.xd.js',
                                       'dojo-uncomp' => 'http://ajax.googleapis.com/ajax/libs/dojo/${version}/dojo/dojo.xd.js.uncompressed.js',
                                       'swfobject' => 'http://ajax.googleapis.com/ajax/libs/swfobject/${version}/swfobject.js',
                                       'swfobject-uncomp' => 'http://ajax.googleapis.com/ajax/libs/swfobject/${version}/swfobject_src.js',
                                       'yui' => 'http://ajax.googleapis.com/ajax/libs/yui/${version}/build/yuiloader/yuiloader-min.js',
                                       'yui-uncomp' => 'http://ajax.googleapis.com/ajax/libs/yui/${version}/build/yuiloader/yuiloader.js',
                                       'ext-core' => 'http://ajax.googleapis.com/ajax/libs/ext-core/${version}/ext-core.js',
                                       'ext-core-uncomp' => 'http://ajax.googleapis.com/ajax/libs/ext-core/${version}/ext-core-debug.js');
  
  private static $LIBRARY_DEPENDENCIES = array('scriptaculous' => array('prototype' => 1.6),
                                               'jqueryui' => array('jquery' => 1.3));
  private static $IE_CONDITIONAL = null;
  
  private $aIncludedResources;
  
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
    if(isset($this->aIncludedResources[self::PRIORITY_FIRST][$sIdentifier])) {
      return self::PRIORITY_FIRST;
    }
    if(isset($this->aIncludedResources[self::PRIORITY_NORMAL][$sIdentifier])) {
      return self::PRIORITY_NORMAL;
    }
    if(isset($this->aIncludedResources[self::PRIORITY_LAST][$sIdentifier])) {
      return self::PRIORITY_LAST;
    }
    return false;
  }
  
  public function addResource($mLocation, $sTemplateName = null, $sIdentifier = null, $aExtraInfo = array(), $iPriority = self::PRIORITY_NORMAL, $sIeCondition = null) {
    $sResourcePrefix = self::RESOURCE_PREFIX_EXTERNAL;
    $oFileResource = null;
    $sFinalLocation = null;
    if($mLocation instanceof FileResource) {
      //FileResource given (internal)
      $oFileResource = $mLocation;
    } else if(is_array($mLocation)) {
      //Array given, relative -> convert to FileResource (internal)
      $oFileResource = ResourceFinder::findResourceObject($mLocation);
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
        $oFileResource = new FileResource($mLocation);
      } else {
        //URL given, set Location directly (external)
        $sFinalLocation = $mLocation;
      }
    } else {
      //Relative location can be given with resource type with or without extension, and without resource type with extension
      $aLocation = explode('/', $mLocation);
      if($sTemplateName === null) {
        $sTemplateName = $this->findTemplateNameForLocation($aLocation[count($aLocation)-1]);
      }
      array_unshift($aLocation, DIRNAME_WEB, $sTemplateName);
      $oFileResource = ResourceFinder::findResourceObject($aLocation);
      if($oFileResource === null) {
        //Try with added extension
        $aLocation[count($aLocation)-1] .= ".$sTemplateName";
        $oFileResource = ResourceFinder::findResourceObject($aLocation);
      }
    }
    
    if($sFinalLocation === null) {
      if($oFileResource === null) {
        throw new Exception("Error in ResourceIncluder->addResource(): Specified internal file $mLocation could not be found.");
      }
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
      unset($this->aIncludedResources[$iPrevResoucePriority][$sIdentifier]);
    }
    
    $aExtraInfo['location'] = $sFinalLocation;
    if(!isset($aExtraInfo['template'])) {
      $aExtraInfo['template'] = $sTemplateName;
    }
    if($sIeCondition !== null && !isset($aExtraInfo['ie_condition'])) {
      $aExtraInfo['ie_condition'] = $sIeCondition;
    }
    $this->aIncludedResources[$iPriority][$sIdentifier] = $aExtraInfo;
  }
  
  public function addJavaScriptLibrary($sLibraryName, $sLibraryVersion, $bUseCompression = true, $bInlcudeDependencies = true, $bUseSsl = false, $iPriority = self::PRIORITY_NORMAL) {
    if(!is_string($sLibraryVersion)) {
      $sLibraryVersion = "$sLibraryVersion";
    }
    $aIncludes = array();
    if(strpos($sLibraryName, '?load=') !== false) {
      $aIncludes = explode(',', substr($sLibraryName, strpos($sLibraryName, '?load=')+strlen('?load=')));
      $sLibraryName = substr($sLibraryName, 0, strpos($sLibraryName, '?load='));
    }
    $sResourceIdentifier = self::RESOURCE_PREFIX_LIBRARY.$sLibraryName;
    if(!$bUseCompression && !isset(self::$LIBRARY_URLS["$sLibraryName-uncomp"])) {
      $bUseCompression = true;
    }
    $sLibraryUrlIdentifier = $bUseCompression ? $sLibraryName : "$sLibraryName-uncomp";
    if(!isset(self::$LIBRARY_URLS[$sLibraryUrlIdentifier])) {
      throw new Exception("Error in ResourceIncluder->addJavaScriptLibrary(): Library $sLibraryName not found");
    }
    
    //Handle duplicate includes
    if(($iPrevResoucePriority = $this->containsResource($sResourceIdentifier)) !== false) {
      $aResourceInfo = $this->aIncludedResources[$iPrevResoucePriority][$sResourceIdentifier];
      if(version_compare($aResourceInfo['version'], $sLibraryVersion, '<>')) {
        throw new Exception("Error in ResourceIncluder->addJavaScriptLibrary(): Library $sLibraryName already included with different version");
      }
      if((!$aResourceInfo['use_compression'] && $bUseCompression) || ($aResourceInfo['use_compression'] === $bUseCompression)) {
        return;
      }
    }
    
    //Handle dependencies
    if(isset(self::$LIBRARY_DEPENDENCIES[$sLibraryName]) && $bInlcudeDependencies) {
      foreach(self::$LIBRARY_DEPENDENCIES[$sLibraryName] as $sDependencyName => $sDependencyVersion) {
        $this->addJavaScriptLibrary($sDependencyName, $sDependencyVersion, $bUseCompression, true, $bUseSsl, $iPriority);
      }
    }
    
    //Add resource
    $sLibraryUrl = str_replace('${version}', $sLibraryVersion, self::$LIBRARY_URLS[$sLibraryUrlIdentifier]);
    if($bUseSsl) {
      $sLibraryUrl = str_replace('http://', 'https://', $sLibraryUrl);
    }
    $this->addResource(str_replace('${library_name}', $sLibraryName, $sLibraryUrl), self::RESOURCE_TYPE_JS, $sResourceIdentifier, array('version' => $sLibraryVersion, 'use_compression' => $bUseCompression), $iPriority);
    
    //If includes are used (for scriptaculous only)
    foreach($aIncludes as $sIncludeName) {
      $this->addResource(str_replace('${library_name}', $sIncludeName, $sLibraryUrl), self::RESOURCE_TYPE_JS, "$sResourceIdentifier-include_$sIncludeName", array('version' => $sLibraryVersion, 'use_compression' => $bUseCompression), $iPriority);
    }
  }
  
  public function addCustomResource($aResourceInfo, $iPriority = self::PRIORITY_NORMAL) {
    $sIdentifier = self::RESOURCE_PREFIX_CUSTOM.md5(serialize($aResourceInfo));
    if(($iPrevResoucePriority = $this->containsResource($sIdentifier)) !== false) {
      unset($this->aIncludedResources[$iPrevResoucePriority][$sIdentifier]);
    }
    $this->aIncludedResources[$iPriority][$sIdentifier] = $aResourceInfo;
  }
  
  public function addCustomJs($mCustomJs, $iPriority = self::PRIORITY_NORMAL) {
    $this->addCustomResource(array('template' => 'inline_js', 'content' => $mCustomJs), $iPriority);
  }
  
  public function addCustomCss($mCustomJs, $iPriority = self::PRIORITY_NORMAL) {
    $this->addCustomResource(array('template' => 'inline_css', 'content' => $mCustomJs), $iPriority);
  }

  public function getIncludedResources() {
      return $this->aIncludedResources;
  }
  
  public function getResourceInfosForIncludedResourcesOfPriority($iPriority) {
    $aResult = array();
    foreach($this->aIncludedResources[$iPriority] as $aResourceInfo) {
      $aResult[] = $aResourceInfo;
    }
    return $aResult;
  }
  
  public function getLocationsForIncludedResourcesOfPriority($iPriority) {
    $aResult = array();
    foreach($this->aIncludedResources[$iPriority] as $aResourceInfo) {
      $aResult[] = $aResourceInfo['location'];
    }
    return $aResult;
  }
  
  public function getIncludes($bPrintNewlines = true) {
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
}