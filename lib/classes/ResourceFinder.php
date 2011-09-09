<?php

require_once(BASE_DIR."/".DIRNAME_LIB."/".DIRNAME_CLASSES."/StringUtil.php");
require_once(BASE_DIR."/".DIRNAME_LIB."/".DIRNAME_CLASSES."/FileResource.php");
require_once(BASE_DIR."/".DIRNAME_LIB."/".DIRNAME_CLASSES."/ErrorHandler.php");

///Allows to easily find files residing inside rapila’s site structure, following the precedence rules (site > plugins > base).
class ResourceFinder {
	const SEARCH_MAIN_ONLY = 0;
	const SEARCH_BASE_ONLY = 1;
	const SEARCH_SITE_ONLY = 2;
	const SEARCH_PLUGINS_ONLY = 5;
	const SEARCH_BASE_FIRST = 3;
	const SEARCH_SITE_FIRST = 4;
	const SEARCH_PLUGINS_FIRST = 6;
	
	const ANY_NAME_OR_TYPE_PATTERN = '/^[\\w_]+$/';
	
	private static $PLUGINS = null;

	private $aPath;
	private $bByExpressions;
	private $bFindAll;
	private $bReturnObjects;
	private $bNoCache;
	private $iFlag;
	private $mResult;

	public function __construct($aPath = array(), $iFlag = null) {
		if(is_string($aPath)) {
			$aPath = explode('/', $aPath);
		} else if(!is_array($aPath)) {
			throw new Exception("Exception in ResourceFinder: given path is neither array nor string");
		}
		$this->aPath = $aPath;
		$this->bByExpressions = false;
		$this->bFindAll = false;
		$this->bReturnObjects = false;
		$this->bNoCache = false;
		$this->iFlag = $iFlag;
		$this->mResult = false;
	}

	public static function create($aPath = array(), $iFlag = null) {
		return new ResourceFinder($aPath, $iFlag);
	}

	public function byExpressions($bByExpressions = true) {
		$this->bByExpressions = $bByExpressions;
		$this->mResult = false;
		return $this;
	}

	public function all($bFindAll = true) {
		$this->bFindAll = $bFindAll;
		$this->mResult = false;
		return $this;
	}

	public function returnObjects($bReturnObjects = true) {
		$this->bReturnObjects = $bReturnObjects;
		$this->mResult = false;
		return $this;
	}

	public function noCache($bNoCache = true) {
		$this->bNoCache = $bNoCache;
		return $this;
	}

	public function searchMainOnly() {
		$this->iFlag = self::SEARCH_MAIN_ONLY;
		$this->bFindAll = false;
		$this->mResult = false;
		return $this;
	}

	public function searchBaseOnly() {
		$this->iFlag = self::SEARCH_BASE_ONLY;
		$this->bFindAll = false;
		$this->mResult = false;
		return $this;
	}

	public function searchSiteOnly() {
		$this->iFlag = self::SEARCH_SITE_ONLY;
		$this->bFindAll = false;
		$this->mResult = false;
		return $this;
	}

	public function searchPluginsOnly() {
		$this->iFlag = self::SEARCH_PLUGINS_ONLY;
		$this->mResult = false;
		return $this;
	}

	public function searchBaseFirst() {
		$this->iFlag = self::SEARCH_BASE_FIRST;
		$this->mResult = false;
		return $this;
	}

	public function searchSiteFirst() {
		$this->iFlag = self::SEARCH_SITE_FIRST;
		$this->mResult = false;
		return $this;
	}

	public function searchPluginsFirst() {
		$this->iFlag = self::SEARCH_PLUGINS_FIRST;
		$this->mResult = false;
		return $this;
	}

	public function resultIsArray() {
		return $this->bByExpressions || $this->bFindAll;
	}

	public function resultIsAssoc() {
		return $this->bByExpressions && !$this->bFindAll;
	}

	public function returnsObjects() {
		return $this->bReturnObjects;
	}

