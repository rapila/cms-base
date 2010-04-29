<?php

require_once(BASE_DIR."/".DIRNAME_LIB."/".DIRNAME_CLASSES."/StringUtil.php");
require_once(BASE_DIR."/".DIRNAME_LIB."/".DIRNAME_CLASSES."/FileResource.php");

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
	
	private static function getDefaultFlag($bFindAll) {
		return $bFindAll ? self::SEARCH_BASE_FIRST : self::SEARCH_SITE_FIRST;
	}
	
	private static function processArguments(&$mRelativePath, &$iFlag, $bFindAll) {
		if($iFlag === null) {
			$iFlag = self::getDefaultFlag($bFindAll);
		}
		
		if(is_array($mRelativePath) && array_key_exists('flag', $mRelativePath)) {
			$iFlag = constant("ResourceFinder::".$mRelativePath['flag']);
			unset($mRelativePath['flag']);
		}
		
		if(is_string($mRelativePath)) {
			$mRelativePath = explode('/', $mRelativePath);
		} else if(!is_array($mRelativePath)) {
			throw new Exception("Exception in ResourceFinder: given path is neither array nor string");
		}
		
		if($mRelativePath[0] === DIRNAME_CLASSES || $mRelativePath[0] === DIRNAME_VENDOR || $mRelativePath[0] === DIRNAME_MODEL) {
			array_unshift($mRelativePath, DIRNAME_LIB);
		}
	}
	
	/**
	* Finds files which reside inside the CMS’ main direcory. The goal of findResource is to provide a way of accessing all the desired resource from
	* the most specific location. Files in the site folder override files in the plugins folders which, in turn, override files in the base folder.
	* The return type varies depending on the given options ($bByExpressions, $bFindAll, $bReturnObjects).
	* If $bReturnObjects is false, the returned value(s) will be strings containing the files canonical full path on the file system.
	* $bReturnObjects set to true will return FileResource objects which store much more information and can be used to get to things such as the 
	* relative path, the directory the relative path was found in, or the frontend path which is used to directly render a file to the user agent.
	* If $bByExpressions and $bFindAll are set to false, only a single string/object is returned (null if not found). Otherwise, an array is returned.
	* If $bFindAll is set, the returned array is index-based; if only $bByExpressions is set, the returned array’s keys are the relative paths of the respective files.
	* @param array|string $mRelativePath relative path to search for in base, plugins or site folders. This can be an array or a string of /-separated directory/file names.
	* @param int $iFlag can be one of either ResourceFinder::SEARCH_MAIN_ONLY, ResourceFinder::SEARCH_BASE_ONLY, ResourceFinder::SEARCH_SITE_ONLY, ResourceFinder::SEARCH_PLUGINS_ONLY, ResourceFinder::SEARCH_BASE_FIRST, ResourceFinder::SEARCH_SITE_FIRST, ResourceFinder::SEARCH_PLUGINS_FIRST. The *_ONLY constants are just for convenience since they only find files in specific directories, you might just as well do file_exists(MAIN_DIR.'my/dir').
	* @param boolean $bByExpressions If set, $mRelativePath becomes not a fixed set of names but an array of regular expressions to evaluate against possible matches. This is slow when used on large directories. There are the following special values which can be used in the expression: ${parent_name} and ${parent_name_camelized} which do exactly what you would expect. For convenience, any array item not starting with a slash is considered to be a regular file name. This means that a slash is the only accepted delimiter.
	* @param boolean $bFindAll If set, all matching files will be returned even if they have the same relative path inside different instance prefixes. Note: when used in conjunction with $bByExpressions, the return value becomes an index-based array since there could be duplicate relative urls.
	* @param boolean $bReturnObjects If set, all returned paths become FileResource objects. This is much cheaper than calling new FileResource() on the returned value(s) because a) FileResource objects are used internally by findResource and b) the additional information maintained by FileResource was added when it was already known and does not have to be deducted.
	* @return mixed
	*/
	public static function findResource($mRelativePath, $iFlag = null, $bByExpressions = false, $bFindAll = false, $bReturnObjects = false) {
		$bWaitForAll = $bByExpressions && $bFindAll;
		if($bByExpressions) {
			$bFindAll = true;
		}
		self::processArguments($mRelativePath, $iFlag, $bFindAll);
		$mResult = array();
		foreach(self::buildSearchPathList($iFlag) as $sSearchPath) {
			$sInstancePrefix = substr(realpath($sSearchPath), strlen(realpath(MAIN_DIR))+1);
			if($sInstancePrefix === false) {
				$sInstancePrefix = '';
			}
			$mPath = null;
			if($bByExpressions) {
				$mPath = self::findInPathByExpressions($mRelativePath, $sSearchPath, $sInstancePrefix);
				if($bWaitForAll) {
					$mPath = array_values($mPath);
				}
			} else {
				$mPath = self::findInPath($mRelativePath, $sSearchPath, $sInstancePrefix);
			}
			if($mPath) {
				if($bFindAll) {
					if(!$bByExpressions) {
						$mPath = array($mPath);
					}
					$mResult = array_merge($mResult, $mPath);
				} else {
					return self::returnFromFindResource($mPath, $bReturnObjects);
				}
			}
		}
		
		if($bFindAll) {
			return self::returnFromFindResource($mResult, $bReturnObjects);
		}
		
		return null;
	}
	
	private static function returnFromFindResource(&$mResult, $bReturnObjects) {
		if($bReturnObjects) {
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
	
	/**
	* Shorthand for {@link ResourceFinder::findResource()} with $bFindAll set.
	*/
	public static function findAllResources($mRelativePath, $iFlag = null) {
		return self::findResource($mRelativePath, $iFlag, false, true, false);
	}
	
	
	/**
	* Shorthand for {@link ResourceFinder::findResource()} with $bByExpressions set.
	*/
	public static function findResourceByExpressions($aExpressions, $iFlag = null) {
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
	* Shorthand for {@link ResourceFinder::findResource()} with $bByExpressions and $bReturnObjects set.
	*/
	public static function findResourceObjectByExpressions($aExpressions, $iFlag = null) {
		return self::findResource($aExpressions, $iFlag, true, false, true);
	}
	
	/**
	* Shorthand for {@link ResourceFinder::findResource()} with $bFindAll, $bByExpressions and $bReturnObjects set.
	*/
	public static function findAllResourceObjectsByExpressions($aExpressions, $iFlag = null) {
		return self::findResource($aExpressions, $iFlag, true, true, true);
	}
	
	public static function buildSearchPathList($iFlag) {
		switch($iFlag) {
			case self::SEARCH_MAIN_ONLY: return array(MAIN_DIR);
			case self::SEARCH_BASE_ONLY: return array(BASE_DIR);
			case self::SEARCH_SITE_ONLY: return array(SITE_DIR);
			case self::SEARCH_PLUGINS_ONLY: return self::getPluginPaths();
		}
		$aResult = self::getPluginPaths();
		switch($iFlag) {
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
	
	private static function findInPathByExpressions($aExpressions, $sPath, $sInstancePrefix, $sRelativePath = null) {
		if(count($aExpressions) === 0) {
			return array();
		}
		
		$aResult = array();
		$sPathExpression = $aExpressions[0];
		$sParentName = null;
		if($sRelativePath !== null) {
			$sParentName = explode('/', $sRelativePath);
			$sParentName = $sParentName[count($sParentName)-1];
		}
		
		if($sParentName !== null) {
			$sPathExpression = str_replace('${parent_name}', $sParentName, $sPathExpression);
			$sPathExpression = str_replace('${parent_name_camelized}', StringUtil::camelize($sParentName, true), $sPathExpression);
		}
		
		if(!StringUtil::startsWith($sPathExpression, "/")) {
			//Take the shortcut when only dealing with a static file name
			$sFilePath = "$sPath/$sPathExpression";
			if($sRelativePath === null) {
				$sNextRelativePath = $sPathExpression;
			} else {
				$sNextRelativePath = "$sRelativePath/$sPathExpression";
			}
			if(!file_exists($sFilePath)) {
				return array();
			}
			if(count($aExpressions) > 1) {
				return self::findInPathByExpressions(array_slice($aExpressions, 1), $sFilePath, $sInstancePrefix, $sNextRelativePath);
			} else {
				return array($sNextRelativePath => new FileResource($sFilePath, $sInstancePrefix, $sNextRelativePath));
			}
		} else {
			foreach(ResourceFinder::getFolderContents($sPath) as $sFileName => $sFilePath) {
				if(preg_match($sPathExpression, $sFileName) !== 0) {
					$sNextRelativePath = $sFileName;
					if($sRelativePath !== null) {
						$sNextRelativePath = "$sRelativePath/$sFileName";
					}
					if(count($aExpressions) > 1) {
						$aNewResult = self::findInPathByExpressions(array_slice($aExpressions, 1), $sFilePath, $sInstancePrefix, $sNextRelativePath);
						$aResult = array_merge($aResult, $aNewResult);
					} else {
						$aResult[$sNextRelativePath] = new FileResource($sFilePath, $sInstancePrefix, $sNextRelativePath);
					}
				}
			}
		}
		
		return $aResult;
	}
	
	private static function getPluginPaths() {
		if(self::$PLUGINS === null) {
			self::$PLUGINS = array_values(ResourceFinder::findResourceByExpressions(array(DIRNAME_PLUGINS, self::ANY_NAME_OR_TYPE_PATTERN), self::SEARCH_MAIN_ONLY));
		}
		return self::$PLUGINS;
	}
	
	//Helper function for classes that are given a filename, base path and path name
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