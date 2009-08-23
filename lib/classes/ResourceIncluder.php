<?php
class ResourceIncluder {
  const DEFAULT_INSTANCE_NAME = 'ResourceIncluder_default';
  
  const RESOURCE_TYPE_CSS = 'css';
  const RESOURCE_TYPE_JS = 'js';
  const RESOURCE_TYPE_IMAGE = 'images';
  
  const LIBRARY_VERSION_NEWEST = 'newest';
  
  const RESOURCE_PREFIX_LIBRARY = 'lib_';
  const RESOURCE_PREFIX_INTERNAL = 'int_';
  const RESOURCE_PREFIX_EXTERNAL = 'ext_';
  
  private static $INSTANCES = array();
  
  private static $LIBRARY_URLS = array('jquery' => 'http://ajax.googleapis.com/ajax/libs/jquery/${version}/jquery.min.js', 
                                       'jquery-uncomp' => 'http://ajax.googleapis.com/ajax/libs/jquery/${version}/jquery.js',
                                       'jqueryui' => 'http://ajax.googleapis.com/ajax/libs/jqueryui/${version}/jquery-ui.min.js',
                                       'jqueryui-uncomp' => 'http://ajax.googleapis.com/ajax/libs/jqueryui/${version}/jquery-ui.js',
                                       'prototype' => 'http://ajax.googleapis.com/ajax/libs/prototype/${version}/prototype.js',
                                       'scriptaculous' => 'http://ajax.googleapis.com/ajax/libs/scriptaculous/${version}/scriptaculous.js',
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
  
  private function __construct() {
    $this->clearIncludedResources();
  }
  
  public function addResource($mLocation, $sResourceType = null, $sIdentifier = null, $aExtraInfo = array()) {
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
      if($sResourceType === null) {
        $sResourceType = $this->findResourceTypeForLocation($aLocation[count($aLocation)-1]);
      }
      array_unshift($aLocation, DIRNAME_WEB, $sResourceType);
      $oFileResource = ResourceFinder::findResourceObject($aLocation);
      if($oFileResource === null) {
        //Try with added extension
        $aLocation[count($aLocation)-1] .= ".$sResourceType";
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
    
    if($sResourceType === null) {
      $sResourceType = $this->findResourceTypeForLocation($sFinalLocation);
    }

    if($sIdentifier === null) {
      $sIdentifier = $sResourcePrefix.$sFinalLocation;
    }
    
    if(isset($this->aIncludedResources[$sResourceType][$sIdentifier])) {
      unset($this->aIncludedResources[$sResourceType][$sIdentifier]);
    }
    
    $aExtraInfo['location'] = $sFinalLocation;
    $this->aIncludedResources[$sResourceType][$sIdentifier] = $aExtraInfo;
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
    if($sExtension === 'png' || $sExtension === 'gif' || $sExtension === 'jpg' || $sExtension === 'jpeg' || $sExtension === 'ico') {
      return self::RESOURCE_TYPE_IMAGE;
    } else if ($sExtension === 'css') {
      return self::RESOURCE_TYPE_CSS;
    } else if ($sExtension === 'js') {
      return self::RESOURCE_TYPE_JS;
    } else {
      throw new Exception("Error in ResourceIncluder->findResourceTypeForLocation(): no resource type found for $sLocation");
    }
  }
  
  public function addJavaScriptLibrary($sLibraryName, $sLibraryVersion, $bUseCompression = true, $bInlcudeDependencies = true, $bUseSsl = false) {
    if(!is_string($sLibraryVersion)) {
      $sLibraryVersion = "$sLibraryVersion";
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
    if(isset($this->aIncludedResources[self::RESOURCE_TYPE_JS][$sResourceIdentifier])) {
      $aResourceInfo = $this->aIncludedResources[self::RESOURCE_TYPE_JS][$sResourceIdentifier];
      if(version_compare($aResourceInfo['version'], $sLibraryVersion, '<>')) {
        throw new Exception("Error in ResourceIncluder->addJavaScriptLibrary(): Library $sLibraryName already included with different version");
      }
      if(!$aResourceInfo['use_compression'] && $bUseCompression) {
        return;
      }
    }
    
    //Handle dependencies
    if(isset(self::$LIBRARY_DEPENDENCIES[$sLibraryName]) && $bInlcudeDependencies) {
      foreach(self::$LIBRARY_DEPENDENCIES[$sLibraryName] as $sDependencyName => $sDependencyVersion) {
        $this->addJavaScriptLibrary($sDependencyName, $sDependencyVersion, $bUseCompression, true, $bUseSsl);
      }
    }
    
    //Add resource
    $sLibraryUrl = str_replace('${version}', $sLibraryVersion, self::$LIBRARY_URLS[$sLibraryUrlIdentifier]);
    if($bUseSsl) {
      $sLibraryUrl = str_replace('http://', 'https://', $sLibraryUrl);
    }
    $this->addResource($sLibraryUrl, self::RESOURCE_TYPE_JS, $sResourceIdentifier, array('version' => $sLibraryVersion, 'use_compression' => $bUseCompression));
  }

  public function getIncludedResources() {
      return $this->aIncludedResources;
  }
  
  public function retResourceInfosForIncludedResourcesOfType($sResourceType) {
    $aResult = array();
    foreach($this->aIncludedResources[$sResourceType] as $aResourceInfo) {
      $aResult[] = $aResourceInfo;
    }
    return $aResult;
  }
  
  public function getLocationsForIncludedResourcesOfType($sResourceType) {
    $aResult = array();
    foreach($this->aIncludedResources[$sResourceType] as $aResourceInfo) {
      $aResult[] = $aResourceInfo['location'];
    }
    return $aResult;
  }
  
  public function getIncludes() {
    $oTemplate = new Template(TemplateIdentifier::constructIdentifier('includes'), null, true);
    foreach($this->aIncludedResources as $sResourceType => $aIncludedResourcesOfType) {
      if(count($aIncludedResourcesOfType) === 0) {
        continue;
      }
      $oIncludeTemplateMaster = new Template($sResourceType, array(DIRNAME_TEMPLATES, 'resource_includers'));
      foreach($aIncludedResourcesOfType as $aResourceInfo) {
        $oIncludeTemplate = null;
        if(isset($aResourceInfo['template'])) {
          $oIncludeTemplate = new Template($aResourceInfo['template'], array(DIRNAME_TEMPLATES, 'resource_includers'));
          unset($aResourceInfo['template']);
        } else {
          $oIncludeTemplate = clone $oIncludeTemplateMaster;
        }
        foreach($aResourceInfo as $sResourceInfoKey => $sResourceInfoValue) {
          $oIncludeTemplate->replaceIdentifier($sResourceInfoKey, $sResourceInfoValue);
        }
        $oTemplate->replaceIdentifierMultiple('includes', $oIncludeTemplate);
      }
    }
    return $oTemplate;
  }
  
  public function clearIncludedResources() {
    $this->aIncludedResources = array(self::RESOURCE_TYPE_CSS => array(), self::RESOURCE_TYPE_JS => array(), self::RESOURCE_TYPE_IMAGE => array());
  }
}