	public function addPath() {
		$this->aPath = array_merge($this->aPath, func_get_args());
		$this->mResult = false;
		return $this;
	}

	public function addOptionalPath($mPathItem) {
		$this->aPath[] = array($mPathItem);
		$this->bByExpressions = true;
		$this->mResult = false;
		return $this;
	}

	public function addAnyPath($bOptional = false) {
		return $bOptional ? $this->addOptionalPath(null) : $this->addPath(null);
	}

	public function addDirPath($bOptional = false) {
		return $bOptional ? $this->addOptionalPath(false) : $this->addPath(false);
	}

	public function addFilePath($bOptional = false) {
		return $bOptional ? $this->addOptionalPath(true) : $this->addPath(true);
	}

	public function find() {
		if($this->mResult === false) {
			if(!$this->bNoCache && ErrorHandler::getEnvironment() !== 'development') {
				$oCache = new Cache(serialize($this), 'resource_finder');
				if($oCache->cacheFileExists()) {
					$this->mResult = $oCache->getContentsAsVariable();
				} else {
					$this->mResult = $this->doFind();
					$oCache->setContents($this->mResult, true);
				}
			} else {
				$this->mResult = $this->doFind();
			}
		}
		return $this->mResult;
	}

	private function doFind() {
		if($this->iFlag === null) {
			$this->iFlag = $this->bFindAll ? self::SEARCH_BASE_FIRST : self::SEARCH_SITE_FIRST;
		}
		$mResult = array();
		foreach($this->buildSearchPathList() as $sSearchPath) {
			$sInstancePrefix = substr(realpath($sSearchPath), strlen(realpath(MAIN_DIR))+1);
			if($sInstancePrefix === false) {
				$sInstancePrefix = '';
			}
			$mPath = null;
			if($this->bByExpressions) {
				$mPath = array();
				self::findInPathByExpressions($mPath, $this->aPath, $sSearchPath, $sInstancePrefix);
			} else {
				$mPath = self::findInPath($this->aPath, $sSearchPath, $sInstancePrefix);
			}
			if($mPath) {
				if($this->bFindAll || $this->bByExpressions) {
					if(!$this->bByExpressions) {
						$mPath = array($mPath);
					} else if($this->bFindAll) {
						$mPath = array_values($mPath);
					}
					$mResult = array_merge($mResult, $mPath);
				} else {
					return $this->returnFromFindResource($mPath);
				}
			}
		}
		
		if($this->bFindAll || $this->bByExpressions) {
			return $this->returnFromFindResource($mResult);
		}
		
		return null;
	}
	
	/**
	* Finds files which reside inside the CMS’ main direcory. The goal of findResource is to provide a way of accessing all the desired resources from
	* the most specific location. Files in the site folder override files in the plugins folders which, in turn, override files in the base folder.
	* The return type varies depending on the given options ($bByExpressions, $bFindAll, $bReturnObjects).
	* If $bReturnObjects is false, the returned value(s) will be strings containing the files canonical full path on the file system.
	* $bReturnObjects set to true will return FileResource objects which store much more information and can be used to get to things such as the 
	* relative path, the directory the relative path was found in, or the frontend path which is used to directly render a file to the user agent.
	* If $bByExpressions and $bFindAll are set to false, only a single string/object is returned (null if not found). Otherwise, an array is returned.
	* If $bFindAll is set, the returned array is index-based; if only $bByExpressions is set, the returned array’s keys are the relative paths of the respective files.
	* @param array|string $mRelativePath relative path to search for in base, plugins or site folders. This can be an array or a string of /-separated directory/file names (or expressions if $bByExpressions is true).
	* @param int $iFlag can be one of either ResourceFinder::SEARCH_MAIN_ONLY, ResourceFinder::SEARCH_BASE_ONLY, ResourceFinder::SEARCH_SITE_ONLY, ResourceFinder::SEARCH_PLUGINS_ONLY, ResourceFinder::SEARCH_BASE_FIRST, ResourceFinder::SEARCH_SITE_FIRST, ResourceFinder::SEARCH_PLUGINS_FIRST. The *_ONLY constants are – except for SEARCH_PLUGINS_ONLY – just for convenience: since they only find files in specific directories, you might just as well do file_exists(MAIN_DIR.'my/dir').
	* @param boolean $bByExpressions If set, $mRelativePath becomes not a fixed set of names but an array of regular expressions to evaluate against possible matches. This is slow when used on large directories. There are the following values which can be used as part of the expression: ${parent_name} and ${parent_name_camelized} which do exactly what you would expect. For convenience, any array item not starting with a slash is considered to be a regular file name. This means that a slash is the only accepted delimiter. In addition to regular strings and expressions, you can also pass null for a complete wildcard, true to match all files and false for a wildcard matching only directories. Any expression item packed into an array will be optional. An empty array (as an item of $mRelativePath) will match all items recursively (should not be used in frontend-production environments).
	* @param boolean $bFindAll If set, all matching files will be returned even if they have the same relative path inside different instance prefixes. Note: when used in conjunction with $bByExpressions, the return value becomes an index-based array since there could be duplicate relative urls.
	* @param boolean $bReturnObjects If set, all returned paths become FileResource objects. This is much cheaper than calling new FileResource() on the returned value(s) because a) FileResource objects are used internally by findResource and b) the additional information maintained by FileResource was added when it was already known and does not have to be deducted.
	* @return mixed
	*/
	public static function findResource($mRelativePath, $iFlag = null, $bByExpressions = false, $bFindAll = false, $bReturnObjects = false) {
		if($mRelativePath instanceof ResourceFinder) {
			return $mRelativePath->find();
		}
		if(is_array($mRelativePath) && array_key_exists('flag', $mRelativePath)) {
			$iFlag = constant("ResourceFinder::".$mRelativePath['flag']);
			unset($mRelativePath['flag']);
		}
		return ResourceFinder::create($mRelativePath, $iFlag)->byExpressions($bByExpressions)->all($bFindAll)->returnObjects($bReturnObjects)->find();
	}
	
	/**
	* Shorthand for {@link ResourceFinder::findResource()} with $bFindAll set.
	*/
	public static function findAllResources($mRelativePath, $iFlag = null) {
		return self::findResource($mRelativePath, $iFlag, false, true, false);
	}
	
	/**
	* Alias for {@link ResourceFinder::findResourcesByExpressions()}. Exists for historical reasons.
	*/
	public static function findResourceByExpressions($aExpressions, $iFlag = null) {
		return self::findResource($aExpressions, $iFlag, true, false, false);
	}
	
	/**
	* Shorthand for {@link ResourceFinder::findResource()} with $bByExpressions set.
	*/
	public static function findResourcesByExpressions($aExpressions, $iFlag = null) {
		return self::findResource($aExpressions, $iFlag, true, false, false);
	}
	
	/**
	* Shorthand for {@link ResourceFinder::findResource()} with $bFindAll and $bByExpressions set.
	*/
	public static function findAllResourcesByExpressions($aExpressions, $iFlag = null) {
		return self::findResource($aExpressions, $iFlag, true, true, false);
	}
	
	/**
	* Shorthand for {@link ResourceFinder::findResource()} with $bReturnObjects set.
	*/
	public static function findResourceObject($mRelativePath, $iFlag = null) {
		return self::findResource($mRelativePath, $iFlag, false, false, true);
	}
	
	/**
	* Shorthand for {@link ResourceFinder::findResource()} with $bFindAll and $bReturnObjects set.
	*/
	public static function findAllResourceObjects($mRelativePath, $iFlag = null) {
		return self::findResource($mRelativePath, $iFlag, false, true, true);
	}
	
	/**
	* Alias for {@link ResourceFinder::findResourceObjectsByExpressions()}. Exists for historical reasons.
	*/
	public static function findResourceObjectByExpressions($aExpressions, $iFlag = null) {
		return self::findResource($aExpressions, $iFlag, true, false, true);
	}
	
	/**
	* Shorthand for {@link ResourceFinder::findResource()} with $bByExpressions and $bReturnObjects set.
	*/
	public static function findResourceObjectsByExpressions($aExpressions, $iFlag = null) {
		return self::findResource($aExpressions, $iFlag, true, false, true);
	}
	
	/**
	* Shorthand for {@link ResourceFinder::findResource()} with $bFindAll, $bByExpressions and $bReturnObjects set.
	*/
	public static function findAllResourceObjectsByExpressions($aExpressions, $iFlag = null) {
		return self::findResource($aExpressions, $iFlag, true, true, true);
	}
	
	private function buildSearchPathList() {
		switch($this->iFlag) {
			case self::SEARCH_MAIN_ONLY: return array(MAIN_DIR);
			case self::SEARCH_BASE_ONLY: return array(BASE_DIR);
			case self::SEARCH_SITE_ONLY: return array(SITE_DIR);
			case self::SEARCH_PLUGINS_ONLY: return self::getPluginPaths(!$this->bFindAll);
		}
		$aResult = self::getPluginPaths($this->iFlag === self::SEARCH_SITE_FIRST);
		switch($this->iFlag) {
			case self::SEARCH_BASE_FIRST:
				array_unshift($aResult, BASE_DIR);
				array_push($aResult, SITE_DIR);
			break;
			case self::SEARCH_SITE_FIRST:
				array_unshift($aResult, SITE_DIR);
				array_push($aResult, BASE_DIR);
			break;
			case self::SEARCH_PLUGINS_FIRST:
				array_push($aResult, SITE_DIR);
				array_push($aResult, BASE_DIR);
			break;
		}
		
		return $aResult;
	}
	
	private function returnFromFindResource(&$mResult) {
		if($this->bReturnObjects) {
			return $mResult;
		}
		if(is_array($mResult)) {
			foreach($mResult as $mKey => $oValue) {
				$mResult[$mKey] = $oValue->getFullPath();
			}
			return $mResult;
		}
		return $mResult->getFullPath();
	}

	private function __sleep() {
		$aVars = get_object_vars($this);
		unset($aVars['mResult']);
		unset($aVars['bNoCache']);
		return array_keys($aVars);
	}
	
	private static function findInPath($aPath, $sPath, $sInstancePrefix) {
		foreach($aPath as $sPathElement) {
			if(file_exists("$sPath/$sPathElement")) {
				$sPath .= "/$sPathElement";
			} else {
				return null;
			}
		}
		return new FileResource($sPath, $sInstancePrefix, implode('/', $aPath));
	}
	
	private static function findInPathByExpressions(&$aResult, $aExpressions, $sPath, $sInstancePrefix, $sParentName = null, $sRelativePath = null) {
		if(count($aExpressions) === 0) {
			return;
		}
		
		$sPathExpression = array_shift($aExpressions);
		
		$bAllowPathItemToBeSkipped = is_array($sPathExpression);
		if($bAllowPathItemToBeSkipped) {
			if(count($aExpressions) === 0) {
				//Add the current path (parent recursive invocation added nothing because there were still items on the stack, next invocation would return empty since the stack is empty)
				$aResult[$sRelativePath] = new FileResource($sPath, $sInstancePrefix, $sRelativePath);
			} else {
				//call current function without the optional element
				self::findInPathByExpressions($aResult, $aExpressions, $sPath, $sInstancePrefix, $sParentName, $sRelativePath);
			}
			if(count($sPathExpression) === 0) {
				//emtpy array means look recursively in all subdirs => put the any-item-specifier (true) and the empty array on the local stack
				array_unshift($aExpressions, array());
				$sPathExpression = null;
			} else {
				//array has a path element => put the optional argument on the local stack
				$sPathExpression = $sPathExpression[0];
			}
		}

		if($sParentName !== null && is_string($sPathExpression)) {
			$sPathExpression = str_replace('${parent_name}', $sParentName, $sPathExpression);
			$sPathExpression = str_replace('${parent_name_camelized}', StringUtil::camelize($sParentName, true), $sPathExpression);
		}
		
		if(is_string($sPathExpression) && !StringUtil::startsWith($sPathExpression, "/")) {
			//Take the shortcut when only dealing with a static file name
			$sFilePath = "$sPath/$sPathExpression";
			if($sRelativePath === null) {
				$sNextRelativePath = $sPathExpression;
			} else {
				$sNextRelativePath = "$sRelativePath/$sPathExpression";
			}
			if(file_exists($sFilePath)) {
				if(count($aExpressions) > 0) {
					self::findInPathByExpressions($aResult, $aExpressions, $sFilePath, $sInstancePrefix, $sPathExpression, $sNextRelativePath);
				} else {
					$aResult[$sNextRelativePath] = new FileResource($sFilePath, $sInstancePrefix, $sNextRelativePath);
				}
			}
		} else {
			foreach(ResourceFinder::getFolderContents($sPath) as $sFileName => $sFilePath) {
				if($sPathExpression === null || ($sPathExpression === true && is_file($sFilePath)) || ($sPathExpression === false && is_dir($sFilePath)) || (is_string($sPathExpression) && preg_match($sPathExpression, $sFileName) !== 0)) {
					$sNextRelativePath = $sFileName;
					if($sRelativePath !== null) {
						$sNextRelativePath = "$sRelativePath/$sFileName";
					}
					if(count($aExpressions) > 0) {
						self::findInPathByExpressions($aResult, $aExpressions, $sFilePath, $sInstancePrefix, $sFileName, $sNextRelativePath);
					} else {
						$aResult[$sNextRelativePath] = new FileResource($sFilePath, $sInstancePrefix, $sNextRelativePath);
					}
				}
			}
		}
	}
	
	private static function getPluginPaths($bReverseOrder = false) {
		if(self::$PLUGINS === null) {
			self::$PLUGINS = array_values(self::findResourcesByExpressions(array(DIRNAME_PLUGINS, self::ANY_NAME_OR_TYPE_PATTERN), self::SEARCH_MAIN_ONLY));
		}
		if($bReverseOrder === true) {
			return array_reverse(self::$PLUGINS);
		}
		return self::$PLUGINS;
	}
	
	///Helper function for classes that are given a filename, base path and path name
	public static function parsePathArguments($sBaseDirname = null, $mPath = null, $sFileName = null) {
		if($mPath === null) {
			$mPath = array();
		} else if(is_string($mPath)) {
			$mPath = explode("/", $mPath);
		}
		
		if($sBaseDirname !== null) {
			array_unshift($mPath, $sBaseDirname);
		}
		
		if($sFileName !== null) {
			$mPath = array_merge($mPath, explode('/', $sFileName));
		}
		
		return $mPath;
	}
	
	public static function getFolderContents($sPath, $bIncludeInvisibles = false) {
		if(!is_dir($sPath)){
			return array();
		}

		$rFolderHandle = opendir($sPath);
		$sFileName = "";

		$aResult = array();
		while (false !== ($sFileName = readdir($rFolderHandle)))
		{
			if(!StringUtil::startsWith($sFileName, ".") || ($bIncludeInvisibles && $sFileName !== '.' && $sFileName !== '..')) {
				$aResult[$sFileName] = "$sPath/$sFileName";
			}
		}
		natcasesort($aResult);
		return $aResult;
	}
	
	public static function mimeTypeOfFile($sFile) {
		$aMimeTypes = DocumentTypePeer::getMostAgreedMimetypes($sFile);
		return $aMimeTypes[0];
	}
	
	public static function recursiveUnlink($sFileName) {
		if(is_dir($sFileName)) {
			foreach(self::getFolderContents($sFileName, true) as $sSubFilePath) {
				self::recursiveUnlink($sSubFilePath);
			}
			rmdir($sFileName);
		} else {
			unlink($sFileName);
		}
	}
	
}
